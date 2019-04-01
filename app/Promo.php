<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    /**
     * The attributes that are massa assignable
     * 
     * @return array
     */
    protected $fillable = [
    	'code', 'from_id', 'to_id', 'going', 'count', 'count_used', 'discount'
    ];

    /**
     * Get the from center
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function from_place()
    {
    	return $this->hasOne('App\Center', 'id', 'from_id');
    }

    /**
     * Get the to center
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function to_place()
    {
    	return $this->hasOne('App\Center', 'id', 'to_id');
    }
}
