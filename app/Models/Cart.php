<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'carts';
    protected $primaryKey = 'id_cart';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'member_id',
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

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id_product');
    }
}