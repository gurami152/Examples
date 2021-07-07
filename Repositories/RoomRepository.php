<?php


namespace App\Repositories;


use App\Room;
use Illuminate\Database\Eloquent\Builder;

class RoomRepository
{
    /**
     * @var Room $room
     */
    protected $room;

    /**
     * @return Builder
     */
    protected function getQueryBuilder(): Builder
    {
        return $this->room->query();
    }

    /**
     * RoomRepository constructor.
     * @param Room $room
     */
    public function __construct(Room $room)
    {
        $this->room = $room;
    }

    public function all()
    {
        return $this->room->all();
    }

    public function paginated($size)
    {
        return $this->room->paginate($size);
    }

    public function selectBy(array $criteria){
        $query = $this->getQueryBuilder()
            ->whereRowValues(array_keys($criteria), '=', array_values($criteria));
        return $query->get();
    }

    public function create($number,$numberOfPersons,$flour_id, $dorm_id,$type_id,$room_id)
    {
        $this->room->create([
            'number' => $number,
            'numberOfPersons' => (integer)$numberOfPersons,
            'flour_id' => $flour_id,
            'dormBlock_id' => $dorm_id,
            'roomStatus_id' => $room_id,
            'typeOfGenderOfRoom_id' => $type_id
        ]);
    }

    public function edit($id, $number,$numberOfPersons,$flour_id,$dormBlock_id,$roomStatus_id,$typeOfGenderOfRoom_id)
    {
        $room = $this->room->findOrFail($id);
        $room->number = $number;
        $room->numberOfPersons = $numberOfPersons;
        $room->flour_id = $flour_id;
        $room->dormBlock_id = $dormBlock_id;
        $room->roomStatus_id = $roomStatus_id;
        $room->typeOfGenderOfRoom_id = $typeOfGenderOfRoom_id;
        $room->save();
    }

    public function delete($id)
    {
        $this->room->where('id', $id)->delete();
    }
}
