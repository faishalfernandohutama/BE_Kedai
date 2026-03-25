<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // 1. Izinkan kolom ini diisi data
    protected $fillable = [
        'customer_name',
        'total_price',
        'status'
    ];

    // 2. Fungsi items() HARUS berada di dalam kurung kurawal class Order ini
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}