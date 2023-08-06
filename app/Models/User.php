<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'avatar_url',
        'fname',
        'lname',
        'email',
        'phone_number',
        'address',
        'country',
        'state',
        'city',
        'zip_code',
        'company',
        'isVerified',
        'status',
        'role',
        'email_verified_at',
        'password',
        'isPublic',
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

    protected function toCamelCase($value)
    {
        $segments = explode('_', $value);

        array_walk($segments, function (&$item, $key) {
            if ($key > 0) {
                $item = ucfirst($item);
            }
        });

        return implode('', $segments);
    }

    public function toArray()
    {
        $array = parent::toArray();

        $newArray = [];
        foreach ($array as $key => $value) {
            $newKey = $this->toCamelCase($key);
            $newArray[$newKey] = $value;
        }

        return $newArray;
    }
}
