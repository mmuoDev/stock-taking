<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    public $table = 'companies';

    protected $fillable = [
        'company',
        'item_limit',
        'request_limit',
        'category_limit',
        'user_limit'
    ];
}
