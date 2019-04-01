<?php

namespace App\Http\Controllers;

use App\Trip;
use App\Price;
use App\Promo;
use App\MyHelper;
use App\Http\Requests\StoreTrip;
use App\Http\Requests\ValidatePrice;
use App\Http\Requests\ValidatePromo;

use Illuminate\Http\Request;

class TripsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTrip  $request
     * @return \Illuminate\Http\Response
     */
    public function add_trip(StoreTrip $request)
    {
        if (!Auth::check()) {
            session()->flash('error', 'You must login to book a trip');
            return back();
        }

        list($place_from_address, $place_to_address) 
            = MyHelper::sanitizeString($request->place_from_address, $request->place_to_address);

        if ($request->going_type == 'going_and_comingback_otherday') {
            $this->validate($request, [
                'other_date'    => 'bail|required|date',
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
     * @return object
     */
    public function get_price(ValidatePrice $request)
    {
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

    /**
     * Check the promo code 
     * 
     * @param  \Illuminate\Http\Request $request
     * @return bool|object
     */
    public function promo(ValidatePromo $request)
    {
        $promo = Promo::where('code', $request->promo_code)
                        ->where('from_id', $request->place_from)
                        ->where('to_id', $request->place_to)
                        ->where('going', $request->going_type)
                        ->first();

        if ($promo) 
        {
            if ($promo->count_used < $promo->count) {
                $promo->count_used++;
                $promo->save();
                $price = (session()->get('price') - $promo->discount);
                session()->put('promo', $promo->discount);
                session()->put('price', $price);

                return response([
                    'message'   => 'success',
                    'data'      => $price
                ]);
            } else {
                return response([
                    'message'   => 'expired',
                    'data'      => null
                ]);
            }
        }

        return response([
            'message'   => 'code_not_found',
            'data'      => null
        ]);
    }
}
