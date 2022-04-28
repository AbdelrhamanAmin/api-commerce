<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'name_ar'           => ['string', 'required', 'max:250'],
            'name_en'           => ['string' ,'required', 'max:250'],
            'description_ar'    => ['string' ,'required', 'max:250'],
            'description_en'    => ['string' ,'required', 'max:250'],
            'price'             => ['numeric' ,'required']
        ];
    }
}
