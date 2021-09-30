<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PointPeriod extends Model
{
    public function point_reward()
    {
    	return $this->hasMany('App\PointReward','period_id');
    }
}
