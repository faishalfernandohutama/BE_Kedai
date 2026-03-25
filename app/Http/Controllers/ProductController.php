<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Menampilkan semua daftar menu.
     */
    public function index()
    {
        $products = Product::latest()->get(); // Ambil semua data dari yang terbaru

        return response()->json([
            'message' => 'Berhasil mengambil daftar menu',
            'data' => $products
        ], 200);
    }

    /**
     * Menyimpan menu baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang dikirim oleh Vue/Postman
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($request->hasFile('image')){
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // 2. Simpan ke database
        $product = Product::create($validated);

        // 3. Kembalikan respon sukses
        return response()->json([
            'message' => 'Menu baru berhasil ditambahkan',
            'data' => $product
        ], 201);
    }

    public function update(Request $request, Product $product){
        // validasi data yang masuk
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'category' => 'nullable|string',
            'price' => 'sometimes|required|integer',
            'stock' => 'sometimes|required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama dari folder storage (jika sebelumnya sudah punya gambar)
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            // Simpan gambar yang baru
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // update data di databse
        $product->update($validated);

        return response()->json([
            'message' => 'Data menu berhasil diperbarui',
            'data' => $product
        ], 200);
    }

    public function destroy(Product $product){
    if ($product->image){
        Storage::disk('public')->delete($product->image);
    }
    $product->delete();

        return response()->json([
            'message' => 'Menu berhasil dihapus dari daftar'
        ], 200);
    }
}

