<?php

namespace InvisionApi\Endpoints;
use InvisionApi\Exceptions\ServerException;
use InvisionApi\Exceptions\TokenException;
use InvisionApi\Exceptions\BannedException;
use InvisionApi\Exceptions\UnauthorizedException;
use InvisionApi\Exceptions\TokenExpiredException;
use InvisionApi\Exceptions\PermissionException;
use InvisionApi\Exceptions\BadRequestException;
use InvisionApi\Exceptions\AppUnavailableException;
use InvisionApi\Exceptions\NotFoundException;
use OAuthException;

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
    public function __construct(\InvisionApi\Api $api)
    {
        $this->api = $api;
        $this->client = $api->client;
    }

    /**
     * Parse an API response and check for errors
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \stdClass
     */
    public function parseResponse(\Psr\Http\Message\ResponseInterface $response): ?\stdClass
    {
        // Any errors?
        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200 and $statusCode !== 201)
        {
            $data = \json_decode($response->getBody());

            // If we didn't get an error message returned, then the server is either down or misconfigured
            if (!\property_exists($data, 'errorMessage'))
            {
                throw new ServerException((string)$statusCode, 'SERVER_ERROR');
            }

            switch ($data->errorMessage)
            {
                case 'NO_API_KEY':
                case 'CANNOT_USE_KEY_AS_URL_PARAM':
                case 'INVALID_API_KEY':
                case 'INVALID_ACCESS_TOKEN':
                    throw new TokenException($data->errorCode, $data->errorMessage);

                case 'EXPIRED_ACCESS_TOKEN':
                    throw new TokenExpiredException($data->errorCode, $data->errorMessage);

                case 'MEMBER_ONLY':
                    throw new OAuthException;

                case 'IP_ADDRESS_BANNED':
                case 'TOO_MANY_REQUESTS_WITH_BAD_KEY':
                    throw new BannedException($data->errorCode, $data->errorMessage);

                case 'IP_ADDRESS_NOT_ALLOWED':
                case 'NO_SCOPES':
                case 'CLIENT_ONLY':
                    throw new UnauthorizedException($data->errorCode, $data->errorMessage);

                case 'NO_PERMISSION':
                case 'CANNOT_CREATE':
                    throw new PermissionException($data->errorCode, $data->errorMessage);

                case 'BAD_METHOD':
                case 'NO_ENDPOINT':
                case 'INVALID_CONTROLLER':
                case 'INVALID_LANGUAGE':
                    throw new BadRequestException($data->errorCode, $data->errorMessage);

                case 'APP_DISABLED':
                case 'INVALID_APP':
                    throw new AppUnavailableException($data->errorCode, $data->errorMessage);

                case 'INVALID_ID':
                case 'INVALID_MEMBER':
                    throw new NotFoundException($data->errorCode, $data->errorMessage);

                default:
                    throw new ServerException($data->errorCode, $data->errorMessage);
            }
        }

        return \json_decode($response->getBody());
    }
}