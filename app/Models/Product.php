<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_product';

    protected $fillable = [
        'kode',
        'nama',
        'harga',
        'kategori',
        'gambar'
    ];

    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class, 'product_id', 'id_product');
    }
}
