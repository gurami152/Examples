<?php


namespace App\Services;


use App\Repositories\RoomRepository;

class RoomService
{
    /**
     * @var RoomRepository $roomRepository
     */
    protected $roomRepository;

    /**
     * RoomService constructor.
     * @param RoomRepository $roomRepository
     */
    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    public function allData()
    {
        return $this->roomRepository->all();
    }


    public function paginatedData($size)
    {
        $rooms = $this->roomRepository->paginated($size);
        foreach ($rooms as $room) {
            $flour = $room->hasOne('App\Flour', 'id', 'flour_id')->first();
            if (!empty($flour)) {
                $room['flour_id'] = $flour->name;
            }
            $dormBlock = $room->hasOne('App\DormBlock', 'id', 'dormBlock_id')->first();
            if (!empty($dormBlock)) {
                $room['dormBlock_id'] = $dormBlock->name;
            }
            $roomStatus = $room->hasOne('App\RoomStatus', 'id', 'roomStatus_id')->first();
            $room['roomStatus_id'] = $roomStatus->name;
            $typeOfGenderOfRoom = $room->hasOne('App\TypeOfGenderOfRoom', 'id', 'typeOfGenderOfRoom_id')->first();
            $room['typeOfGenderOfRoom_id'] = $typeOfGenderOfRoom->name;

        }

        return $rooms;
    }

    public function create($data)
    {

            $number = $data['number'];
            $numberOfPersons = $data['numberOfPersons'];
            $roomStatus = $data['room_id'];
            $typeOfGenderOfRoom = $data['type_id'];
            if (!empty($number)) {
                if (!empty($numberOfPersons)) {
                    if (!empty($roomStatus)) {
                            if (!empty($typeOfGenderOfRoom)) {
                                $this->roomRepository->create($number,
                                    $numberOfPersons, $data['flour_id'], $data['dorm_id'],
                                    $typeOfGenderOfRoom, $roomStatus);
                            }
                    }
                }
            }
    }
    public function edit($data, $id)
    {
        $this->roomRepository->edit($id,$data['number'],$data['numberOfPersons'],$data['flour_id'],$data['dorm_id'],$data['room_id'],$data['type_id']);
    }

    public function delete($id)
    {
        $result = ['status' => 200];
        try {
            $this->roomRepository->delete($id);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
    }
}
