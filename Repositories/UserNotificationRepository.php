<?php


namespace App\Repositories;


use App\UserNotification;

class UserNotificationRepository
{
    /**
     * @var UserNotification $userNotification
     */
    protected $userNotification;

    /**
     * UserNotificationRepository constructor.
     * @param UserNotification $userNotification
     */
    public function __construct(UserNotification $userNotification)
    {
        $this->userNotification = $userNotification;
    }

    public function create($user_id,$notification_id)
    {
        $this->userNotification->create(
            [
                'users_id' => $user_id,
                'notification_id' => $notification_id,
                'takenIntoConsideration' => false,
                'takenIntoConsiderationByAdmin' => false,
            ]
        );
    }

    public function selectByUser($id){
        return $this->userNotification->where('users_id',$id)->get()->sortByDesc('id');
    }

}
