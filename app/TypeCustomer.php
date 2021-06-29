<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeCustomer extends Model
{
    protected $table = 'type_customer';
    protected $fillable = ['name', 
                            'status',
                            'client_id',
                            'created_at',
                            'updated_at'
                          ];
    
    public function customers(){
      return $this->hasMany('App\Customer','type_cust');
    }
}
