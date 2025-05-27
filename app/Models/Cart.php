<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $table = '';
    protected $primaryKey = '';
    protected $keyType = '';
    public $incrementing = '';
    public $timestamps = '';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // Tambahkan atribut lain yang dapat diisi dan diperlukan
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // Tambahkan atribut yang ingin disembunyikan
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // Tambahkan casting yang diperlukan
        ];
    }
}
