<?php


namespace App\Services\Google\Youtube;

use App\Entities\Video\VideoFactory;
use App\Services\Google\GoogleApiErrorException;
use App\Services\Google\LogGoogleApiRequest;
use Google_Client;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;

class YoutubeApi implements YoutubeApiInterface
{
    /** @var mixed */
    protected $httpClient;

    protected string $uri;

    protected array $params;


    public function __construct($apiKey)
    {
        $client = new Google_Client();
        $client->setDeveloperKey($apiKey);
        $this->httpClient = $client->authorize();
    }

    /**
     * @param $params
     */
    protected function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * @param $uri
     */
    protected function setUri($uri)
    {
        $this->uri = $uri;
    }


    /**
     * @param string|null $regionCode
     * @return PromiseInterface
     */
    public function mostPopularVideos(?string $regionCode = null): PromiseInterface
    {
        $this->setParams([
            'query' => [
                'part' => 'snippet,contentDetails,statistics',
                'chart' => 'mostPopular',
                'regionCode' => $regionCode ?? ''
            ]
        ]);
        $this->setUri('https://www.googleapis.com/youtube/v3/videos');

        return $this->httpClient
            ->requestAsync('get', $this->uri, $this->params)
            ->then(function (ResponseInterface $response) {
                $responseContent = json_decode($response->getBody()->getContents(), false);
                LogGoogleApiRequest::log()
                    ->setService('youtube')
                    ->setMethod('most-popular-videos')
                    ->setStatusCode($response->getStatusCode())
                    ->setResponseContent($responseContent)
                    ->save();

                if ($response->getStatusCode() === 200) {
                    $videos = [];
                    foreach ($responseContent->items as $item) {
                        $videos[] = VideoFactory::makeVideoFromApiItem($item);
                    }
                    return $videos;
                }

                /// if api returned code !== 200, return exception
                return new GoogleApiErrorException($response);
            });
    }
}
