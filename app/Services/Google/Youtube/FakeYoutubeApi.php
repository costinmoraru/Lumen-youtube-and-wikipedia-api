<?php


namespace App\Services\Google\Youtube;


use App\Entities\Video\Thumbnail;
use App\Entities\Video\Video;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\PromiseInterface;

class FakeYoutubeApi implements YoutubeApiInterface
{
    /**
     * @param string|null $regionCode
     * @return PromiseInterface
     */
    public function mostPopularVideos(?string $regionCode = null): PromiseInterface
    {
        $promise = new Promise(function () use (&$promise) {
            $videos = [];
            for ($i = 0; $i < 5; $i++) {
                $videos[] = new Video(
                    'Test description',
                    new Thumbnail('test_url', 100, 200),
                    new Thumbnail('test_url', 300, 400),
                );
            }
            $promise->resolve($videos);
        });
        return $promise;
    }
}
