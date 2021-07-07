<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    protected $fillable = [
        'familyStatementFile'
    ];

    protected $table = 'family';
}
