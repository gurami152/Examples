<?php


namespace App\Repositories;


use App\TypeOfPassport;

class TypeOfPassportRepository
{
    public function all()
    {
        return TypeOfPassport::all();
    }

    public function paginated($size)
    {
        return TypeOfPassport::paginate($size);
    }
}
