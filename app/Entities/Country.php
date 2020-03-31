<?php


namespace App\Entities;


use App\Entities\Video\Video;

class Country
{
    private string $countryCode;

    private string $wikipediaPage;

    /**
     * @var Video[]
     */
    private array $videos = [];


    private string $wikipediaText = '';

    /**
     * Country constructor.
     * @param string $countryCode
     * @param string $wikipediaPage
     */
    public function __construct(string $countryCode, string $wikipediaPage)
    {
        $this->countryCode = $countryCode;
        $this->wikipediaPage = $wikipediaPage;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @return string
     */
    public function getWikipediaPage(): string
    {
        return $this->wikipediaPage;
    }

    /**
     * @return Video[]
     */
    public function getVideos(): array
    {
        return $this->videos;
    }

    /**
     * @return string
     */
    public function getWikipediaText(): string
    {
        return $this->wikipediaText;
    }

    /**
     * @param string $wikipediaText
     */
    public function setWikipediaText(string $wikipediaText): void
    {
        $this->wikipediaText = $wikipediaText;
    }

    /**
     * @param Video[] $videos
     */
    public function setVideos(array $videos): void
    {
        $this->videos = $videos;
    }
}
