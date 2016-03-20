<?php namespace HotelsProviders\Expedia\Apis;

class Hotels extends AbstractApi
{
    protected $baseUrl = "http://api.ean.com/ean-services/rs/hotel/v3/";

    /**
     * Get the Hotel information for a specific Hotel id.
     *
     * @param  array $options
     * @return mixed
     */
    public function getHotelInfo($parameters)
    {
        return $this->get($this->getBaseUrl('info').$parameters);
    }

    /**
     * Get the hotels availablity for a array of hotels Id.
     *
     * @param $ids
     * @param  array $parameters
     * @return mixed
     */
    public function getHotelsList( array $parameters = [])
    {
        return $this->get($this->getBaseUrl('list').$parameters);
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
    public function getBaseUrl($keyword)
    {
        return $this->baseUrl .$keyword.'?'.$this->getClient()->getBaseUrl();
    }

}
