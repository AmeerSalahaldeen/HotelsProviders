<?php namespace HotelsProviders\Expedia\Apis;

use HotelsProviders\Expedia\Client;

abstract class AbstractApi
{
    /**
     * The client
     *
     * @var Client
     */
    protected $client;

    /**
     * Constructor
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send a GET request
     *
     * @param  $path
     * @param  array  $parameters
     * @return mixed
     */
    public function get($path, array $parameters = [])
    {
        $response = $this->getClient()->get($path, $parameters);   

        return $this->decodeResponse($response);
    }

    /**
     * Send a POST request
     *
     * @param  string $path
     * @param  null   $postBody
     * @param  array  $parameters
     * @param  array  $headers
     * @return mixed
     */
    public function post($path, $postBody = null, array $parameters = [])
    {
        $response = $this->getClient()->post($path, $postBody, $parameters);

        return $this->decodeResponse($response);
    }

    /**
     * Retrieve the client
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Decode the response
     *
     * @param $response
     * @return mixed
     */
    private function decodeResponse($response)
    {
        return is_string($response) ? json_decode($response, true) : $response;
    }

}
