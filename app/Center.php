<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    /**
     * The attributes that are mass assignable
     * 
     * @return array
     */
    protected $fillable = ['name'];
}
