<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTarget extends Model
{
    public function store_targets()
    {
    	return $this->belongsTo('App\Store_Targets','storeTargetId');
    }

    public function products(){
        return $this->belongsTo('App\product','productId');
    }
}
