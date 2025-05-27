<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemperatureType extends Model
{
    use HasFactory;

    protected $table = 'temperature_types';
    protected $primaryKey = 'id_temperature';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'temperature',
    ];

    protected function casts(): array
    {
        return [
            'temperature' => 'string',
        ];
    }

    // Relationships
    public function productDescriptions()
    {
        return $this->hasMany(ProductDescription::class, 'temperature_id', 'id_temperature');
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            ProductDescription::class,
            'temperature_id', // Foreign key on product_descriptions table
            'description_id', // Foreign key on products table
            'id_temperature', // Local key on temperature_types table
            'id_description' // Local key on product_descriptions table
        );
    }

    // Scopes
    public function scopeHot($query)
    {
        return $query->where('temperature', 'hot');
    }

    public function scopeCold($query)
    {
        return $query->where('temperature', 'cold');
    }

    // Accessors
    public function getIsHotAttribute()
    {
        return $this->temperature === 'hot';
    }

    public function getIsColdAttribute()
    {
        return $this->temperature === 'cold';
    }

    public function getTemperatureNameAttribute()
    {
        return ucfirst($this->temperature);
    }
}