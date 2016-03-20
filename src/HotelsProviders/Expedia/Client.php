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
     * Store the customerIpAddress
     *
     * @var string
     */
    private $customerIpAddress;

    /**
     * Store the customerSessionId
     *
     * @var string
     */
    private $customerSessionId;

    /**
     * Construct our client
     *
     * @param ApiToken $token
     * @param array $options
     */
    public function __construct($config)
    {
        $this->cid                  = $config->get('expedia::expediaCid');
        $this->apiExperience        = $config->get('expedia::apiExperience');
        $this->minorRev             = $config->get('expedia::minorRev');
        $this->apiKey               = $config->get('expedia::expediaApiKey');
        $this->customerIpAddress    = $this->clientIp();
        $this->customerSessionId    = $_SESSION["customerSessionId"];
        $this->constructBasicUrl();
    }

    public function constructBasicUrl()
    {
        $url = '';
        $vars = get_object_vars($this);
        foreach ($vars as $var => $value) {
            $url.=$var.'='.$value.'&';
        }
        $this->baseUrl  = $url;
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    protected function generateSig()
    {
        //TODO use tokens auth instead of ips auth.
    }

}
