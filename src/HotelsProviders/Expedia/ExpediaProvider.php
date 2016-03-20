<?php namespace HotelsProviders\Expedia;

class ExpediaProvider {

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function reserve($hotelId, $reservationInfo, $rooms)
    {
        // Validate the bookings params.
        $bookingVaildator = \App::make('\HotelsProviders\Expedia\Validators\ReservationValidator');
        $validationErros = $bookingVaildator->validate($reservationInfo, $rooms);
        if ( ! empty($validationErros)) {
            throw new MissingRequiredParameterException($validationErros);
        }

        $bookingRepo = new \HotelsProviders\Expedia\Repositories\BookingsRepository($this->client);
        return $bookingRepo->postBook($hotelId, $reservationInfo['customer'], $reservationInfo['credit_card'], $reservationInfo, $rooms);
    }

    public function getBookingStatus($id, $checkIn, $checkOut)
    {
        $bookingRepo = new \HotelsProviders\Expedia\Repositories\BookingsRepository($this->client);
        return $this->bookingRepo->getStatus($id, $checkinDate, $checkoutDate);
    }

    public function getRooms($hotelId, $parameters)
    {
        $roomsRepo = new \HotelsProviders\Expedia\Repositories\RoomsRepository($this->client);

        return $roomsRepo->getRoomsAvilability($hotelId, $parameters);
    }

    public function getRoomsByRateId($hotelId, $rateCode, $roomTypeCode, $parameters)
    {
        $roomsRepo = new \HotelsProviders\Expedia\Repositories\RoomsRepository($this->client);
        $roomsRepo->getRoomsByRateId($hotelId, $rateCode, $roomTypeCode, $parameters);
    }

    public function getHotelInfo($id, $parameters)
    {
        $hotelsRepo = new \HotelsProviders\Expedia\Repositories\HotelsRepository($this->client);
        $hotelsRepo->getHotelInfo($id, $parameters);
    }

    public function getHotelsList($ids, $parameters)
    {
        $hotelsRepo = new \HotelsProviders\Expedia\Repositories\HotelsRepository($this->client);
        $hotelsRepo->getHotelAvailabiltyByList($ids, $parameters);
    }

    public function getPaymentTypes($id, $parameters)
    {
        $hotelsRepo = new \HotelsProviders\Expedia\Repositories\HotelsRepository($this->client);
        $hotelsRepo->getPaymentTypes($id, $parameters);
    }

}
