<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemperatureType extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'temperature_types';
    protected $primaryKey = 'id_temperature';
    public $incrementing = false;
    protected $keyType = 'string';
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
}