<?php


namespace App\Repositories;


use App\Notification;

class NotificationRepository
{
    /**
     * @var Notification $notification
     */
    protected $notification;

    /**
     * NotificationRepository constructor.
     * @param Notification $notification
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function all()
    {
        return $this->notification->all();
    }

    public function paginated($size)
    {
        return $this->notification->paginate($size);
    }

    public function selected($id)
    {
        return $this->notification->where('id',$id)->first();
    }

    public function create($request)
    {
        return $this->notification->create([
            'text' => $request['text'],
            'link' => $request['link'],
            'name' => $request['name'],
            'isInput' => $request['isInput'],
            'inputText' => $request['inputText'],
            'inputType' => $request['inputType'],
            'countOfFields' => $request['countOfFields']
        ]);
    }

}
