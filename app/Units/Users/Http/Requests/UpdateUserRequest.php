<?php

namespace App\Units\Users\Http\Requests;

use App\Support\Http\Request;

class UpdateUserRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => ['required', 'string', 'max:255'],
            'phone'         => ['string'],
            'birth_date'    => ['date'],
            'cpf'           => ['required', 'cpf'],
            'password'      => ['string', 'min:8'],
        ];
    }
}
