<?php

namespace App\Providers;

use App\Services\Google\Youtube\YoutubeApi;
use App\Services\Google\Youtube\YoutubeApiInterface;
use App\Services\Wikipedia\WikipediaApi;
use App\Services\Wikipedia\WikipediaApiInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(YoutubeApiInterface::class, fn() => new YoutubeApi(config('google.api_key')));
        $this->app->bind(WikipediaApiInterface::class, WikipediaApi::class);
    }
}
