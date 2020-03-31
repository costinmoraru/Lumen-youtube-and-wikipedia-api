<?php


namespace App\Services\DigAssignment;


use App\Repository\GoogleApiRepositoryInterface;

class Quota
{
    /**
     * @return int
     */
    public static function remainingQuota(): int
    {
        /** @var GoogleApiRepositoryInterface $googleApiRepository */
        $googleApiRepository = app()->make(GoogleApiRepositoryInterface::class);
        $usedQuota = $googleApiRepository->getUsedQuotaPerDay();

        return (int)config('google.daily_quota') - $usedQuota;
    }


    /**
     * @param int $numberOfRequests
     * @return bool
     */
    public static function willExceed(int $numberOfRequests): bool
    {
        return self::remainingQuota() < $numberOfRequests;
    }
}
