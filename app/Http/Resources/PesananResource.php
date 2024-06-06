<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PesananResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'total_harga' => $this->total_harga,
            'nama' => $this->nama,
            'nomor_kerja' => $this->nomor_kerja,
            'keranjang_id' => $this->keranjang_id,
        ];
    }
}
