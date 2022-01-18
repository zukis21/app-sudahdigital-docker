<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PointClaim extends Model
{
    public function customers(){
        return $this->belongsTo('App\Customer','custpoint_id');
    }
}
