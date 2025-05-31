<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'id_category';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'category',
    ];

    // Relationships
    public function productDescriptions()
    {
        return $this->hasMany(ProductDescription::class, 'category_id', 'id_category');
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            ProductDescription::class,
            'category_id', // Foreign key on product_descriptions table
            'description_id', // Foreign key on products table
            'id_category', // Local key on categories table
            'id_description' // Local key on product_descriptions table
        );
    }

    // Scopes
    public function scopeWithProducts($query)
    {
        return $query->whereHas('products');
    }

    // Accessors
    public function getCategoryNameAttribute()
    {
        return ucfirst($this->category);
    }
}