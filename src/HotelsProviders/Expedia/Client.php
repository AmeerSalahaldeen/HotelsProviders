<?php namespace HotelsProviders\Expedia;

/**
 * Client wrapper
 * @package
 */
class Client
{
    use ApiMethodsTrait;

    use RequestTrait;

    /**
     * Store the apiExperience
     *
     * @var string
     */
    private $apiExperience;
    
    /**
     * Store the apiKey
     *
     * @var string
     */
    private $apiKey;
    /**
     * Store the cid
     *
     * @var string
     */
    private $cid;

    /**
     * Store the minorRev
     *
     * @var string
     */
    private $minorRev;

    /**
     * Construct our client
     *
     * @param ApiToken $token
     * @param array    $options
     */
    public function __construct($config)
    {
        $this->cid           = $config;
        $this->apiExperience = ;
        $this->cid           = ;
        $this->minorRev      = ;
        $this->apiKey        = ;
        $this->constructHttpClient();
    }

    // public function constructHttpClient()
    // {
    //     $url = '';
    //     $vars = get_object_vars($this);
    //     foreach ($vars as $var => $value) {
    //         $url.=$var.'='.$value.'&';
    //     }

    //     return $this->url;
    // }

}
