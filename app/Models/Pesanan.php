<?php

namespace App\Models;

use App\Models\Keranjang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesanan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama',
        'nomor_kerja',
        'total_harga',
        'keranjang_id'
    ];

    public function keranjang()
    {
        return $this->belongsTo(Keranjang::class, 'keranjang_id', 'id_keranjang');
    }
}
