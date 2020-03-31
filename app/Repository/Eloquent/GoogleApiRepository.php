<?php


namespace App\Repository\Eloquent;

use App\Entities\GoogleApi;
use App\Repository\GoogleApiRepositoryInterface;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Support\Facades\DB;

class GoogleApiRepository extends BaseRepository implements GoogleApiRepositoryInterface
{

    public function __construct(GoogleApi $model)
    {
        parent::__construct($model);
    }

    /**
     * @param DateTimeInterface|null $date
     * @return int
     */
    public function getUsedQuotaDaily($date = null): int
    {
        $date = $date ?? Carbon::today();

        return DB::table('google_api')
            ->where('status_code', 200)
            ->whereDate('created_at', '>=', $date->format('Y-m-d'))
            ->whereDate('created_at', '<', $date->addDay()->format('Y-m-d'))
            ->sum('quota');
    }
}
