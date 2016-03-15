<?php namespace HotelsProviders\Expedia;

class CardHolder
{
    private $address1;

    private $city;
    
    private $postalCode;
    
    private $countryCode;
    
    private $stateProvinceCode;
 
    function __construct($cardHolder)
    {

        $this->countryCode          = $cardHolder['address_country'];
        $this->city                 = $cardHolder['address_city'];
        $this->postalCode           = $cardHolder['address_zip'];
        $this->address1             = $cardHolder['address_line'];
        if (in_array($this->countryCode, ['US','CA','AU'])) {
            $this->stateProvinceCode = $cardHolder['address_state'];
        }
    }

    public function toUrl()
    {
        $url = '';
        $vars = get_object_vars($this);
        foreach ($vars as $var => $value) {
            $url.=$var.'='.$value.'&';
        }

        return $url;
    }

}