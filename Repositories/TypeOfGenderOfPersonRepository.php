<?php


namespace App\Repositories;


use App\TypeOfGenderOfPerson;

class TypeOfGenderOfPersonRepository
{
    public function all()
    {
        return TypeOfGenderOfPerson::all();
    }

    public function paginated($size)
    {
        return TypeOfGenderOfPerson::paginate($size);
    }
}
