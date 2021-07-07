<?php


namespace App\Repositories;


use App\UserRoomSelection;

class UserRoomSelectionRepository
{
    /**
     * @var UserRoomSelection $userRoomSelection
     */
    protected $userRoomSelection;

    /**
     * UserRoomSelectionRepository constructor.
     * @param UserRoomSelection $userRoomSelection
     */
    public function __construct(UserRoomSelection $userRoomSelection)
    {
        $this->userRoomSelection = $userRoomSelection;
    }

    public function create($user, $room, $type)
    {
        $this->userRoomSelection->create([
            'user_id' => $user,
            'room_id' => $room,
            'typeOfUserRoomSelection_id' => $type,
        ]);
    }
}
