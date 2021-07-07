<?php

namespace App\Http\Controllers;

use App\Services\UserInRoomService;
use Illuminate\Http\Request;

class UserInRoomController extends Controller
{
    /**
     * @var UserInRoomService $userInRoomService
     */
    protected $userInRoomService;

    /**
     * UserInRoomController constructor.
     * @param UserInRoomService $userInRoomService
     */
    public function __construct(UserInRoomService $userInRoomService)
    {
        $this->userInRoomService = $userInRoomService;
    }

    public function changeUserInRoomStatus(Request $request){
        $this->userInRoomService->add($request->id);
    }

    public function assignToRoom(Request $request){
        $this->userInRoomService->assignToRoom($request->user_id, $request->room_id);
    }
}
