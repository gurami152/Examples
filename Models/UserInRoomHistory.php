<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInRoomHistory extends Model
{
    protected $table = 'user_in_room_history';

    protected $fillable = [
        'user_id',
        'room_id',
        'settlementDate_id',
        'checkOutDate',
    ];

    public function getRoom()
    {
        return $this->belongsTo('App\Room', 'room_id', 'id');
    }

    public function getSettlementDate()
    {
        return $this->belongsTo('App\SettlementDate', 'settlementDate_id', 'id');
    }
}
