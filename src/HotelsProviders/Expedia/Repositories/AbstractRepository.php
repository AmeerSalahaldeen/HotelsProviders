<?php namespace HotelsProviders\Expedia\Repositories;

use HotelsProviders\Expedia\Client;

abstract class AbstractRepository
{
    protected $client = null;

    protected $api    = null;

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
     * Return the client
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Process query parameters
     *
     * @param  array $parameters
     * @return string
     */
    protected function parseQueryParameters($parameters = [])
    {
        $queryParams = '';

        foreach ($parameters as $key => $value) {
            $queryParams = $queryParams.$key.'='.$value.'&';
        }

        return $queryParams;
    }

    /**
     * Return the API Class
     *
     * @return ApiInterface
     */
    abstract public function getApi();
}
