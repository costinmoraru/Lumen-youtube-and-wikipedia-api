<?php


namespace App\Repository;


use Illuminate\Support\Collection;

interface CountryRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param int $offset
     * @param int|null $limit
     * @return Collection
     */
    public function get(int $offset = 0, ?int $limit = null): Collection;
}
