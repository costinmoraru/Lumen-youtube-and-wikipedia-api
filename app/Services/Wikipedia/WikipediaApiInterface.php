<?php


namespace App\Services\Wikipedia;


interface WikipediaApiInterface
{
    /**
     * @param string $page
     * @param int|null $section
     * @return string
     */
    public function getPageSection(string $page, ?int $section = 0): string;
}
