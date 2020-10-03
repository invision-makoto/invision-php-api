<?php

namespace InvisionApi\Endpoints\System;

use InvisionApi\Exceptions\ServerException;
use InvisionApi\Exceptions\ApiException;

class Clubs extends \InvisionApi\Endpoints\AbstractEndpoint
{
    const ENDPOINT = 'core/clubs/';

    /**
     * Get list of clubs
     * GET /core/clubs
     * @param int $page Page number
     * @param int $perPage Number of results per page - defaults to 25
     * @throws ApiException
     * @return \stdClass
     */
    public function list(int $page = 1, int $perPage = 25)
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
     * Get specific club
     * GET /core/clubs/{id}
     * @param int $id Club ID
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
     * Create a club
     * POST /core/clubs
     * @param int $id Club ID
     * @param array $parameters Edit field parameters
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
     * Edit a club
     * POST /core/clubs/{id}
     * @param int $id Club ID
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
     * Delete a club
     * DELETE /core/clubs/{id}
     * @param int $id Club ID
     * @throws ApiException
     * @return \stdclass
     */
    public function delete(int $id): \stdClass
    {
        /** @param \Psr\Http\Message\ResponseInterface $response */
        $response = $this->client->request('DELETE', static::ENDPOINT . $id, $this->api->opts());
        return $this->parseResponse($response);
    }

    /**
     * Get members of a club
     * GET /core/clubs/{id}/members
     * @param int $id Club ID
     * @throws ApiException
     * @return \stdclass Returns null if a club has no members
     */
    public function members(int $id): ?\stdClass
    {
        /** @param \Psr\Http\Message\ResponseInterface $response */
        $response = $this->client->request('GET', static::ENDPOINT . "{$id}/members", $this->api->opts());

        try
        {
            return $this->parseResponse($response);
        }
        // API throws an error if there are no members
        catch (ServerException $e)
        {
            if ($e->errorCode === '1C386/I')
            {
                return null;
            }

            throw $e;
        }
    }

    /**
     * Add (or invite) a member to a club
     * POST /core/clubs/{clubId}/members
     * @param int $clubId Club ID
     * @param int $memberId Member ID
     * @param string $status Status of the member being added or updated (member, invited, requested, banned, moderator, leader)
     * @param bool $waiveFee If true and the request is made by a club leader, the join fee will be waived for the member being invited
     * @throws ApiException
     * @return \stdclass
     */
    public function addMember(int $clubId, int $memberId, string $status, bool $waiveFee = false): \stdClass
    {
        /** @param \Psr\Http\Message\ResponseInterface $response */
        $response = $this->client->request('POST', static::ENDPOINT . "{$clubId}/members", $this->api->opts([
            'query' => [
                'id' => $memberId,
                'status' => $status,
                'waiveFee' => (int)$waiveFee
            ]
        ]));
        return $this->parseResponse($response);
    }

    /**
     * Remove a member from a club
     * DELETE /core/clubs/{clubId}/members/{memberId}
     * @param int $clubId Club ID
     * @param int $memberId Member ID
     * @throws ApiException
     * @return \stdclass
     */
    public function removeMember(int $clubId, int $memberId): \stdClass
    {
        /** @param \Psr\Http\Message\ResponseInterface $response */
        $response = $this->client->request('DELETE', static::ENDPOINT . "{$clubId}/members/{$memberId}", $this->api->opts());
        return $this->parseResponse($response);
    }

    /**
     * Get content types that can be created in clubs
     * GET /core/clubs/contenttypes
     * @throws ApiException
     * @return \stdclass
     */
    public function contentTypes(): \stdClass
    {
        /** @param \Psr\Http\Message\ResponseInterface $response */
        $response = $this->client->request('GET', static::ENDPOINT . 'contenttypes', $this->api->opts());
        return $this->parseResponse($response);
    }
}