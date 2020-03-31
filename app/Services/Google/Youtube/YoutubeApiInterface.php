<?php


namespace App\Services\Google\Youtube;


use GuzzleHttp\Promise\PromiseInterface;

interface YoutubeApiInterface
{
    /**
     * @param string|null $regionCode
     * @return PromiseInterface
     */
    public function mostPopularVideos(?string $regionCode = null): PromiseInterface;
}
