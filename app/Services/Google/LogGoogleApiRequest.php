<?php


namespace App\Services\Google;


use App\Entities\GoogleApi;

class LogGoogleApiRequest
{
    private int $quota = 1;

    private string $service = 'google';

    private string $method = '';

    private int $statusCode = 0;

    /**
     * @var mixed
     */
    private $responseContent;


    /**
     * @return LogGoogleApiRequest
     */
    public static function log(): LogGoogleApiRequest
    {
        return new self();
    }

    /**
     * @param int $quota
     * @return LogGoogleApiRequest
     */
    public function setQuota(int $quota): LogGoogleApiRequest
    {
        $this->quota = $quota;
        return $this;
    }

    /**
     * @param string $service
     * @return LogGoogleApiRequest
     */
    public function setService(string $service): LogGoogleApiRequest
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @param string $method
     * @return LogGoogleApiRequest
     */
    public function setMethod(string $method): LogGoogleApiRequest
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param int $statusCode
     * @return LogGoogleApiRequest
     */
    public function setStatusCode(int $statusCode): LogGoogleApiRequest
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @param mixed $responseContent
     * @return LogGoogleApiRequest
     */
    public function setResponseContent($responseContent): LogGoogleApiRequest
    {
        $this->responseContent = $responseContent;
        return $this;
    }



    public function save()
    {
        $attributes = [
            'quota' => $this->quota,
            'service' => $this->service,
            'method' => $this->method,
            'response' => $this->responseContent,
            'status_code' => $this->statusCode,
        ];
        GoogleApi::create($attributes);
    }
}
