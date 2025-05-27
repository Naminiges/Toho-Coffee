<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class OrderDetail extends Model
{
    protected $table = 'orders_details';
    protected $primaryKey = 'id_order_detail';
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
        'product_quantity'
    ];

    protected $casts = [
        'product_price' => 'decimal:2',
        'product_quantity' => 'integer',
        'pickup_time' => 'datetime'
    ];

    // Relasi ke Order
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id_orders');
    }

    // Relasi ke Product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id_product');
    }

    // Method untuk menghitung total - PERBAIKAN ERROR
    public function calculateTotal(): float
    {
        // Menggunakan DB::raw untuk operasi matematika
        $total = $this->orderDetails()
            ->selectRaw('SUM(product_price * product_quantity) as total')
            ->value('total');
        
        // Update total_price menggunakan DB::raw
        $this->update([
            'total_price' => DB::raw('product_price * product_quantity')
        ]);
        
        return (float) $total;
    }

    // Alternative method menggunakan Eloquent Collection
    public function calculateTotalAlternative(): float
    {
        $details = $this->orderDetails()->get();
        $total = $details->sum(function ($detail) {
            return $detail->product_price * $detail->product_quantity;
        });
        
        $this->update(['total_price' => $total]);
        
        return $total;
    }

    // Method untuk menghitung subtotal per item
    public function calculateSubtotal(): void
    {
        $subtotal = $this->product_price * $this->product_quantity;
        $this->update(['subtotal' => $subtotal]);
    }

    // Scope untuk filter berdasarkan order
    public function scopeForOrder($query, $orderId)
    {
        return $query->where('order_id', $orderId);
    }

    // Accessor untuk formatted price
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->product_price, 0, ',', '.');
    }

    // Accessor untuk formatted subtotal
    public function getFormattedSubtotalAttribute(): string
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    // Method untuk menghitung total order (static)
    public static function calculateOrderTotal($orderId): float
    {
        return self::where('order_id', $orderId)
            ->selectRaw('SUM(product_price * product_quantity) as total')
            ->value('total') ?? 0;
    }

    // Event listeners
    protected static function boot()
    {
        parent::boot();

        // Auto calculate subtotal saat creating
        static::creating(function ($orderDetail) {
            $orderDetail->subtotal = $orderDetail->product_price * $orderDetail->product_quantity;
        });

        // Auto calculate subtotal saat updating
        static::updating(function ($orderDetail) {
            if ($orderDetail->isDirty(['product_price', 'product_quantity'])) {
                $orderDetail->subtotal = $orderDetail->product_price * $orderDetail->product_quantity;
            }
        });
    }
}