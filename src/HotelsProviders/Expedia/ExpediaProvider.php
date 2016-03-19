<?php namespace HotelsProviders\Expedia;

class ExpediaProvider {

    private $config;

    public function __construct($config, BookingRepositroy $bookingRepo,
        RoomsRepository $roomsRepo, HotelsRepository $hotelsRepo)
    {
        $this->config       = $config;
        $this->bookingRepo  = $bookingRepo;
        $this->roomsRepo    = $roomsRepo;
        $this->hotelsRepo   = $hotelsRepo;
    }

    public function reserve($customer, $creditCard, $rooms)
    {
        return $this->bookingRepo->postBook($customer, $creditCard, $rooms);
    }

    public function getBookingStatus($id, $checkIn, $checkOut)
    {
        return $this->bookingRepo->getStatus($id, $checkinDate, $checkoutDate);
    }

    public function getRooms($hotelId, $parameters)
    {
        $this->roomsRepo->getRoomsAvilability($hotelId, $parameters);
    }

    public function getRoomsByRateId($hotelId, $rateCode, $roomTypeCode, $parameters)
    {
        $this->roomsRepo->getRoomsByRateId($hotelId, $rateCode, $roomTypeCode, $parameters);
    }

    public function getHotelInfo($id, $parameters)
    {
        $this->hotelsRepo->getHotelInfo($id, $parameters);
    }

    public function getHotelsList($ids, $parameters)
    {
        $this->hotelsRepo->getHotelAvailabiltyByList($ids, $parameters);
    }

    public function getPaymentTypes($id, $parameters)
    {
        $this->hotelsRepo->getPaymentTypes($id, $parameters);
    }

}
