<?php namespace HotelsProviders\Expedia;

trait ApiMethodsTrait
{
    /**
     * @return Api\Hotels
     */
    public function getHotelsApi()
    {
        return new Api\Hotels($this);
    }

    /**
     * @return Api\Rooms
     */
    public function getRoomsApi()
    {
        return new Api\Rooms($this);
    }

    /**
     * @return Api\Bookings
     */
    public function getBookingsApi()
    {
        return new Api\Bookings($this);
    }

}
