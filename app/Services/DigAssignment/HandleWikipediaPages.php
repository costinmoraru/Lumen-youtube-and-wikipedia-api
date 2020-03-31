<?php


namespace App\Services\DigAssignment;


use App\Entities\Country;
use App\Services\Wikipedia\WikipediaApiInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class HandleWikipediaPages
{

    private WikipediaApiInterface $wikipediaApi;


    /**
     * HandleWikipediaPages constructor.
     * @param WikipediaApiInterface $wikipediaApi
     */
    public function __construct(WikipediaApiInterface $wikipediaApi)
    {
        $this->wikipediaApi = $wikipediaApi;
    }

    /**
     * @param Collection $countries
     */
    public function enrichWithWikipediaText($countries): void
    {
        foreach ($countries as $country) {
            /** @var Country $country */
            $country->setWikipediaText($this->getFirstParagraphsFromPage($country->getWikipediaPage()));
        }
    }

    /**
     * @param string $page
     * @return string
     */
    public function getFirstParagraphsFromPage($page): string
    {
        $text = $this->wikipediaApi->getPageSection($page, 0);
        $text = Str::before($text, '<div class="mw-references-wrap');
        $text = Str::afterLast($text, 'table>');
        return $text;
    }
}
