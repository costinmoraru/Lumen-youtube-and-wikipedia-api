<?php

namespace App\Http\Controllers;

use App\Repository\CountryRepositoryInterface;
use App\Services\Google\GoogleQuotaException;
use App\Services\DigAssignment\HandleMostPopularVideos;
use App\Services\DigAssignment\HandleWikipediaPages;
use App\Transformers\CountryTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class CountryController extends Controller
{
    /**
     * @var CountryRepositoryInterface
     */
    private CountryRepositoryInterface $countryRepository;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CountryRepositoryInterface $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    /**
     * @param HandleMostPopularVideos $videosHandler
     * @param HandleWikipediaPages $wikipediaHandler
     * @return JsonResponse
     */
    public function index(HandleMostPopularVideos $videosHandler, HandleWikipediaPages $wikipediaHandler)
    {
        // 1. Get countries
        $offset = (int) Request::input('offset', 0);
        $limit = Request::input('limit', null);
        $limit = $limit ? (int) $limit : null;
        $countries = $this->countryRepository->get($offset, $limit);

        // 2. Enrich countries with most popular Youtube videos
        try {
            $videosHandler->enrichWithVideos($countries);
        } catch (GoogleQuotaException $e) {
            return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ],405
            );
        }

        // 3. Enrich countries with wikipedia text
        $wikipediaHandler->enrichWithWikipediaText($countries);

        return response()->json(
            fractal($countries, new CountryTransformer())->toArray()['data'],
            200
        );
    }
}
