<?php


namespace App\Services;


use App\Repositories\NotificationRepository;
use App\Repositories\UserNotificationRepository;

class UserNotificationService
{
    /**
     * @var UserNotificationRepository $userNotificationRepository
     */
    protected $userNotificationRepository;
    /**
     * @var NotificationRepository $notificationRepository
     */
    protected $notificationRepository;

    /**
     * UserNotificationService constructor.
     * @param UserNotificationRepository $userNotificationRepository
     * @param NotificationRepository $notificationRepository
     */
    public function __construct(UserNotificationRepository $userNotificationRepository, NotificationRepository$notificationRepository)
    {
        $this->userNotificationRepository = $userNotificationRepository;
        $this->notificationRepository = $notificationRepository;
    }


    public function selectByUser($id): array
    {
        $notifications = array();
        foreach ($this->userNotificationRepository->selectByUser($id) as $notification){
            $notify = $this->notificationRepository->selected($notification->notification_id);
            $notify['userNotification'] = $notification;
            $notifications[] = $notify;
        }
        return $notifications;
    }
}
