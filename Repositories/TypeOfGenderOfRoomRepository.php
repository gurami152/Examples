<?php


namespace App\Repositories;


use App\TypeOfGenderOfRoom;

class TypeOfGenderOfRoomRepository
{
    public function all()
    {
        return TypeOfGenderOfRoom::all();
    }

    public function paginated($size)
    {
        return TypeOfGenderOfRoom::paginate($size);
    }

    public function delete($id)
    {
        $post = $this->typeOfGenderOfRoom->find($id);
        $post->delete();

        return $post;
    }
}
