<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'categories';
    protected $primaryKey = 'id_category';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'category',
    ];

    // Relationships
    public function productDescriptions()
    {
        return $this->hasMany(ProductDescription::class, 'category_id', 'id_category');
    }
}