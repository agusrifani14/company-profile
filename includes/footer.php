<?php
/**
 * footer.php - Footer Website
 * Project: Agus Tech Solution - Company Profile
 * Author : Agus Rifani
 */
$base_url = (defined('APP_URL')) ? APP_URL : 'http://localhost/company-profile';
?>

<!-- Back to Top Button -->
<button id="backToTop" style="
  position:fixed;bottom:28px;right:28px;
  width:44px;height:44px;border-radius:50%;
  background:linear-gradient(135deg,#1a56db,#06b6d4);
  border:none;color:white;font-size:1.1rem;
  cursor:pointer;opacity:0;pointer-events:none;
  transition:all 0.3s;z-index:999;
  box-shadow:0 4px 15px rgba(26,86,219,0.4);
  display:flex;align-items:center;justify-content:center;"
  title="Kembali ke atas">
  <i class="bi bi-arrow-up"></i>
</button>

<!-- ============================================================
     FOOTER UTAMA
     ============================================================ -->
<footer class="footer-main mt-5">
  <div class="container">
    <div class="row g-5">

      <!-- Kolom 1: Brand & Deskripsi -->
      <div class="col-lg-4 col-md-6">
        <div class="footer-brand">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div style="width:48px;height:48px;background:linear-gradient(135deg,#1a56db,#06b6d4);border-radius:12px;display:flex;align-items:center;justify-content:center;color:white;font-weight:900;font-size:1.1rem;font-family:'Poppins',sans-serif;">AT</div>
            <div>
              <div class="footer-title">Agus Tech Solution</div>
              <div class="footer-tagline">IT Services &amp; Digital Solutions</div>
            </div>
          </div>
          <p style="font-size:0.875rem;line-height:1.8;color:rgba(255,255,255,0.6);">
            Kami hadir sebagai mitra teknologi terpercaya untuk membantu bisnis Anda bertransformasi secara digital dengan solusi IT yang tepat, efisien, dan inovatif.
          </p>
          <!-- Sosial Media -->
          <div class="social-links mt-3">
            <a href="#" class="social-link" title="Instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" class="social-link" title="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="social-link" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
            <a href="#" class="social-link" title="YouTube"><i class="bi bi-youtube"></i></a>
            <a href="#" class="social-link" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
            <a href="#" class="social-link" title="GitHub"><i class="bi bi-github"></i></a>
          </div>
        </div>
      </div>

      <!-- Kolom 2: Menu Navigasi -->
      <div class="col-lg-2 col-md-3 col-6">
        <h6 class="footer-heading">Navigasi</h6>
        <ul class="footer-links">
          <li><a href="<?= $base_url ?>/index.php"><i class="bi bi-chevron-right"></i> Home</a></li>
          <li><a href="<?= $base_url ?>/pages/profile.php"><i class="bi bi-chevron-right"></i> Profile</a></li>
          <li><a href="<?= $base_url ?>/pages/visi_misi.php"><i class="bi bi-chevron-right"></i> Visi &amp; Misi</a></li>
          <li><a href="<?= $base_url ?>/pages/produk.php"><i class="bi bi-chevron-right"></i> Produk/Jasa</a></li>
          <li><a href="<?= $base_url ?>/pages/about.php"><i class="bi bi-chevron-right"></i> About Us</a></li>
          <li><a href="<?= $base_url ?>/pages/kontak.php"><i class="bi bi-chevron-right"></i> Kontak</a></li>
        </ul>
      </div>

      <!-- Kolom 3: Layanan -->
      <div class="col-lg-3 col-md-3 col-6">
        <h6 class="footer-heading">Layanan Kami</h6>
        <ul class="footer-links">
          <li><a href="<?= $base_url ?>/pages/produk.php"><i class="bi bi-globe"></i> Pembuatan Website</a></li>
          <li><a href="<?= $base_url ?>/pages/produk.php"><i class="bi bi-app-indicator"></i> Aplikasi Sederhana</a></li>
          <li><a href="<?= $base_url ?>/pages/produk.php"><i class="bi bi-diagram-3"></i> Sistem Informasi</a></li>
          <li><a href="<?= $base_url ?>/pages/produk.php"><i class="bi bi-chat-dots"></i> Konsultasi IT</a></li>
          <li><a href="<?= $base_url ?>/pages/produk.php"><i class="bi bi-shield-check"></i> Keamanan Website</a></li>
          <li><a href="<?= $base_url ?>/pages/produk.php"><i class="bi bi-mortarboard"></i> Pelatihan Digital</a></li>
        </ul>
      </div>

      <!-- Kolom 4: Kontak -->
      <div class="col-lg-3 col-md-6">
        <h6 class="footer-heading">Hubungi Kami</h6>
        <ul class="footer-links">
          <li>
            <a href="#">
              <i class="bi bi-geo-alt-fill" style="color:#3b82f6;"></i>
              Jl. Demang IV No. 4023, Palembang, Sumatera Selatan 40123
            </a>
          </li>
          <li>
            <a href="tel:+6281234567890">
              <i class="bi bi-telephone-fill" style="color:#3b82f6;"></i>
              +62 812-3456-7890
            </a>
          </li>
          <li>
            <a href="mailto:info@agustechsolution.com">
              <i class="bi bi-envelope-fill" style="color:#3b82f6;"></i>
              info@agustechsolution.com
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-clock-fill" style="color:#3b82f6;"></i>
              Senin–Jumat, 08:00–17:00 WIB
            </a>
          </li>
        </ul>
        <!-- WhatsApp CTA -->
        <a href="https://wa.me/6281234567890?text=Halo Agus Tech Solution, saya ingin berkonsultasi."
           target="_blank"
           class="btn btn-sm mt-3 d-inline-flex align-items-center gap-2"
           style="background:#25D366;color:white;border-radius:8px;padding:8px 16px;font-size:0.82rem;font-weight:600;text-decoration:none;transition:all 0.3s;">
          <i class="bi bi-whatsapp"></i> Chat WhatsApp
        </a>
      </div>

    </div><!-- end row -->
  </div><!-- end container -->

  <!-- Footer Bottom -->
  <div class="footer-bottom">
    <div class="container">
      <p class="mb-0">
        &copy; <?= date('Y') ?> <strong>Agus Tech Solution</strong>. All rights reserved. &nbsp;|&nbsp;
        Design by: <strong>Agus Rifani</strong>
      </p>
    </div>
  </div>

</footer>
<!-- END FOOTER -->

<!-- Bootstrap 5 JS Bundle CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JavaScript -->
<script src="<?= $base_url ?>/assets/js/main.js"></script>
<!-- Form Handler & Button Interactions -->
<script src="<?= $base_url ?>/assets/js/form-handler.js"></script>

</body>
</html>
