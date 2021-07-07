<?php


namespace App\Repositories;


use App\Address;

class AddressRepository
{
    /**
     * @var Address $address
     */
    protected $address;

    /**
     * AddressRepository constructor.
     * @param Address $address
     */
    public function __construct(Address $address)
    {
        $this->address = $address;
    }

    public function create($regionAjax, $district, $typeOfCityAjax, $cityAjax, $typeOfStreetAjax, $streetAjax, $houseAjax, $apartment)
    {
        return $this->address->create([
            'region' => $regionAjax,
            'district' => $district,
            'typeOfCity_id' => $typeOfCityAjax,
            'city' => $cityAjax,
            'typeOfStreet_id' => $typeOfStreetAjax,
            'street' => $streetAjax,
            'house' => $houseAjax,
            'apartment' => $apartment,
            'language_id' => 1,
        ])->id;
    }
}
