-- ============================================================
-- DATABASE: db_company_profile
-- Project  : Agus Tech Solution - Company Profile Website
-- Author   : Agus Rifani
-- Version  : 1.0
-- ============================================================

CREATE DATABASE IF NOT EXISTS db_company_profile
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE db_company_profile;

-- ============================================================
-- TABLE: users (admin & member)
-- ============================================================
CREATE TABLE IF NOT EXISTS users (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  nama        VARCHAR(100) NOT NULL,
  username    VARCHAR(50)  NOT NULL UNIQUE,
  email       VARCHAR(100) NOT NULL UNIQUE,
  password    VARCHAR(255) NOT NULL,
  role        ENUM('admin','user') NOT NULL DEFAULT 'user',
  status      ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  foto        VARCHAR(255) DEFAULT NULL,
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- TABLE: artikel
-- ============================================================
CREATE TABLE IF NOT EXISTS artikel (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  judul       VARCHAR(255) NOT NULL,
  slug        VARCHAR(255) NOT NULL UNIQUE,
  kategori    ENUM('Konsep Teknologi Informasi','Web Development','Sistem Informasi','Keamanan Website') NOT NULL DEFAULT 'Web Development',
  konten      LONGTEXT NOT NULL,
  gambar      VARCHAR(255) DEFAULT NULL,
  penulis     VARCHAR(100) DEFAULT 'Admin',
  status      ENUM('publish','draft') NOT NULL DEFAULT 'publish',
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- TABLE: event
-- ============================================================
CREATE TABLE IF NOT EXISTS event (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  judul       VARCHAR(255) NOT NULL,
  deskripsi   TEXT NOT NULL,
  tanggal     DATE NOT NULL,
  lokasi      VARCHAR(255) NOT NULL,
  gambar      VARCHAR(255) DEFAULT NULL,
  status      ENUM('upcoming','ongoing','selesai') NOT NULL DEFAULT 'upcoming',
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- TABLE: gallery (Project/Dokumentasi)
-- ============================================================
CREATE TABLE IF NOT EXISTS gallery (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  judul       VARCHAR(255) NOT NULL,
  deskripsi   TEXT DEFAULT NULL,
  kategori    VARCHAR(100) DEFAULT 'Umum',
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- TABLE: gallery_images (Multiple gambar per project)
-- ============================================================
CREATE TABLE IF NOT EXISTS gallery_images (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  gallery_id  INT NOT NULL,
  gambar      VARCHAR(255) NOT NULL,
  urutan      INT DEFAULT 1,
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (gallery_id) REFERENCES gallery(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- TABLE: klien
-- ============================================================
CREATE TABLE IF NOT EXISTS klien (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  nama        VARCHAR(255) NOT NULL,
  logo        VARCHAR(255) DEFAULT NULL,
  website     VARCHAR(255) DEFAULT NULL,
  deskripsi   TEXT DEFAULT NULL,
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- TABLE: produk (layanan/jasa)
-- ============================================================
CREATE TABLE IF NOT EXISTS produk (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  nama        VARCHAR(255) NOT NULL,
  kategori    VARCHAR(100) DEFAULT 'Layanan IT',
  deskripsi   TEXT NOT NULL,
  harga       VARCHAR(100) DEFAULT 'Hubungi Kami',
  gambar      VARCHAR(255) DEFAULT NULL,
  icon        VARCHAR(100) DEFAULT 'bi-gear',
  fitur       TEXT DEFAULT NULL,
  status      ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- TABLE: upload_file
-- ============================================================
CREATE TABLE IF NOT EXISTS upload_file (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  nama_file   VARCHAR(255) NOT NULL,
  path_file   VARCHAR(255) NOT NULL,
  tipe        VARCHAR(50)  DEFAULT NULL,
  ukuran      INT          DEFAULT NULL,
  uploader    VARCHAR(100) DEFAULT 'Admin',
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- DATA SEED: Admin default
-- password: admin123 (hashed with PASSWORD_DEFAULT)
-- ============================================================
INSERT INTO users (nama, username, email, password, role) VALUES
('Administrator', 'admin', 'admin@agustechsolution.com',
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Agus Rifani', 'agus', 'agus@agustechsolution.com',
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

-- Note: Hash di atas adalah hash dari 'password' (Laravel default)
-- Jalankan script PHP berikut untuk mendapatkan hash 'admin123':
-- echo password_hash('admin123', PASSWORD_DEFAULT);
-- Kemudian UPDATE users SET password = '[hash]' WHERE username = 'admin';

-- ============================================================
-- DATA SEED: Produk/Jasa
-- ============================================================
INSERT INTO produk (nama, kategori, deskripsi, harga, icon, fitur) VALUES
('Pembuatan Website', 'Web Development',
 'Kami membangun website profesional, responsif, dan modern sesuai kebutuhan bisnis Anda. Dari landing page sederhana hingga portal web enterprise.',
 'Mulai Rp 1.500.000', 'bi-globe',
 'Desain Responsif,SEO Friendly,Panel Admin,Domain & Hosting,SSL Certificate'),
('Aplikasi Sederhana', 'Software Development',
 'Pengembangan aplikasi berbasis web maupun desktop untuk kebutuhan usaha kecil menengah dengan fitur yang disesuaikan.',
 'Mulai Rp 2.000.000', 'bi-app-indicator',
 'Custom Fitur,Laporan Otomatis,Multi User,Backup Data,Support 3 Bulan'),
('Sistem Informasi', 'Sistem Informasi',
 'Bangun sistem informasi manajemen yang terintegrasi untuk optimalkan proses bisnis perusahaan Anda secara digital.',
 'Mulai Rp 3.500.000', 'bi-diagram-3',
 'Manajemen Data,Multi Modul,Role & Permission,Laporan PDF/Excel,API Integration'),
('Konsultasi IT', 'Konsultasi',
 'Dapatkan saran teknologi terbaik dari tim ahli kami. Kami membantu Anda memilih solusi IT yang tepat dan efisien.',
 'Rp 200.000/jam', 'bi-chat-dots',
 'Analisis Kebutuhan,Rekomendasi Solusi,Perencanaan Teknis,Dokumentasi,Follow Up'),
('Keamanan Website', 'Cyber Security',
 'Audit keamanan website, perlindungan dari serangan siber, dan implementasi protokol keamanan standar industri.',
 'Mulai Rp 800.000', 'bi-shield-check',
 'Security Audit,Penetration Test,SSL Setup,Firewall Config,Monitoring 24/7'),
('Pelatihan Digital', 'Training',
 'Program pelatihan teknologi digital untuk individu dan korporasi. Tingkatkan kompetensi SDM di era transformasi digital.',
 'Mulai Rp 500.000/sesi', 'bi-mortarboard',
 'Modul Terstruktur,Sertifikat,Praktek Langsung,Materi Digital,Trainer Bersertifikat');

-- ============================================================
-- DATA SEED: Artikel
-- ============================================================
INSERT INTO artikel (judul, slug, kategori, konten, penulis, status) VALUES
('Apa Itu Teknologi Informasi dan Mengapa Penting?',
 'apa-itu-teknologi-informasi',
 'Konsep Teknologi Informasi',
 '<p>Teknologi Informasi (TI) adalah penggunaan komputer, perangkat lunak, jaringan, dan infrastruktur terkait untuk menciptakan, memproses, menyimpan, dan mendistribusikan semua bentuk data elektronik.</p><p>Di era digital saat ini, TI menjadi tulang punggung hampir semua sektor industri, mulai dari perbankan, kesehatan, pendidikan, hingga pemerintahan. Perusahaan yang mampu memanfaatkan teknologi informasi dengan baik akan memiliki keunggulan kompetitif yang signifikan.</p><h4>Manfaat Utama Teknologi Informasi</h4><ul><li>Meningkatkan efisiensi operasional</li><li>Mempercepat pengambilan keputusan berbasis data</li><li>Memperluas jangkauan pasar</li><li>Mengotomatisasi proses bisnis yang berulang</li><li>Meningkatkan kepuasan pelanggan</li></ul>',
 'Agus Rifani', 'publish'),
('Panduan Lengkap Web Development untuk Pemula',
 'panduan-web-development-pemula',
 'Web Development',
 '<p>Web development adalah proses membangun dan memelihara website. Ini mencakup segala hal mulai dari membuat halaman web sederhana hingga aplikasi web yang kompleks, layanan jejaring sosial, dan bisnis online.</p><p>Untuk menjadi web developer yang handal, Anda perlu menguasai beberapa teknologi fundamental.</p><h4>Teknologi Dasar Web Development</h4><ul><li><strong>HTML</strong> - Struktur halaman web</li><li><strong>CSS</strong> - Tampilan dan gaya</li><li><strong>JavaScript</strong> - Interaktivitas</li><li><strong>PHP/Python/Node.js</strong> - Backend server</li><li><strong>MySQL/PostgreSQL</strong> - Database</li></ul>',
 'Tim Agus Tech', 'publish'),
('Membangun Sistem Informasi yang Efektif',
 'membangun-sistem-informasi-efektif',
 'Sistem Informasi',
 '<p>Sistem Informasi (SI) adalah kombinasi teknologi informasi dan aktivitas manusia yang menggunakan teknologi tersebut untuk mendukung operasi dan manajemen.</p><p>Sistem informasi yang efektif dapat membantu organisasi dalam mencapai tujuan bisnis mereka dengan lebih efisien.</p><h4>Komponen Sistem Informasi</h4><ul><li>Hardware (Perangkat Keras)</li><li>Software (Perangkat Lunak)</li><li>Data (Basis Data)</li><li>Prosedur dan Kebijakan</li><li>Sumber Daya Manusia</li></ul>',
 'Agus Rifani', 'publish'),
('Pentingnya Keamanan Website di Era Digital',
 'pentingnya-keamanan-website',
 'Keamanan Website',
 '<p>Keamanan website adalah praktik melindungi website dari ancaman siber yang dapat membahayakan data, reputasi, dan kelangsungan bisnis Anda.</p><p>Serangan siber semakin canggih dan sering. Setiap hari, ribuan website menjadi korban hacking, malware, dan berbagai ancaman digital lainnya.</p><h4>Ancaman Keamanan Website yang Umum</h4><ul><li>SQL Injection</li><li>Cross-Site Scripting (XSS)</li><li>DDoS Attack</li><li>Brute Force Login</li><li>Malware & Ransomware</li></ul><h4>Cara Melindungi Website Anda</h4><ul><li>Gunakan HTTPS/SSL Certificate</li><li>Update CMS dan plugin secara rutin</li><li>Gunakan password yang kuat</li><li>Backup data secara berkala</li><li>Pasang firewall aplikasi web (WAF)</li></ul>',
 'Tim Security', 'publish');

-- ============================================================
-- DATA SEED: Event
-- ============================================================
INSERT INTO event (judul, deskripsi, tanggal, lokasi, status) VALUES
('Workshop Web Development untuk UMKM',
 'Workshop intensif selama 2 hari tentang pembuatan website profesional khusus untuk pelaku UMKM. Peserta akan diajarkan dari dasar hingga bisa membuat website sendiri.',
 '2026-06-15', 'Gedung Tekno Center, Bandung', 'upcoming'),
('Seminar Keamanan Siber 2026',
 'Seminar nasional tentang ancaman siber terkini dan strategi perlindungan digital untuk perusahaan. Menghadirkan praktisi dan pakar keamanan siber.',
 '2026-07-20', 'Hotel Grand Pasundan, Bandung', 'upcoming'),
('Pelatihan Digital Marketing & IT',
 'Program pelatihan intensif gabungan digital marketing dan penguasaan tools IT modern. Cocok untuk pebisnis dan profesional muda.',
 '2026-05-10', 'Agus Tech Solution Office', 'selesai'),
('Launch Produk Sistem Informasi v2.0',
 'Peluncuran versi terbaru Sistem Informasi Agus Tech Solution dengan fitur-fitur canggih terbaru. Terbuka untuk umum.',
 '2026-08-05', 'Graha Teknika, Bandung', 'upcoming');

-- ============================================================
-- DATA SEED: Klien
-- ============================================================
INSERT INTO klien (nama, website, deskripsi) VALUES
('PT. Maju Bersama Digital', 'https://majubersama.co.id', 'Perusahaan distribusi nasional yang menggunakan sistem informasi gudang dari Agus Tech Solution'),
('CV. Berkah Usaha Mandiri', NULL, 'UKM makanan yang kami bantu memiliki website profil bisnis modern'),
('Dinas Pendidikan Kota Bandung', 'https://disdik.bandung.go.id', 'Instansi pemerintah yang menggunakan aplikasi manajemen sekolah'),
('SMA Negeri 1 Unggulan', NULL, 'Sekolah menengah atas yang kami bantu digitalisasi administrasi sekolah'),
('RSUD Sehat Sejahtera', NULL, 'Rumah sakit daerah yang menggunakan sistem informasi manajemen rumah sakit'),
('PT. Kreatif Inovasi Nusantara', 'https://kreatifin.com', 'Startup kreatif yang menggunakan jasa pengembangan aplikasi mobile-web kami');
