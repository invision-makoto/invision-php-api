<?php

namespace InvisionApi\Endpoints\System;

use InvisionApi\Exceptions\ApiException;

class Groups extends \InvisionApi\Endpoints\AbstractEndpoint
{
    const ENDPOINT = 'core/groups/';

    /**
     * Get list of groups
     * GET /core/groups
     * @param int $page Page number
     * @param int $perPage Number of results per page - defaults to 25
     * @throws ApiException
     * @return \stdClass
     */
    public function list(int $page = 1, int $perPage = 25): \stdClass
    {
        /** @param \Psr\Http\Message\ResponseInterface $response */
        $response = $this->client->request('GET', static::ENDPOINT, $this->api->opts([
            'query' => [
                'page' => $page,
                'perPage' => $perPage
            ]
        ]));
        return $this->parseResponse($response);
    }

    /**
     * Get information about a specific group
     * GET /core/groups/{id}
     * @param int $id Group ID
     * @throws ApiException
     * @return \stdclass
     */
    public function get(int $id): \stdClass
    {
        /** @param \Psr\Http\Message\ResponseInterface $response */
        $response = $this->client->request('GET', static::ENDPOINT . $id, $this->api->opts());
        return $this->parseResponse($response);
    }

    /**
     * Delete a group
     * DELETE /core/groups/{id}
     * @param int $id Group ID
     * @throws ApiException
     * @return void
     */
    public function delete(int $id)
    {
        /** @param \Psr\Http\Message\ResponseInterface $response */
        $response = $this->client->request('DELETE', static::ENDPOINT . $id, $this->api->opts());
        return $this->parseResponse($response);
    }
}