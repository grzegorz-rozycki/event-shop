<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCartItem extends FormRequest
{
    public function rules()
    {
        return [
            'id' => 'required|integer',
            'amount' => 'required|integer',
        ];
    }
}
