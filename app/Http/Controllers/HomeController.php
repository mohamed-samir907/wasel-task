<?php

namespace App\Http\Controllers;

use App\Price;
use App\Center;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function add_trip()
    {
        $centers = Center::all();
        
        $price = Price::where('from_id', $centers[0]->id)
                        ->where('to_id', $centers[1]->id)
                        ->where('going', 'going')
                        ->first();

        session()->put('price', $price->price);
        
        return view('welcome', compact('price', 'centers'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
