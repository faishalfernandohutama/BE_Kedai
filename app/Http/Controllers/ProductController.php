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

    // ... (Fungsi show, update, dan destroy biarkan kosong dulu untuk sekarang)
}