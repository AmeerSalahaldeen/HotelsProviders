<?php namespace HotelsProviders\Expedia\Repositories;

class RoomsRepository extends AbstractRepository
{
    /**
     * Get the full details of a room availability by hotelId.
     *
     * @param $hotelId
     * @param  array $parameters
     * @return Rooms Availability
     */
    public function getRoomsAvilability($hotelId, array $parameters = [])
    {
        $parameters['hotelId'] = $hotelId;

        if (isset($parameters['occupancy'])) {
            $urls = $this->parseQueryParameters($parameters);
        } else {
            for ($occupancy = 1; $occupancy < 9; $occupancy++) {
                $parameters["rooms"][1]["adults"] = $occupancy;
                $urls [] =  $this->parseQueryParameters($parameters);
            }   
        }

        return $this->getApi()->getRooms($id, $urls);
    }

    /**
     * Get Rate by roomCode and rateCode
     *
     * @param $hotelId
     * @param $rateCode
     * @param $roomTypeCode
     * @param  array $parameters
     * @return hotelsList
     */
    public function getRoomsByRateId($hotelId, $rateCode, $roomTypeCode, array $parameters = [])
    {
        return $this->getApi()->getRoomsByRateId($hotelId, $rateCode, $roomTypeCode, $this->parseQueryParameters($parameters));
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
