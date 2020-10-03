<?php

namespace InvisionApi;

class Api
{
    const API_VERSION = 1.0;

    /**
     * The IPS API endpoint
     * @var string
     */
    protected $apiUrl;

    /**
     * The API key or OAuth access token
     * @var string
     */
    protected $accesToken;

    /**
     * Determines whether or not we utilize OAuth authorization
     * @var bool
     */
    protected $oauth;

    /**
     * GuzzleHttp Client
     * @var \GuzzleHttp\Client
     */
    public $client;

    /**
     * Initialize a new API instance
     * @param string $apiUrl The full URL to your communities API endpoint (e.g. https://myforum.com/api)
     * @param string $accesToken Either the API key or the OAuth access token used for authorization
     * @param bool $oauth When true, will use OAuth authentication on endpoints instead of API keys
     * @return void
     */
    public function __construct( string $apiUrl, string $accesToken, bool $oauth = false )
    {
        $this->apiUrl = \rtrim($apiUrl, '/ ') . '/';
        $this->accessToken = $accesToken;
        $this->oauth = $oauth;

        $this->client = new \GuzzleHttp\Client(['base_uri' => $this->apiUrl, 'http_errors' => false]);
    }

    /**
     * /api/core endpoint
     * @return Endpoints\System
     */
    public function system()
    {
        return new Endpoints\System($this);
    }

    /**
     * Generate the default HTTP options, including the authorization token
     * @param array $extra An array of extra HTTP options
     * @return array
     */
    public function opts( array $extra = [] ): array
    {
        $options = [
            'headers'   => [
                'User-Agent' => 'invisiondev/' . static::API_VERSION,
                'Accept'     => 'application/json'
            ],
            'query'     => []
        ];
        
        // Authenticate using either an API key or OAuth token
        if ( $this->oauth )
        {
            $options['headers']['Authorization'] = "Bearer: {$this->accessToken}";
        }
        else
        {
            $options['query']['key'] = $this->accessToken;
        }

        return \array_merge($options, $extra);
    }
}