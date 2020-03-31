<?php


namespace App\Entities\Video;


class Video
{
    public string $description;

    public Thumbnail $defaultThumbnail;

    public Thumbnail $highResThumbnail;

    /**
     * Video constructor.
     * @param string $description
     * @param Thumbnail $defaultThumbnail
     * @param Thumbnail $highResThumbnail
     */
    public function __construct(string $description, Thumbnail $defaultThumbnail, Thumbnail $highResThumbnail)
    {
        $this->description = $description;
        $this->defaultThumbnail = $defaultThumbnail;
        $this->highResThumbnail = $highResThumbnail;
    }
}
