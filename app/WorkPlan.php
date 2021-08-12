<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkPlan extends Model
{
    public function holidays(){
        return $this->hasMany('App\Holiday','wp_id');
    }
}
