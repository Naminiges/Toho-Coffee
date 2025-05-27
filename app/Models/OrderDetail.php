<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'orders_details';
    protected $primaryKey = 'id_order_detail';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'pickup_telephone',
        'pickup_email',
        'pickup_place',
        'pickup_time',
        'pickup_method',
        'payment_method',
        'payment_status',
        'bank_number',
        'product_id',
        'product_price',
        'product_quantity',
    ];

    protected function casts(): array
    {
        return [
            'pickup_time' => 'datetime',
            'product_price' => 'decimal:2',
            'product_quantity' => 'integer',
        ];
    }

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id_orders');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id_product');
    }
}