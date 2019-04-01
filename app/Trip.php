<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    /**
     * The attributes that are mass assignable
     * 
     * @return array
     */
    protected $fillable = [
    	'passenger_id', 'from_id', 'to_id', 'from_address', 'to_address', 'date', 'time', 'notes',
    	'going', 'other_day', 'other_time', 'promo_code', 'price'
    ];


    /**
     * Get the passenger for the trip
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function passenger()
    {
    	return $this->hasOne('App\User', 'id', 'passenger_id');
    }

    /**
     * Get the from center 
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function from_center()
    {
    	return $this->hasOne('App\Center', 'id', 'from_id');
    }

    /**
     * Get the to center 
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function to_center()
    {
    	return $this->hasOne('App\Center', 'id', 'to_id');
    }
}
