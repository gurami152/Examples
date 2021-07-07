<?php


namespace App\Repositories;


use App\TypeOfPrivilege;

class TypeOfPrivilegeRepository
{
    public function all()
    {
        return TypeOfPrivilege::all();
    }

    public function paginated($size)
    {
        return TypeOfPrivilege::paginate($size);
    }
}
