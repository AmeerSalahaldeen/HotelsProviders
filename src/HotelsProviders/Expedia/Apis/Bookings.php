<?php namespace HotelsProviders\Expedia\Apis;

class Bookings extends AbstractApi
{
    protected $baseUrl = "http://api.ean.com/ean-services/rs/hotel/v3/";
    /**
     * Get the status for a specific booking by itenary id.
     *
     * @param $parameters
     * @return mixed
     */
    public function getStatus($parameters)
    {
        return $this->get($this->getBaseUrl('itin').$parameters);
    }

    /**
     * Book Reservation.
     *
     * @param  string $parameters
     * @return mixed
     */
    public function postBook( $parameters)
    {
        $response =  $this->post('https://book.api.ean.com/ean-services/rs/hotel/v3/res', $this->getClient()->getBaseUrl() .$parameters)->HotelRoomReservationResponse;

        if (property_exists($response, "verboseMessage"))
            return @$response->EanWsError->verboseMessage ? : json_encode($response->EanWsError);
        }

        return [
            'confirmationNumbers'   => $itineraryId,
            'itineraryId'           => $response->itineraryId,
        ];
    }

    public function getBaseUrl($keyword)
    {
        return $this->baseUrl .$keyword.'?'.$this->getClient()->getBaseUrl();
    }
}
