<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidatePromo extends FormRequest
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
            'place_from'    => 'bail|required|exists:centers,id',
            'place_to'      => 'bail|required|exists:centers,id',
            'going_type'    => 'bail|required|in:going,going_and_comingback,going_and_comingback_otherday',
            'promo_code'    => 'bail|required|string|max:20'
        ];
    }
}
