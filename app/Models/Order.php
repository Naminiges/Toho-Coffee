<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'orders';
    protected $primaryKey = 'id_orders';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'orders_code',
        'staff_name',
        'member_id',
        'member_name',
        'member_notes',
        'member_bank',
        'proof_payment',
        'order_status',
        'total_price',
        'order_date',
        'order_complete',
    ];

    protected function casts(): array
    {
        return [
            'total_price' => 'decimal:2',
            'order_status' => 'string',
            'order_date' => 'datetime',
            'order_complete' => 'datetime',
        ];
    }

    // Relationships
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id_member');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id_orders');
    }
}