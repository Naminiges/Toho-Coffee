<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id_product';
    
    protected $fillable = [
        'description_id',
        'product_name',
        'product_price',
        'product_status'
    ];

    protected $casts = [
        'product_price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relationship to product description
     */
    public function description()
    {
        return $this->belongsTo(ProductDescription::class, 'description_id', 'id_description');
    }

    /**
     * Get category through description
     */
    public function category()
    {
        return $this->hasOneThrough(
            Category::class,
            ProductDescription::class,
            'id_description', // Foreign key on product_descriptions table
            'id_category',    // Foreign key on categories table
            'description_id', // Local key on products table
            'category_id'     // Local key on product_descriptions table
        );
    }

    /**
     * Get temperature type through description
     */
    public function temperatureType()
    {
        return $this->hasOneThrough(
            TemperatureType::class,
            ProductDescription::class,
            'id_description',    // Foreign key on product_descriptions table
            'id_temperature',    // Foreign key on temperature_types table
            'description_id',    // Local key on products table
            'temperature_id'     // Local key on product_descriptions table
        );
    }

    /**
     * Scope for active products
     */
    public function scopeActive($query)
    {
        return $query->where('product_status', 'aktif');
    }

    /**
     * Scope for inactive products
     */
    public function scopeInactive($query)
    {
        return $query->where('product_status', 'nonaktif');
    }

    /**
     * Scope for search
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('product_name', 'LIKE', "%{$search}%")
              ->orWhereHas('description', function($subQ) use ($search) {
                  $subQ->where('product_description', 'LIKE', "%{$search}%");
              });
        });
    }

    /**
     * Scope for filtering by category
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->whereHas('description', function($q) use ($categoryId) {
            $q->where('category_id', $categoryId);
        });
    }

    /**
     * Scope for filtering by temperature
     */
    public function scopeByTemperature($query, $temperatureId)
    {
        return $query->whereHas('description', function($q) use ($temperatureId) {
            $q->where('temperature_id', $temperatureId);
        });
    }

    /**
     * Scope for price range
     */
    public function scopePriceBetween($query, $minPrice, $maxPrice)
    {
        return $query->whereBetween('product_price', [$minPrice, $maxPrice]);
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->product_price, 0, ',', '.');
    }

    /**
     * Get product image URL
     */
    public function getImageUrlAttribute()
    {
        $imageName = $this->description->product_photo ?? 'default-product.jpg';
        return asset('images/' . $imageName);
    }

    /**
     * Check if product is active
     */
    public function getIsActiveAttribute()
    {
        return $this->product_status === 'aktif';
    }

    /**
     * Activate product
     */
    public function activate()
    {
        return $this->update(['product_status' => 'aktif']);
    }

    /**
     * Deactivate product
     */
    public function deactivate()
    {
        return $this->update(['product_status' => 'nonaktif']);
    }
}

// Additional Models needed

class ProductDescription extends Model
{
    protected $table = 'product_descriptions';
    protected $primaryKey = 'id_description';
    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'temperature_id',
        'product_photo',
        'product_description'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id_category');
    }

    public function temperatureType()
    {
        return $this->belongsTo(TemperatureType::class, 'temperature_id', 'id_temperature');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'description_id', 'id_description');
    }
}

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id_category';
    public $timestamps = false;

    protected $fillable = ['category'];

    // Add accessor for category_name since database has 'category' but code expects 'category_name'
    public function getCategoryNameAttribute()
    {
        return $this->category;
    }

    public function productDescriptions()
    {
        return $this->hasMany(ProductDescription::class, 'category_id', 'id_category');
    }
}

class TemperatureType extends Model
{
    protected $table = 'temperature_types';
    protected $primaryKey = 'id_temperature';
    public $timestamps = false;

    protected $fillable = ['temperature'];

    public function productDescriptions()
    {
        return $this->hasMany(ProductDescription::class, 'temperature_id', 'id_temperature');
    }
}