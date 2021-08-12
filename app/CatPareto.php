<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatPareto extends Model
{
    protected $table = 'cat_pareto';
    protected $fillable = [
        'pareto_code', 
        'name', 
        'client_id',
        'position',
        'status',
        'created_at',
        'updated_at',
    ];
}
