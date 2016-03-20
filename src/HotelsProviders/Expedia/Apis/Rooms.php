<?php namespace HotelsProviders\Expedia\Apis;

class Rooms extends AbstractApi
{
    protected $baseUrl = "http://api.ean.com/ean-services/rs/hotel/v3/";

    /**
     * Get the availabilties
     *
     * @param  $parameters
     * @return mixed
     */
    public function getRooms($parameters)
    {
        if (is_string($parameters)) return $this->get($this->getBaseUrl().$parameters);

        foreach ($parameters as $param) {
            $urls [] = $this->getBaseUrl().$param;
        }
        return $this->get($urls);
    }
    /**
     * Get the availabilty for a room and rate to verify the prices.
     *
     * @param  $hotelId
     * @param  $rateCode
     * @param  $roomTypeCode
     * @param  array $parameters
     * @return mixed
     */
    public function getRoomsByRateId($hotelId, $rateCode, $roomTypeCode, $parameters)
    {
        $parameters['hotelId']      = $hotelId;
        $parameters['rateCode']     = $rateCode;
        $parameters['roomTypeCode'] = $roomTypeCode;

        return $this->get($this->baseUrl . 'avail?' . $parameters);
    }

    public function getBaseUrl()
    {
        return $this->baseUrl .'avail?'.$this->getClient()->getBaseUrl();
    }

}
