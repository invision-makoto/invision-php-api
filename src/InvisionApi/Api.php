<?php

namespace InvisionApi;

class Api
{
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
    protected $client;

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

        $this->client = new \GuzzleHttp\Client(['base_uri' => $this->apiUrl]);
    }
}