<?php namespace HotelsProviders\Expedia;

class Url
{
    private $config;

    private $baseUrl;
    
    private $parameters;

    private $path ='';

    function __construct($baseUrl ,$parameters, $config)
    {
        $this->baseUrl    = $baseUrl;
        $this->parameters = $parameters;
        $this->config     = $config;
    }

    public function getRequestUrl()
    {
        $this->path .= 'cid='.$this->config['expediaCid'];
        $this->path .= '&apiKey='.$this->config['expediaApiKey'];
        $this->path .= '&minorRev='.$this->config['minorRev'];

        return $this->baseUrl.$this->path.$this->parameters;
    }
}
