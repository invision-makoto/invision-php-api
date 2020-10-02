<?php

namespace InvisionApi\Endpoints;

interface EndpointInterface
{
    /**
     * Invisian API client
     * @var \InvisionApi\Api
     */
    private $api;

    /**
     * Invision API endpoint interface
     * @param \InvisionApi\Api $api
     * @return void
     */
    public function __construct( \InvisionApi\Api $api )
    {
        $this->api = $api;
    }
}