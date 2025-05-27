<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id_product';
    public $incrementing = true;
    protected $keyType = 'int';

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
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // Relationships
    public function description()
    {
        return $this->belongsTo(ProductDescription::class, 'description_id', 'id_description');
    }

    public function category()
    {
        return $this->hasOneThrough(
            Category::class,
            ProductDescription::class,
            'id_description', // Foreign key on product_descriptions table
            'id_category', // Foreign key on categories table
            'description_id', // Local key on products table
            'category_id' // Local key on product_descriptions table
        );
    }

    public function temperatureType()
    {
        return $this->hasOneThrough(
            TemperatureType::class,
            ProductDescription::class,
            'id_description', // Foreign key on product_descriptions table
            'id_temperature', // Foreign key on temperature_types table
            'description_id', // Local key on products table
            'temperature_id' // Local key on product_descriptions table
        );
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id', 'id_product');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_id', 'id_product');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('product_status', 'aktif');
    }

    public function scopeInactive($query)
    {
        return $query->where('product_status', 'nonaktif');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->whereHas('description', function ($q) use ($categoryId) {
            $q->where('category_id', $categoryId);
        });
    }

    public function scopeByTemperature($query, $temperature)
    {
        return $query->whereHas('description.temperatureType', function ($q) use ($temperature) {
            $q->where('temperature', $temperature);
        });
    }

    public function scopePriceBetween($query, $min, $max)
    {
        return $query->whereBetween('product_price', [$min, $max]);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('product_name', 'like', '%' . $search . '%')
                    ->orWhereHas('description', function ($q) use ($search) {
                        $q->where('product_description', 'like', '%' . $search . '%');
                    });
    }

    // Accessors & Mutators
    public function getIsActiveAttribute()
    {
        return $this->product_status === 'aktif';
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->product_price, 0, ',', '.');
    }

    public function getPriceInCentsAttribute()
    {
        return $this->product_price * 100;
    }

    // Methods
    public function activate()
    {
        $this->update(['product_status' => 'aktif']);
    }

    public function deactivate()
    {
        $this->update(['product_status' => 'nonaktif']);
    }
}