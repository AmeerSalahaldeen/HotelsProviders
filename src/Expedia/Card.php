<?php namespace HotelsProviders\Expedia;

class Card
{
    private $firstName;

    private $lastName;

    private $creditCardType;
    
    private $creditCardNumber;
    
    private $creditCardIdentifier;
    
    private $creditCardExpirationMonth;
    
    private $expirationYear;
 
    function __construct($creditCardInfo)
    {
        $name = $creditCardInfo['translated-name'];
        list($this->firstName, $this->lastName) = explode(' ', $name, 2);

        $this->creditCardNumber             = $creditCardInfo['number'];
        $this->creditCardIdentifier         = $creditCardInfo['cvc'];
        $this->creditCardExpirationMonth    = $creditCardInfo['exp_month'];
        $this->creditCardExpirationYear     = $creditCardInfo['exp_year'];
        $this->creditCardType               = $this->getCCCode($creditCardInfo['type']);
    }

    protected function getCCCode($type)
    {
        $type = str_replace(' ', '', strtolower($type));
        $expediaCodes = $this->getExpediaCardsCodes();

        return @$expediaCodes[$type];
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

    protected function getExpediaCardsCodes()
    {
        return [
            'visa'                  => 'VI',
            "americanexpress"       => 'AX',
            "bccard"                => 'BC',
            "mastercard"            => 'CA',
            "discover"              => 'DS',
            "dinersclub"            => 'DC',
            "cartasi"               => 'T',
            "cartebleue"            => 'R',
            "visaelectron"          => 'E',
            "japancreditbureau"     => 'JC',
            "maestro"               => 'TO'
        ];
    }
}
