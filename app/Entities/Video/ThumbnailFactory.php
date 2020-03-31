<?php


namespace App\Entities\Video;


class ThumbnailFactory
{
    public static function makeVideoFromApiStruct($struct): Thumbnail
    {
        return new Thumbnail($struct->url ?? '', $struct->width ?? 0, $struct->height ?? 0);
    }
}
