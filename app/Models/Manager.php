<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Manager extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'password_1',
        'password_2',
        'name',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password_1',
        'password_2',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
        'password_1' => 'hashed',
        'password_2' => 'hashed',
    ];

    public function getAuthPassword()
    {
        return $this->password_1;
    }

    public function approvedBusinesses()
    {
        return $this->hasMany(Business::class, 'approved_by');
    }
}
