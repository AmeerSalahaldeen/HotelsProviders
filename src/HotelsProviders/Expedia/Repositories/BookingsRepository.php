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
        return $this->getBookingApi()->getStatus($id, $checkinDate, $checkoutDate);
    }
    /**
     * Book Rooms
     *
     * @return \Api\Booking
     */
    public function postBook($customer, $creditCard, $cardHolder, $rooms)
    {
        $parametersBuilder = \App::make('HotelsProviders\Expedia\Formatter\ParametersBuilder');

        $rooms             = $this->meregRooms($rooms);
        $customerParams    = $this->parseQueryParameters($parametersBuilder->customer($customer, $cardHolder));
        $creditCardParams  = $this->parseQueryParameters($parametersBuilder->creditCard($creditCard));

        foreach ($rooms as $room) {
            $param = $parametersBuilder->room($room, $customer);
            $param = $this->parseQueryParameters($param);
            $parameters[] = $param.$customerParams.$creditCardParams;
        }

        return $this->getClient()->getBookingApi()->postBook($parameters);
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
            $identfier = $room['roomTypeCode'].$room['rateCode'].$room['rateKey'];

            if (in_array($identfier, array_keys($mergedRooms))) {
                $mergedRooms[$identfier]['roomsCount'] = $rooms[$identfier]['roomsCount'] + 1;
            } else {
                $mergedRooms[$identfier] = $room; 
            }
        }

        return $mergedRooms;
    }

}
