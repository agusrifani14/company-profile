# Agus Tech Solution - Company Profile Website

Website Company Profile untuk perusahaan **Agus Tech Solution** yang bergerak di bidang layanan Teknologi Informasi.

## Fitur Utama

- ✅ Frontend dengan tampilan modern menggunakan Bootstrap 5
- ✅ Backend dengan PHP Native dan MySQL
- ✅ System Login/Register dengan password hashing
- ✅ Admin Dashboard untuk mengelola konten
- ✅ CRUD Operations (Create, Read, Update, Delete)
- ✅ Manajemen Produk/Jasa, Artikel, Event, Gallery, Klien
- ✅ Responsive Design (Mobile-friendly)
- ✅ System Autentikasi dengan Session

## Teknologi yang Digunakan

- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5
- **Backend**: PHP 7.4+
- **Database**: MySQL
- **Server**: Apache (XAMPP)

## Struktur Folder

```
company-profile/
├── admin/
│   ├── dashboard.php          # Admin Dashboard
│   ├── produk.php             # Kelola Produk
│   ├── artikel.php            # Kelola Artikel
│   ├── event.php              # Kelola Event
│   ├── gallery.php            # Kelola Gallery
│   ├── klien.php              # Kelola Klien
│   └── users.php              # Kelola Users
├── assets/
│   ├── css/
│   │   └── style.css          # Stylesheet utama
│   ├── js/
│   │   └── main.js            # JavaScript utama
│   ├── img/                   # Folder untuk gambar
│   └── uploads/               # Folder untuk upload file
├── auth/
│   ├── login.php              # Halaman Login
│   ├── register.php           # Halaman Register
│   └── logout.php             # Proses Logout
├── config/
│   └── koneksi.php            # Konfigurasi database
├── includes/
│   ├── header.php             # Header & Navigasi
│   ├── footer.php             # Footer
│   └── sidebar.php            # Sidebar
├── pages/
│   ├── home.php               # Halaman Home
│   ├── profile.php            # Halaman Profile
│   ├── visi_misi.php          # Halaman Visi & Misi
│   ├── produk.php             # Halaman Produk/Jasa
│   ├── kontak.php             # Halaman Kontak
│   ├── artikel.php            # Halaman Artikel
│   ├── event.php              # Halaman Event
│   ├── gallery.php            # Halaman Gallery
│   ├── klien.php              # Halaman Klien
│   └── about.php              # Halaman About
├── index.php                  # File utama
├── database.sql               # File database
└── README.md                  # File ini
```

## Instalasi & Setup

### 1. Persiapan XAMPP

1. Download dan install **XAMPP** dari https://www.apachefriends.org/
2. Jalankan XAMPP Control Panel
3. Aktifkan **Apache** dan **MySQL**

### 2. Clone/Download Project

1. Download project ini
2. Extract ke folder: `C:\xampp\htdocs\company-profile`
   (Pastikan folder bernama `company-profile`)

### 3. Import Database

1. Buka **phpMyAdmin**: http://localhost/phpmyadmin/
2. Buat database baru atau gunakan import:
   - Klik **Import**
   - Pilih file `database.sql` dari project
   - Klik **Go** untuk import
3. Database akan otomatis membuat semua tabel dan data sampel

### 4. Konfigurasi koneksi.php

File `config/koneksi.php` sudah dikonfigurasi dengan default XAMPP:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');  // Kosong (default XAMPP)
define('DB_NAME', 'db_company_profile');
```

Jika Anda menggunakan password MySQL, edit file ini dan ubah `DB_PASS` dengan password Anda.

### 5. Akses Website

1. Buka browser: http://localhost/company-profile/
2. Website siap digunakan!

## Login Admin

**Username**: admin
**Password**: password

Setelah login, Anda akan masuk ke Admin Dashboard di: http://localhost/company-profile/admin/dashboard.php

## Fitur Admin Dashboard

### 1. **Dashboard**
   - Menampilkan statistik jumlah produk, artikel, event, klien, dan users
   - Quick access ke semua management page

### 2. **Manajemen Produk**
   - Tambah produk/jasa baru
   - Edit produk yang ada
   - Hapus produk
   - Set status aktif/nonaktif

### 3. **Manajemen Artikel**
   - Tulis artikel baru
   - Edit artikel
   - Hapus artikel
   - Pilih kategori artikel
   - Set status publish/draft

### 4. **Manajemen Event**
   - Buat event/workshop baru
   - Edit detail event
   - Hapus event
   - Set tanggal dan lokasi event
   - Atur status event (upcoming/selesai)

### 5. **Manajemen Gallery**
   - Upload gambar baru
   - Edit keterangan gambar
   - Hapus gambar
   - Kategorisasi gambar

### 6. **Manajemen Klien**
   - Tambah klien baru
   - Edit data klien
   - Hapus klien
   - Upload logo klien

### 7. **Manajemen Users**
   - Lihat daftar users
   - Ubah role user
   - Aktifkan/nonaktifkan user
   - Hapus user

## Fitur User (Frontend)

### 1. **Home** (/)
   - Hero banner dengan call-to-action
   - Statistik perusahaan
   - Showcase produk terbaru
   - Artikel terbaru
   - Event mendatang
   - CTA section

### 2. **Profile** (/pages/profile.php)
   - Tentang perusahaan
   - Sejarah singkat
   - Nilai-nilai perusahaan
   - Informasi tim

### 3. **Visi & Misi** (/pages/visi_misi.php)
   - Visi perusahaan
   - Misi perusahaan
   - Komitmen perusahaan

### 4. **Produk/Jasa** (/pages/produk.php)
   - Daftar semua produk/jasa
   - Detail produk dengan fitur
   - Harga produk
   - Link konsultasi

### 5. **Kontak** (/pages/kontak.php)
   - Form kontak
   - Informasi alamat, telepon, email
   - Jam kerja
   - Link media sosial

### 6. **Artikel** (/pages/artikel.php)
   - Daftar artikel
   - Filter berdasarkan kategori
   - Baca artikel lengkap
   - Tanggal publikasi

### 7. **Event** (/pages/event.php)
   - Daftar event mendatang
   - Detail event dengan modal
   - Tanggal, waktu, dan lokasi
   - Status event

### 8. **Gallery** (/pages/gallery.php)
   - Galeri foto
   - Kategori foto
   - Deskripsi foto

### 9. **Klien** (/pages/klien.php)
   - Daftar klien
   - Logo klien
   - Link website klien

### 10. **Authentication**
   - **Login** (/auth/login.php) - Login untuk admin
   - **Register** (/auth/register.php) - Register user baru
   - **Logout** (/auth/logout.php) - Logout

## Data Sampel

Database sudah dilengkapi dengan data sampel:
- **Admin**: 1 user (username: admin, password: password)
- **User**: 1 user (username: agus)
- **Produk**: 6 produk/jasa
- **Artikel**: 4 artikel dengan berbagai kategori
- **Event**: 4 event dengan berbagai status
- **Klien**: 6 klien

## Tips Penggunaan

### Menambah Data Baru
1. Login ke admin dashboard
2. Pilih menu yang ingin dikelola (Produk, Artikel, Event, dll)
3. Klik tombol "Tambah" atau "Add New"
4. Isi form dan submit
5. Data akan tersimpan di database

### Upload Gambar
1. Pastikan folder `assets/uploads/` sudah ada dan writable
2. Ukuran file maksimal: 5MB
3. Format yang didukung: JPG, PNG, GIF

### Mengubah Warna/Style
1. Edit file `assets/css/style.css`
2. Ubah variabel CSS di bagian `:root`
3. Refresh browser untuk melihat perubahan

## Troubleshooting

### Error: "Database Connection Error"
- Pastikan MySQL sudah jalan
- Periksa konfigurasi di `config/koneksi.php`
- Pastikan database `db_company_profile` sudah dibuat

### Error: "File tidak ditemukan"
- Pastikan folder project berada di `C:\xampp\htdocs\company-profile\`
- Periksa path di `config/koneksi.php`

### Form tidak bisa di-submit
- Pastikan folder `assets/uploads/` sudah ada
- Ubah permission folder menjadi writable

### Session tidak bekerja
- Pastikan `session_start()` sudah ada di setiap file
- Periksa php.ini setting untuk session

## Keamanan

Untuk production/live server, perhatikan hal berikut:

1. **Ganti password admin default**
   - Login ke admin
   - Edit user profil
   - Ubah password menjadi password yang kuat

2. **Nonaktifkan error display**
   - Edit `config/koneksi.php`
   - Ubah `PDO::ERRMODE_EXCEPTION` ke `PDO::ERRMODE_SILENT`

3. **Gunakan HTTPS**
   - Setup SSL Certificate
   - Redirect HTTP ke HTTPS

4. **Backup database secara rutin**
   - Export database via phpMyAdmin
   - Simpan di lokasi aman

## Support & Contact

Untuk pertanyaan atau bantuan:
- Email: info@agustechsolution.com
- WhatsApp: +62 812 3456 7890
- Website: https://www.agustechsolution.com

## License

Project ini dibuat untuk pembelajaran dan pengembangan website company profile. 
Silakan gunakan dan modifikasi sesuai kebutuhan Anda.

## Credits

Dibuat oleh: **Agus Rifani**
Framework: Bootstrap 5
Database: MySQL
Server: Apache (XAMPP)

---

**Selamat menggunakan Agus Tech Solution Company Profile Website!** 🚀
