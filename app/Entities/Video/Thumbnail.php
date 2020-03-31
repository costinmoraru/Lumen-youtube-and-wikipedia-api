<?php


namespace App\Entities\Video;


class Thumbnail
{
    public string $url;

    public int $width;

    public int $height;

    /**
     * Thumbnail constructor.
     * @param string $url
     * @param int $width
     * @param int $height
     */
    public function __construct(string $url, int $width, int $height)
    {
        $this->url = $url;
        $this->width = $width;
        $this->height = $height;
    }


}
