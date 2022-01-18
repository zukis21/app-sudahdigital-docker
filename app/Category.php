<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    use SoftDeletes;

    public function products(){
        return $this->belongsToMany('App\product');
    }

    /*public function getRouteKeyName()
    //{
        return 'slug';
    }*/

    public function subcategory()
    {
        return $this->hasMany('App\Category', 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Category', 'parent_id');
    }

} 
