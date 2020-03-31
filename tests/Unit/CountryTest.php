<?php

namespace Unit;

use App\Repository\CountryRepositoryInterface;
use TestCase;

class CountryTest extends TestCase
{
    /** @test */
    public function countries_can_be_retrieved_with_limit_and_offset()
    {
        /// set limit and offset
        $limit = 3;
        $offset = 2;

        /// get countries
        /** @var CountryRepositoryInterface $countryRepository */
        $countryRepository = app()->make(CountryRepositoryInterface::class);
        $countries = $countryRepository->get($offset, $limit);
        $allCountries = $countryRepository->all();

        /// verify the number of countries
        /// verify the offset
        $this->assertEquals($limit, $countries->count());
        $this->assertEquals($allCountries->slice($offset)->first(), $countries->first());
    }

    /** @test */
    public function large_limit_returns_all_countries()
    {
        /// set large limit
        /** @var CountryRepositoryInterface $countryRepository */
        $countryRepository = app()->make(CountryRepositoryInterface::class);
        $allCountries = $countryRepository->all();
        $limit = $allCountries->count() + 1000;

        /// get countries
        $countries = $countryRepository->get(0, $limit);


        /// verify number of countries
        $this->assertEquals($allCountries->count(), $countries->count());
    }

    /** @test */
    public function large_offset_returns_no_countries()
    {
        /// set large offset
        /** @var CountryRepositoryInterface $countryRepository */
        $countryRepository = app()->make(CountryRepositoryInterface::class);
        $allCountries = $countryRepository->all();
        $offset = $allCountries->count() + 1;

        /// get countries
        $countries = $countryRepository->get($offset, 1);


        /// verify number of countries
        $this->assertEmpty($countries);
    }
}
