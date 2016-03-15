<?php namespace HotelsProviders\Expedia;

class Reservation
{
    private $hotelId;

    private $arrivalDate;

    private $departureDate;

    private $specialRequest;

    public $rooms;
    
    private $card;
    
    private $cardHolder;
    
    private $customser;

    private $url;

    function __construct($data, $checkoutForm)
    {
        $accommodations         = $checkoutForm['accommodations'];
        $this->arrivalDate      = $data['checkin_date'];
        $this->departureDate    = $data['checkout_date'];
        $this->specialRequest   = $data['special_request'];
        $this->hotelId          = $checkoutForm['property_details']['property_supplier_id'];
        // currency
        $this->customer        = new Customer($data['customer']);
        $this->card             = new Card($data['credit_card']);
        $this->cardHolder       = new CardHolder($data['credit_card']);

        foreach($accommodations as $acc) {
            $this->rooms [] = new Room($acc, $this->customer);
        }

        $this->url  .= 'hotelId='.$this->hotelId.'&arrivalDate='.$this->arrivalDate.'&departureDate='.$this->departureDate.'&specialRequest='.$this->specialRequest;
        $this->url .= '&supplierType=E&sendReservationEmail=true'.'&locale='.$this->getLocaleCode();
        $this->url .= '&affiliateConfirmationId='.$this->GUID().'&'.'apiExperience=PARTNER_WEBSITE'.'&'.'currencyCode=USD';
        $this->url .= '&'.$this->card->toUrl().$this->cardHolder->toUrl().$this->customer->toUrl();
    }

    public function getUrl($room)
    {
        return $this->url.$room->toUrl();
    }

    protected function getLocaleCode()
    {
        return \App::getLocale() == 'ar' ? 'ar_SA' : 'en_US';
    }

    protected function GUID()
    {
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X',
            mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535),
            mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535),
            mt_rand(0, 65535), mt_rand(0, 65535));
    }
}

    // public static function serializeAsArray($object, $parameter)
    // {
    //     if ( ! $object  || ! isset($object->$parameter)) return [];

    //     return is_array($object->$parameter) ? $object->$parameter : [$object->$parameter];
    // }
    // public function toJson()
    // {
    //     $success             = $response->HotelRoomReservationResponse;
    //     $itineraryId         = $success->itineraryId;
    //     $confirmationNumbers = $success->confirmationNumbers;
    //     $numberOfRoomsBooked = $success->numberOfRoomsBooked;
    //     $rates               = self::serializeAsArray($success->RateInfos, 'RateInfo');
    //     $rate                = $rates[0];
    //     $nonRefundable       = $success

    // HotelRoomReservationResponse":{"customerSessionId":"ddd","itineraryId":256663453,"confirmationNumbers":1234,"processedWithConfirmation":true,"supplierType":"E","reservationStatusCode":"CF","existingItinerary":false,"numberOfRoomsBooked":1,"drivingDirections":"","checkInInstructions":"","arrivalDate":"03\/22\/2016","departureDate":"03\/23\/2016","hotelName":"فندق سان ريجيس الدوحة","hotelAddress":"Doha West Bay","hotelCity":"Doha","hotelPostalCode":14435,"hotelCountryCode":"QA","roomDescription":"جناح (Caroline Astor)","rateOccupancyPerRoom":2,"RateInfos":{"@size":"1","RateInfo":{"@priceBreakdown":"true","@promo":"false","@rateChange":"false","RoomGroup":{"Room":{"numberOfAdults":1,"numberOfChildren":1,"childAges":0,"firstName":"Zyad","lastName":"Faramand","bedTypeId":14,"bedTypeDescription":"1 سرير ملكي","rateKey":"50e6f450-7f65-48c5-af60-cc95da359139"}},"ChargeableRateInfo":{"@averageBaseRate":"727.68","@averageRate":"727.68","@commissionableUsdTotal":"727.68","@currencyCode":"USD","@maxNightlyRate":"727.68","@nightlyRateTotal":"727.68","@grossProfitOffline":"19.65","@grossProfitOnline":"68.77","@total":"727.68","NightlyRatesPerRoom":{"@size":"1","NightlyRate":{"@baseRate":"727.68","@rate":"727.68","@promo":"false"}}},"cancellationPolicy":"إننا نتفهم أن الخطط قد تفشل أحيانًا. ونحن لا نفرض رسومًا على التغيير أو الإلغاء. إلا أن هذه المنشأة (فندق سان ريجيس الدوحة) تفرض الغرامة التالية على عملائها والتي يلزم علينا تحصيلها: سوف تخضع الإلغاءات أو التغييرات التي تمت بعد الساعة 11:59 ص ((GMT+03:00) Kuwait, Riyadh) في يوم 20\/03\/2016 لغرامة 1 تعادل رسم حجز غرفة لمدة ليلة واحدة ورسم الضريبة. ","nonRefundable":false,"rateType":"MerchantStandard"}}}}"
//     }
// }
