<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'product_descriptions';
    protected $primaryKey = 'id_description';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'temperature_id',
        'product_photo',
        'product_description',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id_category');
    }

    public function temperature()
    {
        return $this->belongsTo(TemperatureType::class, 'temperature_id', 'id_temperature');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'description_id', 'id_description');
    }
}