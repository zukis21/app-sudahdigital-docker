<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store_Targets extends Model
{
    protected $table = "store_target";
    
    protected $fillable = [
        'client_id',
        'customer_id', 
        'target_values', 
        'target_achievement',
        'period',
        'created_by',
        'updated_by',
        'version_pareto',
        'target_type',
        'target_quantity'
    ];

    public function customers(){
        return $this->belongsTo('App\Customer','customer_id');
    }

    public function created_of(){
        return $this->belongsTo('App\User','created_by');
    }

    public function updated_of(){
        return $this->belongsTo('App\User','updated_by');
    }

    public function pareto(){
        return $this->belongsTo('App\CatPareto','version_pareto');
    }

    public function product_target()
    {
    	return $this->hasMany('App\ProductTarget','storeTargetId');
    }

    public function getTotalNominalAttribute(){
        $total_nominal = 0;
        foreach($this->product_target as $n){
            $total_nominal += $n->nominalValues;
        }
        return $total_nominal;
    }

    public function getTotalQtyAttribute(){
        $totalQty = 0;
        foreach($this->product_target as $q){
            $totalQty += $q->quantityValues;
        }
        return $totalQty;
    }
}
