<?php

namespace InvisionApi\Endpoints\System;

use InvisionApi\Exceptions\ApiException;

class User extends \InvisionApi\Endpoints\AbstractEndpoint
{
    const ENDPOINT = 'core/me/';

    /**
     * Get basic information about the authorized user
     * GET /core/me
     * OAuth only endpoint
     * @throws ApiException
     * @return \stdClass
     */
    public function me(): \stdClass
    {
        /** @param \Psr\Http\Message\ResponseInterface $response */
        $response = $this->client->request('GET', static::ENDPOINT, $this->api->opts());
        return $this->parseResponse($response);
    }

    /**
     * Get authorized user's email address
     * GET /core/me/email
     * OAuth only endpoint
     * @throws ApiException
     * @return \stdClass
     */
    public function email(): \stdClass
    {
        /** @param \Psr\Http\Message\ResponseInterface $response */
        $response = $this->client->request('GET', static::ENDPOINT . 'email', $this->api->opts());
        return $this->parseResponse($response);
    }
}