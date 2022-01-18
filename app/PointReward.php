<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PointReward extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'client_id',
        'period_id',
        'point_rule',
        'bonus_amount',
    ];

    public function point_period()
    {
    	return $this->belongsTo('App\PointPeriod','period_id');
    }

    public function point_claim(){
        return $this->hasMany('App\PointClaim','custpoint_id');
    }
}
