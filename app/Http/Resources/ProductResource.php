<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_product' => $this->id_product,
            'kode' => $this->kode,
            'nama' => $this->nama,
            'harga' => $this->harga,
            'kategori' => $this->kategori,
            'gambar' => $this->gambar ? url('storage/' . $this->gambar) : null,
        ];
    }
}
