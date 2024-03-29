<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'role_name',
        'role_permissions'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }

    public function getRolePermissionsAttribute($value)
    {
        return unserialize($value);
    }
}
