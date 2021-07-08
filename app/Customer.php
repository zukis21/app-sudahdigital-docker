<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{   
    protected $table = "customers";
 
    protected $fillable = ['store_code','name','email','phone','store_name','city_id','address','payment_term'];

    public function users(){
        return $this->belongsTo('App\User','user_id');
    }

    public function cities(){
        return $this->belongsTo('App\City','city_id');
    }

    public function type_cust(){
        return $this->belongsTo('App\TypeCustomer','cust_type');
    }

    public function orders(){
        return $this->hasMany('App\Order','customer_id');
    }

}
