<?php


namespace App\Transformers;


use App\Entities\Country;
use League\Fractal\TransformerAbstract;

class CountryTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Country $country
     * @return array
     */
    public function transform(Country $country)
    {
        return [
            'countryCode' => $country->getCountryCode(),
            'mostPopularYoutubeVideos' => $country->getVideos(),
            'wikipediaText' => $country->getWikipediaText(),
        ];
    }
}
