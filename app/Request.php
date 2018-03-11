<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    //
    public $table = 'requests';

    protected $fillable = [
        'request_category',
        'quantity',
        'reason',
        'item_id',
        'status',
        'added_by',
        'uri',
        'company_id'
    ];
}
