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
        $parameters['hotelId'] = $id;

        return $this->getApi()->getHotelInfo($this->parseQueryParameters($parameters));
    }

    /**
     * Get the avilabilties of a hotels by Ids.
     *
     * @param $ids
     * @param  array $parameters
     * @return hotelsList
     */
    public function getHotelAvailabiltyByList($ids, array $parameters = [])
    {
        $parameters["hotelIdList"] = implode(',', $$ids);

        return $this->getApi()->getHotelsList($this->parseQueryParameters($parameters));
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
        $parameters['hotelId'] = $id;

        return $this->getApi()->getPaymentTypes($this->parseQueryParameters($parameters));
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
