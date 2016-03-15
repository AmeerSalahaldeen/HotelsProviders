<?php namespace HotelsProviders\Expedia;

class Customer
{
    public $firstName;

    public $lastName;

    private $email;

    private $homePhone;
    
    private $customerUserAgent;
    
    private $customerIpAddress;
    
    private $customerSessionId;
 
    function __construct($customer)
    {
        $name = $customer['translated-name'];
        list($this->firstName, $this->lastName) = explode(' ', $name, 2);

        $this->customerSessionId    = "ddd";// $_SESSION["customerSessionId"];
        $this->customerUserAgent    = $_SERVER['HTTP_USER_AGENT'];

        $this->homePhone            = $customer['phone'];
        $this->email                = $customer['email'];
        $this->customerIpAddress    = $customer['ip_address'];
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
