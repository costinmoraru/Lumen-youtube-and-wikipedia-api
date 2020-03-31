<?php


namespace App\Services\Google;


use Exception;
use Psr\Http\Message\ResponseInterface;

class GoogleApiErrorException extends Exception
{

    /** @var ResponseInterface */
    public ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        parent::__construct('GoogleApi Error', $response->getStatusCode());
        $this->response = $response;
    }
}
