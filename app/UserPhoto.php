<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPhoto extends Model
{
    //
    public $table = 'user_photos';

    protected $fillable = [
        'user_id',
        'original_file_name',
        'uri',
        'new_name'
    ];
}
