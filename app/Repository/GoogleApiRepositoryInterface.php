<?php


namespace App\Repository;


use DateTimeInterface;

interface GoogleApiRepositoryInterface
{

    /**
     * @param DateTimeInterface|null $date
     * @return int
     */
    public function getUsedQuotaPerDay($date = null): int;
}
