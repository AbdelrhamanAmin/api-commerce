<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStoreRequest extends FormRequest
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
            'name'              => ['string', 'sometimes'],
            'is_vat_included'   => ['boolean', 'sometimes'],
            'vat_percentage'    => ['numeric' ,'nullable', 'sometimes'],
            'shipping_cost'     => ['numeric' ,'nullable', 'sometimes']
        ];
    }
}
