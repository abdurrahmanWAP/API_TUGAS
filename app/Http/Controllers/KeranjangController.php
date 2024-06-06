<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjangs = Keranjang::with('product')->get();
        return response()->json($keranjangs);
    }

    public function show($id_keranjang)
    {
        $keranjang = Keranjang::with('product')->findOrFail($id_keranjang);
        return response()->json($keranjang);
    }

    // Menambah item ke keranjang
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id_product',
            'jumlah_pesanan' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $keranjang = Keranjang::create($validated);

        return response()->json($keranjang, 201);
    }

    // Mengupdate item di keranjang
    public function update(Request $request, $id_keranjang)
    {
        $validated = $request->validate([
            'jumlah_pesanan' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $keranjang = Keranjang::findOrFail($id_keranjang);
        $keranjang->update($validated);

        return response()->json($keranjang);
    }

    // Menghapus item dari keranjang
    public function destroy($id_keranjang)
    {
        $keranjang = Keranjang::findOrFail($id_keranjang);
        $keranjang->delete();

        return response()->json(null, 204);
    }
}
