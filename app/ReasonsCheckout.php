<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReasonsCheckout extends Model
{
    protected $fillable = [
        'reasons_name', 'position'
    ];
}
