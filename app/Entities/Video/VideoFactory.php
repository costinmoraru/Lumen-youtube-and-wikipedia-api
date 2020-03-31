<?php


namespace App\Entities\Video;


class VideoFactory
{
    /**
     * @param $struct
     * @return Video
     */
    public static function makeVideoFromApiItem($struct): Video
    {
        $description = $struct->snippet->description ?? '';
        $defaultThumbnail = ThumbnailFactory::makeVideoFromApiStruct($struct->snippet->thumbnails->default ?? null);
        $highResThumbnail = ThumbnailFactory::makeVideoFromApiStruct($struct->snippet->thumbnails->high ?? null);

        return new Video($description, $defaultThumbnail, $highResThumbnail);
    }

    /**
     * @param $struct
     * @return Video
     */
    public static function makeVideoFromCache($struct): Video
    {
        $description = $struct->description ?? '';
        $defaultThumbnail = ThumbnailFactory::makeVideoFromApiStruct($struct->defaultThumbnail ?? null);
        $highResThumbnail = ThumbnailFactory::makeVideoFromApiStruct($struct->highResThumbnail ?? null);

        return new Video($description, $defaultThumbnail, $highResThumbnail);
    }
}
