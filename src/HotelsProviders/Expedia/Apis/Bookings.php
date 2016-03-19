<?php namespace HotelsProviders\Expedia\Apis;

class Bookings extends AbstractApi
{
    $baseUrl = "http://api.ean.com/ean-services/rs/hotel/v3/";
            //book.api.ean.com/ean-services/rs/hotel/v3/res
    /**
     * Get the status for a specific booking by itenary id.
     *
     * @param $id
     * @param $checkinDate
     * @param $checkoutDate
     * @return mixed
     */
    public function getStatus($id, $checkinDate, $checkoutDate)
    {
        $parameters = [
            "itineraryId"        => $id,
            "departureDateStart" => $checkinDate,
            "departureDateEnd"   => $checkoutDate
        ];
        return $this->get($this->baseUrl.'itin?', $parameters);
    }

    /**
     * Book Reservation.
     *
     * @param  array $parameters
     * @return mixed
     */
    public function postBook(array $parameters = [])
    {
        return $this->post('https://book.api.ean.com/ean-services/rs/hotel/v3/res', $parameters);
    }

}
