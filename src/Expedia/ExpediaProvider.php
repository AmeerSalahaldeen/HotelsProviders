<?php namespace HotelsProviders\Expedia;

class ExpediaProvider {

    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }
    public  function book($data, $checkoutInfo)
    {
        foreach ($checkoutInfo['accoomodations'] as $room) {
            $identfier = $room->roomTypeCode.$room->rateCode.$room->rateKey;
            $rooms [$identfier] = $room;
        }

        $reservation = new Reservation($data, $checkoutInfo);
        // merge the same rooms .
        $reservation->rooms = $this->meregRooms($reservation->rooms);

        foreach ($reservation->rooms as $identfier => $room) {
            $apiRequestor = new ApiRequestor($this->config);
            $response = $apiRequestor->request('POST', $this->config['bookingUrl'], $reservation->getUrl($room));
            if (property_exists($response, "EanWsError")) {
                $errors [$identfier] = $response->EanWsError; 
                $failedRooms[] = $rooms[$identfier];
            } else {
                $soldRooms [] = $rooms[$identfier];
            }
        }


        return ['sold_rooms' => @$soldRooms, 'failed_rooms' => $failedRooms,'errors' => $errors];
    }

    public  function getAvailabilty($checkIn, $checkOut, $hotelId) {

    }

    protected function meregRooms($rooms)
    {
        $mergedRooms = [];

        foreach ($rooms as $identfier => $room) {
            if (in_array($identfier, array_keys($mergedRooms))) {
                $mergedRooms[$identfier]->roomsCount = $rooms[$identfier]->roomsCount + 1;
            } else {
                $mergedRooms[$identfier] = $room; 
            }
        }

        return $mergedRooms;
    }

    public  function getHotelInfo($hotelId) {

    }
    protected function format($response)
    {
        if (property_exists($response, "EanWsError")) {
            return $expediaResponse->EanWsError;
        }

        return $response->HotelRoomReservationResponse;
    }

}
