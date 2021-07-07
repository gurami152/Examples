<?php

namespace App\Repositories;

use App\TypeOfCity;

class TypeOfCityRepository
{
    /**
     * @var TypeOfCity
     */
    protected $typeOfCity;

    /**
     * TypeOfCityRepository constructor.
     * @param TypeOfCity $typeOfCity
     */
    public function __construct(TypeOfCity $typeOfCity)
    {
        $this->typeOfCity = $typeOfCity;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->typeOfCity->get();
    }

    /**
     * @param $size
     * @return mixed
     */
    public function paginated($size)
    {
        return $this->typeOfCity->paginate($size);
    }

    /**
     * @param $lang
     * @return mixed
     */
    public function languageSelect($lang)
    {
        return $this->typeOfCity->where('language_id', $lang)->get();
    }

}
