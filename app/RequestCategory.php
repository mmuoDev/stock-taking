<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestCategory extends Model
{
    //
    public $table = 'request_categories';

    protected $fillable = [
        'category'
    ];
}
