<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerPoint extends Model
{
    protected $fillable = [
        'client_id',
        'customer_id',
        'period_id',
    ];

    public function point_period()
    {
    	return $this->belongsTo('App\PointPeriod','period_id');
    }

    public function customers(){
        return $this->belongsToMany('App\Customer','customer_id');
    }

    public function point_claim(){
        return $this->hasMany('App\PointClaim','custpoint_id');
    }
}
