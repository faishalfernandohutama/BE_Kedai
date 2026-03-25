<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = \App\Models\Order::with('items')->latest()->get();

        return response()->json([
            'message' => 'berhasil mengambil riwayat transaksi',
            'data' => $orders
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'customer_name' => 'nullable|string',
            'items' => 'required|array', // Harus mengirim list produk yang dibeli
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // 2. Hitung total harga & simpan Order
        $totalPrice = 0;
        $order = Order::create([
            'customer_name' => $validated['customer_name'],
            'total_price' => 0, // Sementara 0, akan diupdate setelah hitung item
        ]);

        // 3. Simpan item-itemnya
        foreach ($validated['items'] as $item) {
            $product = \App\Models\Product::find($item['product_id']);
            $subtotal = $product->price * $item['quantity'];
            $totalPrice += $subtotal;

            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'unit_price' => $product->price,
            ]);

            // Bonus: Kurangi stok produk secara otomatis
            $product->decrement('stock', $item['quantity']);
        }

        // 4. Update total harga di order
        $order->update(['total_price' => $totalPrice]);

        return response()->json([
            'message' => 'Transaksi berhasil!',
            'data' => $order->load('items')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,cancelled'
        ]);

        $order->update([
            'status' => $validated['status']
        ]);

        return response()->json([
            'message' => 'status pesanan berhasil diperbarui menjad ' . $validated['status'],
            'data' => $order
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
