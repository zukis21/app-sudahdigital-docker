<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductReward extends Model
{
    protected $fillable = [
        'client_id',
        'product_id',
        'quantity_rule',
        'prod_point_val',
        'starts_at',
        'expires_at',
    ];

    public function products()
    {
    	return $this->belongsTo('App\product','product_id');
    }

}
