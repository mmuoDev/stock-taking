<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    //
    public $table = 'stocks';

    protected $fillable = [
        'item_id',
        'prev_quantity',
        'current_quantity'
    ];
}
