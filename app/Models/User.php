<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'avatar_url',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'address',
        'country',
        'state',
        'city',
        'zip_code',
        'company',
        'is_verified',
        'status',
        'role_id',
        'email_verified_at',
        'password',
        'is_public',
        'about'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // protected function toCamelCase($value)
    // {
    //     $segments = explode('_', $value);

    //     array_walk($segments, function (&$item, $key) {
    //         if ($key > 0) {
    //             $item = ucfirst($item);
    //         }
    //     });

    //     return implode('', $segments);
    // }

    // public function toArray()
    // {
    //     $array = parent::toArray();

    //     $newArray = [];
    //     foreach ($array as $key => $value) {
    //         $newKey = $this->toCamelCase($key);
    //         $newArray[$newKey] = $value;
    //     }

    //     return $newArray;
    // }
}
