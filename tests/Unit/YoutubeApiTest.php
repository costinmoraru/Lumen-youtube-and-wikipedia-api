<?php


namespace Unit;

use App\Entities\Video\Video;
use App\Services\Google\GoogleApiErrorException;
use App\Services\Google\Youtube\YoutubeApiInterface;
use App\Services\Google\Youtube\FakeYoutubeApi;
use App\Services\Google\Youtube\YoutubeApi;
use TestCase;

class YoutubeApiTest extends TestCase
{
    /** @test */
    public function youtube_api_does_not_work_with_invalid_api_key()
    {
        $youtubeApi = new YoutubeApi('invalid-api-key');
        $this->app->instance(YoutubeApiInterface::class, $youtubeApi);

        $promise = $youtubeApi->mostPopularVideos('gb');
        $exception = $promise->wait();

        $this->assertInstanceOf(GoogleApiErrorException::class, $exception);
        $this->assertEquals(400, $exception->response->getStatusCode());
    }

    /** @test */
    public function youtube_api_returns_promise_with_array_of_videos_on_success_callback()
    {
        $fakeYoutubeApi = new FakeYoutubeApi();
        $this->app->instance(YoutubeApiInterface::class, $fakeYoutubeApi);

        $promise = $fakeYoutubeApi->mostPopularVideos('gb');
        $response = $promise->wait();

        $this->assertIsArray($response);
        $this->assertInstanceOf(Video::class, reset($response));
    }
}
