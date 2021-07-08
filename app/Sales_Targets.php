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
        'updated_at'
    ];

    public function users(){
        return $this->hasOne('App\user','id');
    }

    public function sls_exists_spv(){
        return $this->belongsTo('App\Spv_sales','user_id','sls_id');
    }
}
