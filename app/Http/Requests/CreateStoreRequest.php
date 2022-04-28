<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (Auth()->user()->role === User::SELLER_ROLE);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => ['string', 'required'],
            'is_vat_included'   => ['boolean' ,'nullable'],
            'vat_percentage'    => ['numeric' ,'nullable', 'max:100'],
            'shipping_cost'     => ['numeric' ,'nullable']
        ];
    }
}
