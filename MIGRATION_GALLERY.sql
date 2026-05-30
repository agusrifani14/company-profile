-- ============================================================
-- MIGRATION SCRIPT: Gallery Multiple Images
-- ============================================================
-- Script ini mengupdate struktur tabel gallery dan membuat
-- tabel baru gallery_images untuk support multiple gambar per project
-- ============================================================

-- Step 1: Buat tabel gallery_images (jika belum ada)
CREATE TABLE IF NOT EXISTS gallery_images (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  gallery_id  INT NOT NULL,
  gambar      VARCHAR(255) NOT NULL,
  urutan      INT DEFAULT 1,
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (gallery_id) REFERENCES gallery(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Step 2: Jika ada data lama di tabel gallery, migrate ke gallery_images
-- (Uncomment jika ada data lama yang perlu dimigrasikan)
/*
INSERT INTO gallery_images (gallery_id, gambar, urutan)
SELECT id, gambar, 1 FROM gallery WHERE gambar IS NOT NULL AND gambar != '';
*/

-- Step 3: Hapus kolom gambar dari tabel gallery (hanya jika sudah dimigrasikan)
-- ALTER TABLE gallery DROP COLUMN gambar;

-- ============================================================
-- Verifikasi struktur tabel baru
-- ============================================================
-- SELECT * FROM gallery_images LIMIT 10;
-- DESCRIBE gallery_images;
