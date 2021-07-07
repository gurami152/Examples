<?php


namespace App\Repositories;


use App\TypeOfUserRoomSelection;

class TypeOfUserRoomSelectionRepository
{
    public function all()
    {
        return TypeOfUserRoomSelection::all();
    }

    public function paginated($size)
    {
        return TypeOfUserRoomSelection::paginate($size);
    }
}
