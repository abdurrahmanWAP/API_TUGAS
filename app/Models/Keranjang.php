<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keranjang extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_keranjang';

    protected $fillable = [
        'jumlah_pesanan',
        'keterangan',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id_product');
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'keranjang_id', 'id_keranjang');
    }
}
