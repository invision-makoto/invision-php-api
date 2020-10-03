<?php

namespace InvisionApi\Endpoints\System;

use InvisionApi\Exceptions\ApiException;

class Members extends \InvisionApi\Endpoints\AbstractEndpoint
{
    const ENDPOINT = 'core/members/';

    const CONTENT_ACTION_NONE = 'leave';
    const CONTENT_ACTION_DELETE = 'delete';
    const CONTENT_ACTION_HIDE = 'hide';

    /**
     * Get list of members
     * GET /core/members
     * @param int $page Page number
     * @param int $perPage Number of results per page - defaults to 25
     * @param array $parameters Additional search paremeters
     * @throws ApiException
     * @return \stdClass
     */
    public function list(int $page = 1, int $perPage = 25, ?array $parameters = []): \stdClass
    {
        /** @param \Psr\Http\Message\ResponseInterface $response */
        $response = $this->client->request('GET', static::ENDPOINT, $this->api->opts([
            'query' => \array_merge_recursive(['page' => $page,'perPage' => $perPage], (array)$parameters)
        ]));
        return $this->parseResponse($response);
    }

    /**
     * Get information about a specific member
     * GET /core/members/{id}
     * @param int $id member ID
     * @param array $otherFields An array of additional non-standard fields to return via the REST API
     * @throws ApiException
     * @return \stdclass
     */
    public function get(int $id, ?array $otherFields = []): \stdClass
    {
        /** @param \Psr\Http\Message\ResponseInterface $response */
        $response = $this->client->request('GET', static::ENDPOINT . $id, $this->api->opts([
            'query' => ['otherFields' => (array)$otherFields]
        ]));
        return $this->parseResponse($response);
    }

    /**
     * Create a member. Requires the standard login handler to be enabled
     * POST /core/members
     * API only endpoint
     * @param array $parameters Creation field parameters
     * @throws ApiException
     * @return \stdclass
     */
    public function create(array $parameters): \stdClass
    {
        /** @param \Psr\Http\Message\ResponseInterface $response */
        $response = $this->client->request('POST', static::ENDPOINT, $this->api->opts([
            'form_params' => $parameters
        ]));
        return $this->parseResponse($response);
    }

    /**
     * Edit a member
     * POST /core/members/{id}
     * API only endpoint
     * @param int $id member ID
     * @param array $parameters Edit field parameters
     * @throws ApiException
     * @return \stdclass
     */
    public function edit(int $id, array $parameters): \stdClass
    {
        /** @param \Psr\Http\Message\ResponseInterface $response */
        $response = $this->client->request('POST', static::ENDPOINT . $id, $this->api->opts([
            'form_params' => $parameters
        ]));
        return $this->parseResponse($response);
    }

    /**
     * Delete a member
     * DELETE /core/members/{id}
     * API only endpoint
     * @param int $id member ID
     * @param string|null $contentAction Dictates whether to delete, hide, or leave a members content
     * @param bool $contentAnonymize Keep member name or anonymize content
     * @throws ApiException
     * @return void
     */
    public function delete(int $id, ?string $contentAction = self::CONTENT_ACTION_NONE, bool $contentAnonymize = false)
    {
        $contentAction = $contentAction ?? self::CONTENT_ACTION_NONE;

        /** @param \Psr\Http\Message\ResponseInterface $response */
        $response = $this->client->request('DELETE', static::ENDPOINT . $id, $this->api->opts([
            'query' => [
                'contentAction' => $contentAction,
                'contentAnonymize' => $contentAnonymize ? 'true' : 'false'
            ]
        ]));
        return $this->parseResponse($response);
    }
}