<?php


namespace App\Providers;


use App\Repository\Config\CountryRepository;
use App\Repository\CountryRepositoryInterface;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\GoogleApiRepository;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\GoogleApiRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(GoogleApiRepositoryInterface::class, GoogleApiRepository::class);
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
    }
}
