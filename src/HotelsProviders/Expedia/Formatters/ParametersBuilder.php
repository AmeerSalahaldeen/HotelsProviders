<?php namespace HotelsProviders\Expedia\Formatters;

class ParametersBuilder
{
    public function rooms($room, $customer)
    {
        $parameters = [
            'rateType'                 => $room['is_prepaid'] ? 'MerchantStandard' : 'DirectAgency',
            'roomTypeCode'             => $room['accommodation_id'],
            'rateCode'                 => $room['code'],
            'rateKey'                  => $room['key'],
            'chargeableRate'           => $room['chargeable_rate'],
            'room1'                    => $room['adults'].','.@$room['children'],
            'room1BedTypeId'           => $room['bedType'],
            'room1FirstName'           => $customer['firstName'],
            'room1LastName'            => $customer['lastName']
        ];

        for ($i = 1; $i < $room['roomCounts']; $i++) {
            $roomNum = 'room'.($i + 1);
            $parameters[$roomNum]             = $parameters['room1'];
            $parameters[$roomNum.'BedTypeId'] = $parameters['room1BedTypeId'];
            $parameters[$roomNum.'FirstName'] = $parameters['room1FirstName'];
            $parameters[$roomNum.'LastName']  = $parameters['room1LastName'];
        }
    }

    public function customer($customer, $cardHolder)
    {
        list($firstName, $lastName) = explode(' ', $customer['translated-name'], 2);

        return [
            'firstName'            => $firstName,
            'lastName'             => $lastName,
            'homePhone'            => $customer['phone'],
            'email'                => $customer['email'],
            'customerIpAddress'    => $customer['ip_address'],
            'customerSessionId'    => $customer['ip_address'],
            'customerUserAgent'    => $_SERVER['HTTP_USER_AGENT'],
            'countryCode'          => $cardHolder['address_country'],
            'city'                 => $cardHolder['address_city'],
            'postalCode'           => $cardHolder['address_zip'],
            'address1'             => $cardHolder['address_line'],
            'stateProvinceCode'    => $cardHolder['address_state']

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
}
