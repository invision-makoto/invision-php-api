<?php

namespace InvisionApi\Endpoints;

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
}