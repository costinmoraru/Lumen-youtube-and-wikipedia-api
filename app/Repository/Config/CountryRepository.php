<?php


namespace App\Repository\Config;


use App\Entities\Country;
use App\Repository\CountryRepositoryInterface;
use Illuminate\Support\Collection;

class CountryRepository implements CountryRepositoryInterface
{
    /**
     * @return Collection|mixed
     */
    public function all(): Collection
    {
        return collect(config('countries'))->mapWithKeys(function ($country) {
            return [
                $country['country-code'] => new Country($country['country-code'], $country['wikipedia-page'])
            ];
        });
    }

    /**
     * @param int $offset
     * @param int|null $limit
     * @return Collection
     */
    public function get(int $offset = 0, ?int $limit = null): Collection
    {
        if (!$limit && !$offset) {
            return $this->all();
        }

        return collect(config('countries'))->slice($offset, $limit)->mapWithKeys(function ($country) {
            return [
                $country['country-code'] => new Country($country['country-code'], $country['wikipedia-page'])
            ];
        });
    }

}
