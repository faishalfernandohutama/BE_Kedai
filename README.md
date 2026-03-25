# ☕ Kedai Kopi Bola - RESTful API (POS System)

Sebuah sistem *backend* Point of Sales (POS) berbasis RESTful API yang dirancang untuk mengelola operasional Kedai Kopi Bola. API ini menangani manajemen inventaris (menu/stok), pencatatan transaksi kasir dengan pemotongan stok otomatis, hingga pembuatan laporan omzet harian.

Sistem ini dikunci menggunakan **Laravel Sanctum** untuk memastikan hanya kasir terautentikasi yang dapat melakukan transaksi dan mengakses data kedai.

## 🚀 Tech Stack
* **Framework:** Laravel 11
* **Language:** PHP 8.4
* **Database:** MariaDB
* **Authentication:** Laravel Sanctum
* **Testing:** Postman

## ✨ Fitur Utama (Features)

### 🔐 1. Authentication & Security
* Menggunakan **Bearer Token** (Sanctum) untuk mengamankan *endpoint*.
* Login, Register, dan Logout khusus untuk peran Kasir/Admin.

### 📦 2. Product & Inventory Management
* CRUD (Create, Read, Update, Delete) untuk menu minuman dan makanan kedai.
* Pencatatan stok *real-time* untuk setiap item menu.

### 🛒 3. Order & Transaction Logic
* Pembuatan pesanan (*order*) yang mendukung banyak item sekaligus (*multiple order items*).
* **Kalkulasi Otomatis:** Sistem otomatis menghitung total harga (harga produk × jumlah beli).
* **Auto-Deduct Inventory:** Sistem otomatis memotong stok produk ketika pesanan berhasil dibuat.
* Manajemen status pesanan (`pending`, `paid`, `cancelled`).

### 📊 4. Dashboard & Analytics (Reporting)
* *Endpoint* khusus untuk menarik laporan performa harian kedai.
* Menampilkan **Total Pendapatan Hari Ini** (hanya dari pesanan berstatus *paid*).
* Menampilkan **Total Transaksi** yang masuk.
* **Low Stock Alert:** Sistem peringatan dini untuk menu yang stoknya tersisa di bawah 10 porsi.

---

## 🛠️ Cara Instalasi (Local Setup)

1. Clone repository ini:
   ```bash
   git clone https://github.com/username-anda/backend-kedai-bola.git
   ```

2. Masuk ke direktori project:
   ```bash
   cd backend-kedai-bola
   ```

3. Install semua dependencies menggunakan Composer:
   ```bash
   composer install
   ```

4. Salin file environment dan sesuaikan konfigurasi database Anda (MariaDB):
   ```bash
   cp .env.example .env
   ```

5. Buat Application Key:
   ```bash
   php artisan key:generate
   ```

6. Jalankan migrasi database untuk membuat tabel (users, products, orders, order_items, dll):
   ```bash
   php artisan migrate
   ```

7. Jalankan local development server (atau gunakan Laravel Herd):
   ```bash
   php artisan serve
   ```

---

## 📡 Dokumentasi API (Endpoints)

| Method | Endpoint | Description | Auth Required |
| :--- | :--- | :--- | :---: |
| **POST** | `/api/register` | Mendaftarkan akun kasir baru | ❌ |
| **POST** | `/api/login` | Login kasir dan mendapatkan Bearer Token | ❌ |
| **POST** | `/api/logout` | Menghapus token (Logout) | ✅ |
| **GET** | `/api/products` | Menampilkan semua menu dan stok | ✅ |
| **POST** | `/api/products` | Menambah menu baru | ✅ |
| **PUT** | `/api/products/{id}` | Mengedit data/harga/stok menu | ✅ |
| **DELETE** | `/api/products/{id}` | Menghapus menu | ✅ |
| **GET** | `/api/orders` | Menampilkan riwayat transaksi kasir | ✅ |
| **POST** | `/api/orders` | Membuat transaksi baru & potong stok | ✅ |
| **PUT** | `/api/orders/{id}` | Mengubah status transaksi (`paid`/`cancelled`) | ✅ |
| **GET** | `/api/reports` | Menampilkan ringkasan omzet & peringatan stok | ✅ |

---
*Dibuat untuk kebutuhan operasional Kedai Kopi Bola dan portfolio web development.*