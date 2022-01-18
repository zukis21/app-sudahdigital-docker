<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VolumeDiscount extends Model
{
    public function item(){
        return $this->hasMany('App\VolumeDiscountProduct','volume_id');
    }

    public function getTotalItemAttribute(){
        $total = 0;
        foreach($this->item as $p){
            $total = $total+1;
        }
        return $total;
    }
}
