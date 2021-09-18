<?php

namespace App\Http\Requests;

class SignupRequest extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'unique:users', 'email'],
            'password' => ['required', 'min:6'],
        ];
    }
}
