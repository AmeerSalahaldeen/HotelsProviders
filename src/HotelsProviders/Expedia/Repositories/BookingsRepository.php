<?php namespace HotelsProviders\Expedia\Repositories;

class BookingsRepository extends AbstractRepository
{
    /**
     * Get the status of Booking
     *
     * @param  $id
     * @param  date $checkinDate
     * @param  date $checkoutDate
     * @return status
     */
    public function getStatus($id, $checkinDate, $checkoutDate)
    {
        $parameters = [
            "itineraryId"           => $id,
            "departureDateStart"    => $checkinDate,
            "departureDateEnd"      => $checkoutDate
        ];

        return $this->getBookingApi()->getStatus($this->parseQueryParameters($parameters));
    }
    /**
     * Book rooms 
     *
     * @param  $hotelId
     * @param  $customer
     * @param  $creditCard
     * @param  $reservation
     * @param  $rooms
     * @return $reservation
     */
    // TODO MultiCurl Post requests. 
    public function postBook($hotelId, $customer, $creditCard, $reservation, $rooms)
    {
        $mergedRooms       = $this->meregRooms($rooms);
        $reservationInfo   = $this->reservationInfo($hotelId, $customer, $creditCard, $reservation);

        foreach ($mergedRooms as $identfier => $room) {
            $param = $this->parseQueryParameters($parametersBuilder->room($room, $customer));
            $results[$identfier] = $this->getClient()->getBookingsApi()->postBook($param.$reservationInfo);
        }

        foreach ($rooms as $room) {
            $identfier = $room['accommodation_id'].$room['code'].$room['key'];
            $roomsReponses['room'] = $room;
            $roomsReponses['status'] = $results[$identfier];
        }

        return $roomsReponses;
    }

    /**
     * Merge Rooms according to roomTypeCode,rateCode and rateKey
     *
     * @param  arrays $rooms
     * @return $rooms
     */
    protected function meregRooms($rooms)
    {
        $mergedRooms = [];
        foreach ($rooms as $room) {
            $identfier = $room['accommodation_id'].$room['code'].$room['key'];

            if (in_array($identfier, array_keys($mergedRooms))) {
                $mergedRooms[$identfier]['roomsCount'] = $rooms[$identfier]['roomsCount'] + 1;
            } else {
                $mergedRooms[$identfier] = $room; 
            }
        }

        return $mergedRooms;
    }

    protected function reservationInfo($hotelId, $customer, $creditCard, $reservation)
    {
        $parametersBuilder = \App::make('HotelsProviders\Expedia\Formatters\ParametersBuilder');

        $customerParams    = $this->parseQueryParameters($parametersBuilder->customer($customer, $creditCard));
        $reservationParams = $this->parseQueryParameters($parametersBuilder->reservation($hotelId, $reservation));
        $creditCardParams  = $this->parseQueryParameters($parametersBuilder->creditCard($creditCard));

        return $reservationParams.$customerParams.$creditCardParams;
    } 

    /**
     * Return the related API class
     *
     * @return \Apias\Bokings
     */
    public function getApi()
    {
        return $this->getClient()->getBookingsApi();
    }

}

