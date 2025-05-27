<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';
    protected $primaryKey = 'id_cart';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'product_id',
        'item_quantity',
    ];

    protected function casts(): array
    {
        return [
            'item_quantity' => 'integer',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id_product');
    }

    // Scopes
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    public function scopeWithActiveProducts($query)
    {
        return $query->whereHas('product', function ($q) {
            $q->where('product_status', 'aktif');
        });
    }

    // Accessors
    public function getSubtotalAttribute()
    {
        return $this->item_quantity * $this->product->product_price;
    }

    public function getFormattedSubtotalAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    // Methods
    public function increaseQuantity($amount = 1)
    {
        $this->increment('item_quantity', $amount);
    }

    public function decreaseQuantity($amount = 1)
    {
        if ($this->item_quantity > $amount) {
            $this->decrement('item_quantity', $amount);
        } else {
            $this->delete();
        }
    }

    public function updateQuantity($quantity)
    {
        if ($quantity <= 0) {
            $this->delete();
        } else {
            $this->update(['item_quantity' => $quantity]);
        }
    }

    // Static methods
    public static function addToCart($userId, $productId, $quantity = 1)
    {
        $cartItem = static::where('user_id', $userId)
                          ->where('product_id', $productId)
                          ->first();

        if ($cartItem) {
            $cartItem->increaseQuantity($quantity);
            return $cartItem;
        }

        return static::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'item_quantity' => $quantity,
        ]);
    }

    public static function getUserCartTotal($userId)
    {
        return static::byUser($userId)
                    ->with('product')
                    ->get()
                    ->sum(function ($item) {
                        return $item->subtotal;
                    });
    }

    public static function getUserCartCount($userId)
    {
        return static::byUser($userId)->sum('item_quantity');
    }
}