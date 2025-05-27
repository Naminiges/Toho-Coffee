<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'members';
    protected $primaryKey = 'id_member';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'member_phone',
        'birth_date',
        'gender',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'gender' => 'string',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'member_id', 'id_member');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'member_id', 'id_member');
    }
}