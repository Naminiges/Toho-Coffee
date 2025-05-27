<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'products';
    protected $primaryKey = 'id_product';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'description_id',
        'product_name',
        'product_price',
        'product_status',
    ];

    protected function casts(): array
    {
        return [
            'product_price' => 'decimal:2',
            'product_status' => 'string',
        ];
    }

    // Relationships
    public function productDescription()
    {
        return $this->belongsTo(ProductDescription::class, 'description_id', 'id_description');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id', 'id_product');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_id', 'id_product');
    }
}