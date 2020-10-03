<?php

namespace InvisionApi\Endpoints;
use InvisionApi\Exceptions\ServerException;
use InvisionApi\Exceptions\TokenException;

abstract class AbstractEndpoint
{
    /**
     * Invisian API client
     * @var \InvisionApi\Api
     */
    protected $api;

    /**
     * HTTP client for the abstract endpoint
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Invision API endpoint interface
     * @param \InvisionApi\Api $api
     * @return void
     */
    public function __construct( \InvisionApi\Api $api )
    {
        $this->api = $api;
        $this->client = $api->client;
    }

    /**
     * Parse an API response and check for errors
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \stdClass
     */
    public function parseResponse(\Psr\Http\Message\ResponseInterface $response): \stdClass
    {
        // Any errors?
        if ( $response->getStatusCode() !== 200 )
        {
            $data = \json_decode($response->getBody());
            if (!\property_exists($data, 'errorMessage'))
            {
                throw new ServerException((string)$response->getStatusCode(), 'UNKNOWN_ERROR');
            }

            switch ($data->errorMessage)
            {
                case 'NO_API_KEY':
                case 'INVALID_API_KEY':
                case 'INVALID_ACCESS_TOKEN':
                case 'EXPIRED_ACCESS_TOKEN':
                    throw new TokenException($data->errorCode, $data->errorMessage);

                default:
                    throw new ServerException($data->errorCode, $data->errorMessage);
            }
        }

        return \json_decode($response->getBody());
    }
}