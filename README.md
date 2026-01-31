# H'Mart Cashier System
## Deskripsi
H'Mart Cashier System adalah aplikasi Point of Sale (POS) berbasis web yang dikembangkan menggunakan framework Laravel. Aplikasi ini dirancang khusus untuk supermarket H'Mart dengan fitur lengkap untuk manajemen transaksi, produk, kasir, dan pelaporan keuangan. Sistem ini memungkinkan operasional kasir yang efisien dengan antarmuka yang modern dan user-friendly.

---

## Fitur Utama
### 🛒 Sistem Point of Sale (POS)
- Transaksi Real-time: Proses penjualan cepat dengan antarmuka intuitif
- Multi Metode Pembayaran: Cash, Debit Card, Credit Card, QR Code
- Autocomplete Search: Pencarian produk instan dengan barcode atau nama
- Struk Otomatis: Generate dan cetak struk transaksi
- Kalkulasi Otomatis: Total, kembalian, dan pajak otomatis

### 📦 Manajemen Produk & Inventori
- CRUD Produk Lengkap: Tambah, edit, hapus, dan lihat produk
- Kategori Produk: Organisasi produk berdasarkan kategori
- Monitoring Stok: Alert stok rendah dan habis
- Barcode Support: Input dan pencarian dengan barcode
- Upload Gambar: Foto produk untuk identifikasi visual

### 👥 Manajemen Kasir
- Multi-user System: Support multiple kasir dengan akun terpisah
- Role Management: Admin dan Kasir dengan hak akses berbeda
- Activity Tracking: Monitor aktivitas transaksi per kasir
- Password Security: Enkripsi password dengan bcrypt

### 📊 Dashboard & Analytics
- Real-time Statistics: Pendapatan harian, transaksi, rata-rata belanja
- Visual Charts: Data penjualan dalam format visual
- Quick Overview: Ringkasan performa toko harian
- Stock Alerts: Notifikasi stok kritis

### 📈 Reporting & Export
- Export Excel/CSV: Ekspor data transaksi ke format Excel
- Custom Date Range: Filter laporan berdasarkan rentang tanggal
- Harian & Bulanan: Laporan transaksi harian dan bulanan
- Struk Digital: Archive transaksi dalam format digital

### 🔐 Keamanan & Authentication
- Laravel Breeze: Sistem autentikasi yang aman
- Middleware Protection: Proteksi route dengan middleware
- Session Management: Manajemen sesi yang aman
- Form Validation: Validasi input untuk mencegah error

---

## Teknologi & Versi
- Laravel Framework: 12
- PHP: 8.3.25
- Database: MySQL
- Frontend: Tailwind CSS 3, Font Awesome 6
- JavaScript: jQuery 3.6, Vanilla JS
- Export Tools: CSV/Excel dengan UTF-8 encoding

---

## Requirement Sistem
- PHP >= 8.3
- Composer
- MySQL
- Node.js
- Web Server (Apache/Nginx) atau PHP Built-in Server

---

## Instalasi & Setup

1. Clone repository
```bash
git clone https://github.com/Haloopa/HMartCashierWeb.git
cd HMartCashierWeb
````

2. Install dependensi backend

```bash
composer install
```

3. Install dependency frontend

```bash
npm install
```

4. Konfigurasi environment

```bash
cp .env.example .env
php artisan key:generate
```

5. Konfigurasi database
   Sesuaikan pengaturan database pada file `.env`:

```env
DB_DATABASE=h_mart_db
DB_USERNAME=root
DB_PASSWORD=
```

6. Migrasi database & seeder

```bash
php artisan migrate --seed
```

7. Storage Symbolic link

```bash
php artisan storage:link
```

8. Jalankan asset frontend

```bash
npm run dev
```

9. Jalankan server aplikasi

```bash
php artisan serve
```

10. Akses aplikasi melalui:

```
http://127.0.0.1:8000
```

---

## Akun Default (Seeder)

Akun berikut tersedia secara default melalui database seeder:

| Role        | Email                     | Password |
| ----------- | ------------------------- | -------- |
| Admin       | admin@hmart.com           | password |
| Kasir       | kasir@hmart.com           | password |

> ⚠️ Disarankan untuk segera mengganti password setelah login pertama.

---

## Cara Menggunakan
### 1. Login
- Akses http://127.0.0.1:8000
- Masukkan email dan password
- Pilih "Ingat saya" untuk session yang lebih lama

### 2. Dashboard
- Lihat statistik harian: transaksi, pendapatan, produk
- Akses cepat ke POS dan manajemen produk
- Monitor stok rendah dan habis

### 3. Point of Sale (POS)
- Klik menu "Point of Sale"
- Tambah produk dengan klik atau pencarian
- Atas kuantitas dengan tombol +/-
- Input jumlah bayar, sistem hitung kembalian otomatis
- Klik "Proses Transaksi"

### 4. Manajemen Produk
- Tambah Produk: Isi nama, harga, stok, kategori
- Edit Produk: Update informasi produk
- Hapus Produk: Hapus produk dari sistem

### 5. Manajemen Kasir (Admin Only)
- Tambah Kasir: Buat akun kasir baru
- Edit Kasir: Update informasi kasir
- Hapus Kasir: Nonaktifkan akun kasir
- Reset Password: Reset password kasir

### 6. Export Data
- Hari Ini: Export semua transaksi hari ini
- Bulan Ini: Export transaksi bulan berjalan
- Custom Range: Pilih rentang tanggal spesifik

