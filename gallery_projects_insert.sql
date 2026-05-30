-- ============================================================
-- Gallery Projects Insert
-- Project: Agus Tech Solution - Company Profile
-- Description: Add project documentation to gallery
-- ============================================================

-- OnlyFlights - Flight Management System
INSERT INTO gallery (judul, deskripsi, kategori, created_at) VALUES (
    'OnlyFlights - Flight Management System',
    'Sistem manajemen penerbangan komprehensif dengan fitur:
    • Dashboard admin untuk manajemen penerbangan
    • Fitur check-in penumpang online
    • Manajemen jadwal dan kapasitas pesawat
    • Integrasi data bandara dan rute penerbangan
    • Laporan finansial dan rekap perjalanan
    • Interface responsif dan user-friendly
    Teknologi: PHP, MySQL, Bootstrap 5, JavaScript',
    'Web Application',
    NOW()
);

-- Sistem STTP - Police/Court System
INSERT INTO gallery (judul, deskripsi, kategori, created_at) VALUES (
    'Sistem STTP - Tanda Terima Pengaduan',
    'Sistem informasi untuk kepolisian dan direktorat reserse kriminal khusus dengan fitur:
    • Form pengaduan digital dengan identitas pelapor dan korban
    • Penyimpanan data pengaduan terstruktur di database
    • Validasi input dan pemeriksaan data lengkap
    • Interface profesional untuk pegawai kepolisian
    • Sistem otentikasi dan otorisasi akses
    • Template surat resmi pemerintah terintegrasi
    Teknologi: PHP, MySQL, Bootstrap 5, Form Validation',
    'Information System',
    NOW()
);

-- Verifikasi WhatsApp - OTP Verification
INSERT INTO gallery (judul, deskripsi, kategori, created_at) VALUES (
    'Verifikasi WhatsApp - OTP Authentication',
    'Sistem verifikasi autentikasi berbasis OTP WhatsApp dengan fitur:
    • Generate OTP 6 digit untuk verifikasi nomor telepon
    • Pengiriman kode melalui WhatsApp otomatis
    • Countdown timer untuk batas waktu verifikasi (45 detik)
    • Validasi kode OTP sebelum login
    • Redirect otomatis setelah verifikasi berhasil
    • Keamanan berlapis dengan hash password
    • Interface responsif dan intuitif
    Teknologi: PHP, MySQL, Bootstrap 5, WhatsApp API Integration',
    'Security System',
    NOW()
);
