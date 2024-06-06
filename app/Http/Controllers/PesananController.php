<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\PesananResource;

class PesananController extends Controller
{
    // Menampilkan semua pesanan
    public function index()
    {
        $pesanans = Pesanan::all();
        return PesananResource::collection($pesanans);
    }

    // Menampilkan detail pesanan berdasarkan ID
    public function show($id)
    {
        $pesanan = Pesanan::with('keranjang.product')->findOrFail($id);
        return PesananResource::collection($pesanan);
    }

    // Menambah pesanan
    public function store(Request $request)
    {
        // Log::info('Request received:', $request->all());

        $request->validate([
            'pesanan' => 'required|array',
            'pesanan.*.nama' => 'required|string|max:255',
            'pesanan.*.total_harga' => 'required|numeric',
            'pesanan.*.nomor_kerja' => 'required|string|max:255',
            'pesanan.*.keranjang_id' => 'required|exists:keranjangs,id_keranjang',
        ]);

        $pesananList = $request->input('pesanan');
        $newPesanans = [];

        foreach ($pesananList as $pesanan) {
            $newPesanan = Pesanan::create([
                'nama' => $pesanan['nama'],
                'nomor_kerja' => $pesanan['nomor_kerja'],
                'total_harga' => $pesanan['total_harga'],
                'keranjang_id' => $pesanan['keranjang_id'],
            ]);
            $newPesanans[] = $newPesanan;
        }

        return PesananResource::collection($newPesanans);
    }


    // Mengupdate pesanan
    // public function update(Request $request, $id)
    // {
    //     $validated = $request->validate([
    //         'nama' => 'sometimes|required|string|max:255',
    //         'nomor_kerja' => 'sometimes|required|string|max:255',
    //         'keranjang_id' => 'sometimes|required|exists:keranjangs,id_keranjang',
    //     ]);

    //     $pesanan = Pesanan::findOrFail($id);
    //     $pesanan->update($validated);

    //     return response()->json($pesanan);
    // }

    // Menghapus pesanan
    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();

        return response()->json(null, 204);
    }
}
