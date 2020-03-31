<?php

namespace Feature;

use App\Services\Google\Youtube\FakeYoutubeApi;
use App\Services\Google\Youtube\YoutubeApiInterface;
use App\Services\Wikipedia\FakeWikipediaApi;
use App\Services\Wikipedia\WikipediaApiInterface;
use TestCase;

class GetCountriesTest extends TestCase
{
    /** @test */
    public function get_status_code_405_when_quota_will_exceed()
    {
        // set low quota
        config()->set('google.daily_quota', 1);

        // get countries
        $response = $this->get('/country');

        // asert code 405
        $response->assertResponseStatus(405);
    }

    /** @test */
    public function get_countries_return_expected_result()
    {
        $fakeYoutubeApi = new FakeYoutubeApi();
        $this->app->instance(YoutubeApiInterface::class, $fakeYoutubeApi);

        $fakeWikipediaApi = new FakeWikipediaApi();
        $this->app->instance(WikipediaApiInterface::class, $fakeWikipediaApi);

        // get countries
        $response = $this->get('/country');
        $decodedJson = json_decode($response->response->getContent(), false);

        // assert code 200
        $this->assertResponseStatus(200);

        $country = $decodedJson[0];
        $this->assertObjectHasAttribute('countryCode', $country);
        $this->assertObjectHasAttribute('mostPopularYoutubeVideos', $country);
        $this->assertIsArray($country->mostPopularYoutubeVideos);
        $this->assertObjectHasAttribute('wikipediaText', $country);
        $this->assertIsString($country->wikipediaText);
    }
}
