<?php namespace HotelsProviders\Expedia\Apis;

class Hotels extends AbstractApi
{
    protected $baseUrl = "http://api.ean.com/ean-services/rs/hotel/v3/";

    /**
     * Get the Hotel information for a specific Hotel id.
     *
     * @param $id
     * @param  array $options
     * @return mixed
     */
    public function getHotelInfo($id, array $parameters = [])
    {
        $parameters['hotelId'] = $id;

        return $this->get($this->baseUrl.'info', $parameters);
    }

    /**
     * Get the hotels availablity for a array of hotels Id.
     *
     * @param $ids
     * @param  array $parameters
     * @return mixed
     */
    public function getHotelsList($ids, array $parameters = [])
    {
        $parameters["hotelIdList"] = implode(',', $$ids);

        return $this->get($this->baseUrl.'list', $parameters);
    }

    /**
     * Get the payment types of Hotel
     *
     * @param $id
     * @param  array $parameters
     * @return mixed
     */
    public function getPaymentTypes($id, array $parameters = [])
    {
        //TODO 
    }

}
