<?php namespace HotelsProviders\Expedia\Repositories;

class HotelsRepository extends AbstractRepository
{
    /**
     * Get the full details of a hotel by ID.
     *
     * @param $id
     * @param  array $parameters
     * @return Hotel Info
     */
    public function getHotelInfo($id, array $parameters = [])
    {
        return $this->getApi()->getHotelInfo($id, $this->parseQueryParameters($parameters));
    }

    /**
     * Get the avilabilties of a hotels by Ids.
     *
     * @param $id
     * @param  array $parameters
     * @return hotelsList
     */
    public function getHotelAvailabiltyByList($id, array $parameters = [])
    {
        return $this->getApi()->getHotelsList($ids, $this->parseQueryParameters($parameters));
    }

    /**
     * Get the payments details of a hotel by ID.
     *
     * @param $id
     * @param  array $parameters
     * @return array payments types
     */
    public function getPaymentTypes($id, array $parameters = [])
    {
        return $this->getApi()->getPaymentTypes($id, $this->parseQueryParameters($parameters));
    }

    /**
     * Return the related API class
     *
     * @return \Api\Hotels
     */
    public function getApi()
    {
        return $this->getClient()->getHotelsApi();
    }

}
