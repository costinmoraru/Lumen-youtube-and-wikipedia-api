<?php


namespace App\Services\Google;


use Exception;


class GoogleQuotaException extends Exception
{
    public static function quotaWillExceed()
    {
        return new self('Google API quota will exceed. Please wait 1 hour and try again.');
    }
}
