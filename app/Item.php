<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    public $table = 'items';

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'code',
        'date_added',
        'created_by',
        'uri',
        'company_id'
    ];
}
