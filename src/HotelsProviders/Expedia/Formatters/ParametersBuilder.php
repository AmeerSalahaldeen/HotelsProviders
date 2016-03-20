<?php namespace HotelsProviders\Expedia\Formatters;

class ParametersBuilder
{
    public function room($room, $customer)
    {
        list($firstName, $lastName) = explode(' ', $customer['translated-name'], 2);

        $parameters = [
            'rateType'           => $room['is_prepaid'] ? 'MerchantStandard' : 'DirectAgency',
            'roomTypeCode'       => $room['accommodation_id'],
            'rateCode'           => $room['code'],
            'rateKey'            => $room['key'],
            'chargeableRate'     => $room['chargeable_rate'],
            'room1'              => $room['adults'].','.@$room['children'],
            'room1BedTypeId'     => $room['bedType'],
            'room1FirstName'     => $firstName,
            'room1LastName'      => $lastName,
            'supplierType'       => 'E',
            'currencyCode'       => $room['currency']
        ];

        $roomsCount = isset($room['roomCounts']) ? $room['roomCounts'] : 1;

        for ($i = 1; $i < $roomsCount; $i++) {
            $roomNum = 'room'.($i + 1);
            $parameters[$roomNum]             = $parameters['room1'];
            $parameters[$roomNum.'BedTypeId'] = $parameters['room1BedTypeId'];
            $parameters[$roomNum.'FirstName'] = $parameters['room1FirstName'];
            $parameters[$roomNum.'LastName']  = $parameters['room1LastName'];
        }

        return $parameters;
    }

    public function customer($customer, $cardHolder)
    {
        list($firstName, $lastName) = explode(' ', $customer['translated-name'], 2);

        return [
            'firstName'                 => $firstName,
            'lastName'                  => $lastName,
            'homePhone'                 => $customer['phone'],
            'email'                     => $customer['email'],
            'countryCode'               => $cardHolder['address_country'],
            'city'                      => $cardHolder['address_city'],
            'postalCode'                => $cardHolder['address_zip'],
            'address1'                  => $cardHolder['address_line'],
            'stateProvinceCode'         => $cardHolder['address_state'],
            'affiliateConfirmationId'   => $this->GUID()

        ];
    }

    public function reservation($hotelId, $reservation)
    {
        return [
            'hotelId'               => $hotelId,
            'arrivalDate'           => $reservation['checkin_date'],
            'departureDate'         => $reservation['checkout_date'],
            'specialRequest'        => $reservation['special_request'],
            'sendReservationEmail'  => true
        ];
    }
    public function creditCard($creditCard)
    {
        list($firstName, $lastName) = explode(' ', $creditCard['translated-name'], 2);

        return [
            'firstName'                    => $firstName,
            'lastName'                     => $lastName,
            'creditCardNumber'             => $creditCard['number'],
            'creditCardIdentifier'         => $creditCard['cvc'],
            'creditCardExpirationMonth'    => $creditCard['exp_month'],
            'creditCardExpirationYear'     => $creditCard['exp_year'],
            'creditCardType'               => $this->getCCCode($creditCard['type'])
        ];
    }
    protected function getCCCode($type)
    {
        $type = str_replace(' ', '', strtolower($type));
        $expediaCodes = $this->getExpediaCardsCodes();

        return @$expediaCodes[$type];
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

    protected function GUID()
    {
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X',
               mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535),
               mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535),
               mt_rand(0, 65535), mt_rand(0, 65535));
    }
}
