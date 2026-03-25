<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
            'description' => 'nullable|string'
        ]);

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
        ]);

        // update data di databse
        $product->update($validated);

        return response()->json([
            'message' => 'Data menu berhasil diperbarui',
            'data' => $product
        ], 200);
    }

    public function destroy(Product $product){
        $product->delete();

        return response()->json([
            'message' => 'Menu berhasil dihapus dari daftar'
        ], 200);
    }
}

