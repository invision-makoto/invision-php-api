<?php

namespace InvisionApi\Endpoints;

class System extends \InvisionApi\Endpoints\AbstractEndpoint
{
    const ENDPOINT = 'core/';

    /**
     * Invision API endpoint interface
     * @param \InvisionApi\Api $api
     * @return void
     */
    public function __construct(\InvisionApi\Api $api)
    {
        parent::__construct($api);
    }

    /**
     * GET /cote/hello
     * @return \stdclass
     */
    public function ping(): \stdClass
    {
        /** @param \Psr\Http\Message\ResponseInterface $response */
        $response = $this->client->request('GET', static::ENDPOINT . 'hello', $this->api->opts());
        return $this->parseResponse($response);
    }
}