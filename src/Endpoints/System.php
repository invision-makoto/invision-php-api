<?php

namespace InvisionApi\Endpoints;
use InvisionApi\Exceptions\ApiException;

class System extends AbstractEndpoint
{
    const ENDPOINT = 'core/';

    /**
     * Get basic information about the community
     * GET /core/hello
     * @throws ApiException
     * @return \stdclass
     */
    public function ping(): \stdClass
    {
        /** @param \Psr\Http\Message\ResponseInterface $response */
        $response = $this->client->request('GET', static::ENDPOINT . 'hello', $this->api->opts());
        return $this->parseResponse($response);
    }

    /**
     * Club endpoints
     * /core/clubs
     * @return System\Clubs
     */
    public function clubs(): System\Clubs
    {
        return new System\Clubs($this->api);
    }
}