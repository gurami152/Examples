<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInRoom extends Model
{
    protected $table = 'user_in_room';

    protected $fillable = [
        'user_id',
        'room_id',
        'isSettled',
    ];

    public function getRoom()
    {
        return $this->belongsTo('App\Room', 'room_id', 'id');
    }
}
