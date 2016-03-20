<?php namespace HotelsProviders\Expedia;

trait ApiMethodsTrait
{
    /**
     * @return Api\Hotels
     */
    public function getHotelsApi()
    {
        return new Apis\Hotels($this);
    }

    /**
     * @return Api\Rooms
     */
    public function getRoomsApi()
    {
        return new Apis\Rooms($this);
    }

    /**
     * @return Api\Bookings
     */
    public function getBookingsApi()
    {
        return new Apis\Bookings($this);
    }

}
