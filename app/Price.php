<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = [
    	'from_id', 'to_id', 'price'
    ];

    public function place_from()
    {
    	return $this->hasOne('App\Center', 'id', 'from_id');
    }

    public function place_to()
    {
    	return $this->hasOne('App\Center', 'id', 'to_id');
    }
}
