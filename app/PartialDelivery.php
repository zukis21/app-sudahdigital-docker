<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartialDelivery extends Model
{
    public function orderProduct(){
        return $this->belongsTo('App\order_product','op_id');
    }
}
