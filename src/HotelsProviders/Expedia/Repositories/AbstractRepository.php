<?php namespace HotelsProviders\Expedia\Repositories;

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
    protected function parseQueryParameters(array $parameters = [])
    {
        $queryParams = '';

        foreach ($parameters as $key => $value) {
            $queryParams .= $key.'='.$value.'&';
        }

        return $parameters;
    }

    /**
     * Return the API Class
     *
     * @return ApiInterface
     */
    abstract public function getApi();
}
