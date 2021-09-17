<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'fio',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    static function createUser(Request $request)
    {
        $user = new User;
        $user->fio = $request['fio'];
        $user->email = $request['email'];
        $user->password = Hash::make($request['password']);
        $user->role_id = 2;
        $user->generateToken();
        return $user;
    }

    public function generateToken()
    {
        $this->user_token = Hash::make(Str::random());
        $this->save();
        return $this->user_token;
    }
}
