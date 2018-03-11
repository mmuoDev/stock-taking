<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestStatusLog extends Model
{
    //
    public $table  = 'requests_status_log';

    protected $fillable = [
        'request_id',
        'user_id',
        'status'
    ];
}
