<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    public $table = 'categories';

    protected $fillable = [
        'name',
        'created_by',
        'company_id'
    ];
}
