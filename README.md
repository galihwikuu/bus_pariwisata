# 🦅 PT Janitra Surya Trans — Website Bus Pariwisata
**Tema: Merah & Putih · Berbasis Proposal Asli PT Janitra Surya Trans**

---

## 📁 Struktur Folder

```
bus_pariwisata/
├── index.php               → Halaman Beranda
├── tentang.php             → Halaman Tentang Kami
├── detail-bus.php          → Halaman Detail Bus (Jetbus 3++ SHD)
├── galeri.php              → Halaman Galeri Foto
├── booking.php             → Halaman Form Booking
├── database.sql            → File SQL database
│
├── config/
│   └── koneksi.php         → Konfigurasi database MySQL
│
├── includes/
│   ├── header.php          → Navbar & head HTML
│   └── footer.php          → Footer & WhatsApp button
│
├── assets/
│   ├── css/
│   │   └── style.css       → CSS utama (tema merah-putih)
│   └── js/
│       └── main.js         → JavaScript utama
│
└── admin/
    ├── login.php           → Halaman Login Admin
    ├── dashboard.php       → Dashboard Admin
    ├── data-booking.php    → Kelola Data Booking (CRUD)
    ├── logout.php          → Proses Logout
    └── includes/
        └── sidebar.php     → Sidebar Admin
```

---

## 🚀 Cara Menjalankan di XAMPP

### 1. Salin Folder Project
Salin folder `bus_pariwisata` ke:
```
C:\xampp\htdocs\bus_pariwisata\
```

### 2. Import Database
1. Buka browser → http://localhost/phpmyadmin
2. Klik **New** → buat database bernama `janitra_surya`
3. Klik tab **Import** → pilih file `database.sql`
4. Klik **Go**

### 3. Sesuaikan Konfigurasi Database
Buka file `config/koneksi.php` dan sesuaikan:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');      // username MySQL Anda
define('DB_PASS', '');          // password MySQL (kosong jika default XAMPP)
define('DB_NAME', 'janitra_surya');
```

### 4. Jalankan Website
Buka browser → http://localhost/bus_pariwisata/

---

## 🔐 Login Admin
- URL: http://localhost/bus_pariwisata/admin/login.php
- Username: `admin`
- Password: `password`

---

## 🎨 Spesifikasi Tema
- **Warna Utama:** Merah Tua (#990000), Merah (#CC0000)
- **Warna Aksen:** Putih (#FFFFFF)
- **Font Judul:** Montserrat (Bold/Black)
- **Font Body:** Open Sans
- Desain terinspirasi langsung dari **Proposal Resmi PT Janitra Surya Trans**

---

## 🚌 Detail Bus (Sesuai Proposal)
- **Jenis:** Jetbus 3++ SHD Air Suspension
- **Mesin:** Hino RKJ8 (Air Suspension System)
- **Seat:** 2-2 · 50 Kursi Reclining
- **Fasilitas:** AC, Bantal & Selimut, Dispenser + Welcome Drink,
  Android TV, Mic Wireless, USB Charger, Lampu Baca, Tirai,
  Bagasi Luas, APAR & Palu Kaca (K3), Air Suspension

---

## 📞 Kontak (Sesuai Proposal)
- **Office & Pool:** Jl. Boro Terong Dowo No.29, Tirtomoyo Pakis, Kab. Malang
- **HP/WA:** 0812-3362-4797
- **Website:** www.sewabusmalang.com

---

## ✅ Fitur Lengkap
- [x] Halaman Home dengan hero section
- [x] Halaman Tentang Kami (Profil Singkat sesuai proposal)
- [x] Halaman Detail Bus (Jetbus 3++ SHD, semua fasilitas dari proposal)
- [x] Halaman Galeri dengan filter kategori & lightbox
- [x] Halaman Booking dengan validasi server & client side
- [x] Login Admin dengan session PHP
- [x] Dashboard Admin (statistik booking)
- [x] Kelola Booking (lihat, ubah status, hapus, modal detail)
- [x] Database MySQL (tabel admin + booking)
- [x] Tombol WhatsApp mengambang
- [x] Responsive mobile & desktop
- [x] Animasi scroll fade-in
- [x] Counter angka animasi
- [x] Lightbox galeri foto
- [x] Navbar sticky dengan top bar info kontak
- [x] Syarat & ketentuan sewa (sesuai proposal hal.6)
- [x] Harga sewa (sesuai contoh penawaran di proposal)
