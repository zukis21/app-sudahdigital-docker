<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spv_sales extends Model
{
    protected $table = 'spv_sales';
    protected $fillable = ['spv_id', 
                            'sls_id',
                            'status',
                            'created_at',
                            'updated_at'
                          ];

    public function targets_spv_sls(){
        return $this->belongsTo('App\Sales_Targets','sls_id');
    }

    public function customer(){
      return $this->belongsTo('App\Customer','sls_id');
    }

    public function orders(){
      return $this->belongsTo('App\Order','sls_id');
    }
}

