<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrip extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'place_from'            => 'bail|required|exists:centers,id',
            'place_to'              => 'bail|required|exists:centers,id',
            'place_from_address'    => 'bail|required|string|max:255',
            'place_to_address'      => 'bail|required|string|max:255',
            'date'                  => 'bail|required|date',
            'time'                  => 'bail|required|date_format:H:i',
            'notes'                 => 'bail|nullable|string',
            'going_type'            => 'bail|required|in:going,going_and_comingback,going_and_comingback_otherday',
            'other_day'             => 'bail|nullable|date',
            'other_time'            => 'bail|nullable|date_format:H:i',
            'promo_code'            => 'bail|nullable|string|max:20'
        ];
    }
}
