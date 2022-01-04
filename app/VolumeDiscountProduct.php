<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VolumeDiscountProduct extends Model
{
    public function products(){
        return $this->belongsTo('App\product','product_id');
    }

    public function order_product(){
        return $this->belongsTo('App\order_product','product_id','product_id');
    }
}
