<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales_Targets extends Model
{
    protected $table = "sales_targets";

    protected $fillable = [
        'user_id', 
        'target_values', 
        'target_achievement',
        'period',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];

    public function users(){
        return $this->belongsTo('App\User','user_id');
    }

    public function sls_exists_spv(){
        return $this->belongsTo('App\Spv_sales','user_id','sls_id');
    }

    public function created_of(){
        return $this->belongsTo('App\User','created_by');
    }

    public function updated_of(){
        return $this->belongsTo('App\User','updated_by');
    }
}
