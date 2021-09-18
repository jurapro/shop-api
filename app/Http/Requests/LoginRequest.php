<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = User::where('email', $this->email)->where('password', $this->password)->first();
        if (!$user) {
            return false;
        }
        Auth::login($user);
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
            'email' => 'required',
            'password' => 'required',
        ];
    }
}
