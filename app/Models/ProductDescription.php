<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductDescription extends Model
{
    use HasFactory;

    protected $table = 'product_descriptions';
    protected $primaryKey = 'id_description';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'temperature_id',
        'product_photo',
        'product_description',
    ];

    protected function casts(): array
    {
        return [
            'product_photo' => 'string', // Assuming you'll store base64 or file path
        ];
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id_category');
    }

    public function temperatureType()
    {
        return $this->belongsTo(TemperatureType::class, 'temperature_id', 'id_temperature');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'description_id', 'id_description');
    }

    // Scopes
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByTemperature($query, $temperatureId)
    {
        return $query->where('temperature_id', $temperatureId);
    }

    public function scopeHotDrinks($query)
    {
        return $query->whereHas('temperatureType', function ($q) {
            $q->where('temperature', 'hot');
        });
    }

    public function scopeColdDrinks($query)
    {
        return $query->whereHas('temperatureType', function ($q) {
            $q->where('temperature', 'cold');
        });
    }

    // Accessors & Mutators
    public function getPhotoUrlAttribute()
    {
        if ($this->product_photo) {
            // If storing as base64
            if (str_starts_with($this->product_photo, 'data:image')) {
                return $this->product_photo;
            }
            // If storing as file path
            return Storage::url($this->product_photo);
        }
        return null;
    }

    public function getShortDescriptionAttribute()
    {
        return strlen($this->product_description) > 100 
            ? substr($this->product_description, 0, 100) . '...'
            : $this->product_description;
    }
}