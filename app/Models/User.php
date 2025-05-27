<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'email',
        'google_id',
        'password',
        'role',
        'user_status',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string',
            'user_status' => 'string',
        ];
    }

    // Relationships
    public function member()
    {
        return $this->hasOne(Member::class, 'user_id', 'id_user');
    }

    public function staff()
    {
        return $this->hasOne(Staff::class, 'user_id', 'id_user');
    }
}
