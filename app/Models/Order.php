<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id_orders';
    public $timestamps = false; // Karena menggunakan order_date dan order_complete

    protected $fillable = [
        'orders_code',
        'staff_name',
        'user_id',
        'member_name',
        'member_notes',
        'member_bank',
        'proof_payment',
        'order_status',
        'total_price',
        'order_date',
        'order_complete'
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'order_date' => 'datetime',
        'order_complete' => 'datetime',
    ];

    // Status enum values
    const STATUS_MENUNGGU = 'menunggu';
    const STATUS_DIPROSES = 'diproses';
    const STATUS_SIAP = 'siap';
    const STATUS_SELESAI = 'selesai';
    const STATUS_DIBATALKAN = 'dibatalkan';

    // Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    // Relasi ke OrderDetails
    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id_orders');
    }

    // Method untuk menghitung total dari order details
    public function calculateTotal(): void
    {
        $total = $this->orderDetails()
            ->selectRaw('SUM(product_price * product_quantity) as total')
            ->value('total') ?? 0;
        
        $this->update(['total_price' => $total]);
    }

    // Method untuk generate order code
    public static function generateOrderCode(): string
    {
        $date = Carbon::now()->format('Ymd');
        $lastOrder = self::whereDate('order_date', Carbon::today())
                         ->orderBy('id_orders', 'desc')
                         ->first();
        
        $sequence = 1;
        if ($lastOrder) {
            $lastSequence = (int) substr($lastOrder->orders_code, -3);
            $sequence = $lastSequence + 1;
        }
        
        return 'ORD' . $date . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }

    // Scope untuk filter berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('order_status', $status);
    }

    // Scope untuk filter berdasarkan tanggal
    public function scopeByDate($query, $date)
    {
        return $query->whereDate('order_date', $date);
    }

    // Scope untuk filter berdasarkan user
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Accessor untuk formatted total price
    public function getFormattedTotalPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    // Accessor untuk formatted order date
    public function getFormattedOrderDateAttribute(): string
    {
        return $this->order_date->format('d/m/Y H:i:s');
    }

    // Accessor untuk status badge color
    public function getStatusColorAttribute(): string
    {
        return match($this->order_status) {
            self::STATUS_MENUNGGU => 'warning',
            self::STATUS_DIPROSES => 'info',
            self::STATUS_SIAP => 'primary',
            self::STATUS_SELESAI => 'success',
            self::STATUS_DIBATALKAN => 'danger',
            default => 'secondary'
        };
    }

    // In Order.php
    public function updateStatus($orderId)
    {
        $user = Auth::user();
        
        $order = Order::select('id_orders', 'user_id', 'order_status')
                    ->where('id_orders', $orderId)
                    ->where('user_id', $user->id_user)
                    ->firstOrFail();
        
        if ($order->order_status === 'siap') {
            // Update langsung tanpa load model penuh
            DB::table('orders')
                ->where('id_orders', $orderId)
                ->update([
                    'order_status' => 'selesai',
                    'order_complete' => now()
                ]);
            
            return redirect()->back()->with('success', 'Pesanan berhasil diambil!');
        }
        
        return redirect()->back()->with('error', 'Pesanan tidak dapat diambil saat ini.');
    }

    // Method update status yang lebih efisien
    public function updateStatusFast(string $status, ?string $staffName = null): bool
    {
        $validStatuses = [
            self::STATUS_MENUNGGU,
            self::STATUS_DIPROSES,
            self::STATUS_SIAP,
            self::STATUS_SELESAI,
            self::STATUS_DIBATALKAN
        ];

        if (!in_array($status, $validStatuses)) {
            return false;
        }

        $currentTime = now(); // Waktu real time
        $updateData = ['order_status' => $status];
        
        // Set completion time untuk status final
        if (in_array($status, [self::STATUS_SELESAI, self::STATUS_DIBATALKAN])) {
            $updateData['order_complete'] = $currentTime; // Real time completion
        }
        
        if ($staffName && empty($this->staff_name)) {
            $updateData['staff_name'] = $staffName;
        }

        return DB::transaction(function () use ($updateData, $status) {
            // Update order dengan waktu real time
            $orderUpdated = DB::table('orders')
                ->where('id_orders', $this->id_orders)
                ->update($updateData) > 0;
            
            if ($orderUpdated) {
                $paymentStatus = match($status) {
                    self::STATUS_DIPROSES,
                    self::STATUS_SIAP,
                    self::STATUS_SELESAI => 'lunas',
                    self::STATUS_DIBATALKAN => 'dibatalkan',
                    default => null
                };
                
                if ($paymentStatus) {
                    DB::table('orders_details')
                        ->where('order_id', $this->id_orders)
                        ->update(['payment_status' => $paymentStatus]);
                }
            }

            return $orderUpdated;
        });
    }

    // Method untuk check apakah order dapat dibatalkan
    public function canBeCancelled(): bool
    {
        return in_array($this->order_status, [
            self::STATUS_MENUNGGU,
            self::STATUS_DIPROSES
        ]);
    }

    // Method untuk get available status transitions
    public function getAvailableStatusTransitions(): array
    {
        return match($this->order_status) {
            self::STATUS_MENUNGGU => [
                self::STATUS_DIPROSES,
                self::STATUS_DIBATALKAN
            ],
            self::STATUS_DIPROSES => [
                self::STATUS_SIAP,
                self::STATUS_DIBATALKAN
            ],
            self::STATUS_SIAP => [
                self::STATUS_SELESAI
            ],
            default => []
        };
    }

    // Method untuk get order summary
    public function getOrderSummary(): array
    {
        $details = $this->orderDetails;
        
        return [
            'total_items' => $details->sum('product_quantity'),
            'total_amount' => $this->total_price,
            'status' => $this->order_status,
            'order_date' => $this->order_date,
            'items_count' => $details->count()
        ];
    }

    // Event listeners
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->orders_code)) {
                $order->orders_code = self::generateOrderCode();
            }
            
            if (empty($order->order_date)) {
                $order->order_date = now();
            }
            
            if (empty($order->order_status)) {
                $order->order_status = self::STATUS_MENUNGGU;
            }
        });
    }

    // Static method untuk get all status options
    public static function getStatusOptions(): array
    {
        return [
            self::STATUS_MENUNGGU => 'Menunggu',
            self::STATUS_DIPROSES => 'Diproses',
            self::STATUS_SIAP => 'Siap',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_DIBATALKAN => 'Dibatalkan'
        ];
    }

    // Method untuk export order data
    public function toArray(): array
    {
        $array = parent::toArray();
        $array['formatted_total_price'] = $this->formatted_total_price;
        $array['formatted_order_date'] = $this->formatted_order_date;
        $array['status_color'] = $this->status_color;
        $array['order_summary'] = $this->getOrderSummary();
        
        return $array;
    }
    public function cancelOrder(?string $staffName = null): bool
    {
        if (!$this->canBeCancelled()) {
            return false;
        }
        
        $currentTime = now(); // Real time cancellation
        
        return DB::transaction(function () use ($staffName, $currentTime) {
            $updateData = [
                'order_status' => self::STATUS_DIBATALKAN,
                'order_complete' => $currentTime // Real time cancellation
            ];
            
            if ($staffName && empty($this->staff_name)) {
                $updateData['staff_name'] = $staffName;
            }
            
            $orderUpdated = DB::table('orders')
                ->where('id_orders', $this->id_orders)
                ->update($updateData) > 0;
            
            if ($orderUpdated) {
                DB::table('orders_details')
                    ->where('order_id', $this->id_orders)
                    ->update(['payment_status' => 'dibatalkan']);
            }
            
            return $orderUpdated;
        });
    }
}