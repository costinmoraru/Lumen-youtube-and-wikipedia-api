<?php


namespace App\Services\DigAssignment;

use App\Entities\Country;
use App\Entities\Video\VideoFactory;
use App\Services\Google\GoogleQuotaException;
use App\Services\Google\Youtube\YoutubeApiInterface;
use GuzzleHttp\Promise;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Psr\Http\Message\ResponseInterface;

class HandleMostPopularVideos
{

    /**
     * @var YoutubeApiInterface
     */
    private YoutubeApiInterface $youtubeApi;

    public function __construct(YoutubeApiInterface $youtubeApi)
    {
        $this->youtubeApi = $youtubeApi;
    }

    /**
     * @param Collection $countries
     * @throws GoogleQuotaException
     */
    public function enrichWithVideos($countries): void
    {
        $countriesToRequestFromYoutube = $countries->count() - $this->getFromCache($countries);

        if ($countriesToRequestFromYoutube && Quota::willExceed($countriesToRequestFromYoutube)) {
            throw GoogleQuotaException::quotaWillExceed();
        }

        $promises = [];
        foreach ($countries as $country) {
            if (!$country->getVideos()) {
                // send requests are create promises
                $promises[$country->getCountryCode()] = $this->youtubeApi->mostPopularVideos($country->getCountryCode());

                // execute successful callback and attach videos to country
                $promises[$country->getCountryCode()]->then(
                    /// success callback function
                    function ($response) use ($country) {
                        if ($response instanceof ResponseInterface) {
                            return;
                        }
                        if (is_array($response)) {
                            $country->setVideos($response);
                            $this->storeInCache($country);
                            return;
                        }
                    });
            }
        }

        if ($promises) {
            // wait for all the promises to finish
            Promise\settle($promises)->wait();
        }
    }

    /**
     * Returns the number of countries that have videos in cache
     *
     * @param $countries
     * @return int
     */
    private function getFromCache($countries): int
    {
        $countriesFromCache = 0;
        foreach ($countries as $country) {
            if (Cache::has('mostPopularYoutubeVideos:' . $country->getCountryCode())) {
                $videos = [];
                $videosCache = json_decode(Cache::get('mostPopularYoutubeVideos:' . $country->getCountryCode()), false);
                foreach ($videosCache as $video) {
                    $videos[] = VideoFactory::makeVideoFromCache($video);
                }
                if (count($videos)) {
                    $country->setVideos($videos);
                    $countriesFromCache++;
                }
            }
        }
        return $countriesFromCache;
    }

    /**
     * @param Country $country
     * @return void
     */
    private function storeInCache(Country $country): void
    {
        Cache::add('mostPopularYoutubeVideos:' . $country->getCountryCode(), json_encode($country->getVideos()), 3600);
    }

}
