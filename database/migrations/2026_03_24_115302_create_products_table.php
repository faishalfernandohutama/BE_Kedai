<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama menu (misal: Es Kopi Susu Bola)
            $table->string('category')->nullable(); // Kategori (Kopi, Non-Kopi, Snack)
            $table->text('description')->nullable(); // Deskripsi singkat
            $table->integer('price'); // Harga
            $table->integer('stock')->default(0); // Sisa stok
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
