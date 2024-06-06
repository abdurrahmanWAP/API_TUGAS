<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return ProductResource::collection($products);

    }

    public function home()
    {
        $products = Product::latest()->get();
        return ProductResource::collection($products);

    }

    public function home1()
    {
        $products = Product::latest()->paginate(6);
        return ProductResource::collection($products);
    }


    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:products|max:255',
            'nama' => 'required|max:255',
            'harga' => 'required|numeric',
            'kategori' => 'required|max:255',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $product = new Product();
        $product->kode = $request->kode;
        $product->nama = $request->nama;
        $product->harga = $request->harga;
        $product->kategori = $request->kategori;

        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = $image->getClientOriginalName();
            $imagePath = $image->storeAs('images', $imageName, 'public');
            $product->gambar = $imagePath;
        }

        $product->save();

        return new ProductResource($product);
    }


    public function show($id_product)
    {
        $product = Product::findOrFail($id_product);
        return new ProductResource($product);
    }

    public function update(Request $request, $id_product)
    {
        $validator = Validator::make($request->all(), [
            'kode' => 'required|max:255',
            'nama' => 'required|max:255',
            'harga' => 'required|numeric',
            'kategori' => 'required|max:255',
            'gambar' => 'nullable|image|max:2048',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product = Product::find($id_product);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        if ($request->hasFile('gambar')) {
            // Upload image
            $image = $request->file('gambar');
            $imageName = $image->getClientOriginalName();
            $imagePath = $image->storeAs('images', $imageName, 'public');

            // Delete old image
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }

            // Update product with new image
            $product->update([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'harga' => $request->harga,
                'kategori' => $request->kategori,
                'gambar' => $imageName, // Simpan nama file gambar
            ]);
        } else {
            // Update product without image
            $product->update([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'harga' => $request->harga,
                'kategori' => $request->kategori,
            ]);
        }

        return new ProductResource($product);
    }


    public function destroy($id_product)
    {
        $product = Product::findOrFail($id_product);

        // Delete the image if exists
        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();

        return response()->json('Berhasil Delete');
    }

    public function search(Request $request)
    {
        $query = Product::query();

        if ($request->has('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        $products = $query->get();

        return ProductResource::collection($products);
    }


}
