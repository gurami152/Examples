<?php

namespace App\Http\Controllers;

use App\Repositories\UserNotificationRepository;
use App\User;
use App\UserNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserNotificationController extends Controller
{
    /**
     * @var UserNotificationRepository
     */
    protected $userNotificationRepository;

    /**
     * UserNotificationController constructor.
     * @param UserNotificationRepository $userNotificationRepository
     */
    public function __construct(UserNotificationRepository $userNotificationRepository)
    {
        $this->userNotificationRepository = $userNotificationRepository;
    }

    public function create(Request $request)
    {
        $this->userNotificationRepository->create($request['user_id'], $request['notification_id']);
        $user = User::find($request['user_id']);
        $data["email"] = $user->email;
        $data["title"] = "Гуртожитки ЗНУ повідомлення";
        $data["body"] = "https://app-hostel.znu.edu.ua/login";

        Mail::send('student.emails.notification',["data" => $data], function($message) use($data){
            $message->to($data["email"], $data["email"])->subject($data["title"]);
            $message->from('vospotdel@znu.edu.ua', 'vospotdel');
        });
    }

    public function answer($id)
    {
        $user = UserNotification::find($id);
        $user->takenIntoConsideration = !$user->takenIntoConsideration;
        $user->save();
    }

    public function answeredByUsers()
    {
        Carbon::setLocale('uk');
        $notifications = UserNotification::with('notification', 'user')->where('takenIntoConsiderationByAdmin', 0)->where('takenIntoConsideration', 1)->orderBy('updated_at', 'desc')->get();
        foreach ($notifications as $notification) {
            $notification['updated_at_for_human'] = Carbon::parse($notification['updated_at'])->diffForHumans();
        }
        return response()->json($notifications);
    }

    public function answeredByAdmin(Request $request)
    {
        $user = UserNotification::find($request->id);
        $user->takenIntoConsiderationByAdmin = !$user->takenIntoConsiderationByAdmin;
        $user->save();
    }
}
