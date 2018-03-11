<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestComment extends Model
{
    //
    public $table = 'requests_comments';

    protected $fillable = [
        'comment',
        'user_id',
        'request_id'
    ];
}
