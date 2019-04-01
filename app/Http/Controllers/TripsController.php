<?php

namespace App\Http\Controllers;

use App\Trip;
use App\Price;
use App\MyHelper;
use App\Http\Requests\StoreTrip;
use App\Http\Requests\ValidatePrice;

use Illuminate\Http\Request;

class TripsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTrip  $request
     * @return \Illuminate\Http\Response
     */
    public function add_trip(Request $request)
    {
        list($place_from_address, $place_to_address) 
            = MyHelper::sanitizeString($request->place_from_address, $request->place_to_address);

        if ($request->going_type == 'going_and_comingback_otherday') {
            $this->validate($request, [
                'other_day'     => 'bail|required|date',
                'other_time'    => 'bail|required|date_format:H:i',
            ]);
        }

        Trip::create([
            'passenger_id'      => auth()->user()->id,
            'from_id'           => $request->place_from,
            'to_id'             => $request->place_to,
            'from_address'      => $request->place_from_address,
            'to_address'        => $request->place_to_address,
            'date'              => $request->date,
            'time'              => $request->time,
            'notes'             => $request->notes,
            'going'             => $request->going_type,
            'other_day'         => $request->other_day,
            'other_time'        => $request->other_time,
            'promo_code'        => $request->promo_code,
            'price'             => session()->get('price')
        ]);

        session()->flash('success', 'Trip Created Successfully');
        return back();
    }

    /**
     * Get the price of the trip
     * 
     * @param  \App\Http\Requests\ValidatePrice $request
     * @return int
     */
    public function get_price(ValidatePrice $request)
    {
        /*if ($request->promo_code != null) {
            $this->validate($request, [
                'promo_code'    => 'bail|required|string|max:20'
            ]);
        }*/

        $price = Price::where('from_id', $request->place_from)
                        ->where('to_id', $request->place_to)
                        ->where('going', $request->going_type)
                        ->first();

        if ($price) {
            $request->session()->put('price', $price->price);
        }

        return response([
            'message' => 'success',
            'data' => $price
        ]);
    }

    
}
