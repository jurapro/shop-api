<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;


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

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->setRole('user');
        });
    }


    public function generateToken()
    {
        $this->user_token = Hash::make(Str::random());
        $this->save();
        return $this->user_token;
    }

    public function clearToken()
    {
        $this->user_token = null;
        $this->save();
    }

    public function setRole(string $code)
    {
        $this->role_id = Role::where('code', $code)->first()->id;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function cart()
    {
        return $this->hasMany(ProductCart::class);
    }
}
