<?php namespace HotelsProviders\Expedia;

class Room
{
    public $roomTypeCode;

    public $rateCode;
    
    public $rateKey;
    
    private $chargeableRate;
    
    private $room1;

    private $room1BedTypeId;

    private $room1FirstName;

    private $room1LastName;

    private $rateType;

    public  $roomCounts = 1;

    function __construct($rate, $customer)
    {
        $this->rateType                 = $rate['is_prepaid'] ? 'MerchantStandard' : 'DirectAgency';
        $this->roomTypeCode             = $rate['accommodation_id'];
        $this->rateCode                 = $rate['code'];
        $this->rateKey                  = $rate['key'];
        $this->chargeableRate           = $rate['chargeable_rate'];
        $this->room1                    = $rate['adults'].','.@$rate['children'];
        $this->room1BedTypeId           = $rate['bedType'];
        $this->room1FirstName           = $customer->firstName;
        $this->room1LastName            = $customer->lastName;
    }

    public function toUrl()
    {
        $url = '';
        $vars = get_object_vars($this);
        foreach ($vars as $var => $value) {
            if ($var != "roomCounts") $url.=$var.'='.$value.'&';
        }

        for ($i = 1; $i < $this->roomCounts; $i++) {
            $roomNum = $i + 1;
            $url = $url. "&room".$roomNum.'='.$this->room1.'&room'.$roomNum.'BedTypeId='.$this->room1BedTypeId.'&room'.$roomNum.'FirstName='.$this->room1FirstName.'&room'.$roomNum.'LastName='.$this->room1LastName;
        }
        return $url;
    }
}
