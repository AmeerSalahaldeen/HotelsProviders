<?php namespace HotelsProviders\Expedia;

class ApiRequestor
{
    private $url;

    private $method;

    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function request($method, $baseUrl, $parameters)
    {
        if ($method == 'POST') {
            $url = $baseUrl;
        } else {
            $url = new Url($baseUrl, $parameters, $this->config);
            $url = $url->getRequestUrl();
        }
        $path = 'cid='.$this->config['expediaCid'];
        $path .= '&apiKey='.$this->config['expediaApiKey'];
        $path .= '&minorRev='.$this->config['minorRev'];
        return $this->curlRequest($method, $url ,$path.'&'.$parameters);
    }

    public  function curlRequest($method ,$url, $parameters)
    {
        $header[] = "Accept: application/json";
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($method == 'POST') {
            curl_setopt($ch,CURLOPT_POSTFIELDS, $parameters);
            curl_setopt($ch,CURLOPT_POST, 1);
        }
        curl_setopt( $ch, CURLOPT_URL, $url);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        return json_decode($response);
    }
}

