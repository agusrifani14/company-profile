/**
 * main.js - JavaScript Utama
 * Project: Agus Tech Solution - Company Profile
 * Author : Agus Rifani
 */

document.addEventListener('DOMContentLoaded', function () {

  // ============================================================
  // 1. SCROLL ANIMATIONS (Intersection Observer)
  // ============================================================
  const fadeEls = document.querySelectorAll('.fade-in-up');

  if (fadeEls.length) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry, idx) => {
          if (entry.isIntersecting) {
            // Stagger delay antar elemen
            setTimeout(() => {
              entry.target.classList.add('visible');
            }, idx * 80);
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.1, rootMargin: '0px 0px -40px 0px' }
    );

    fadeEls.forEach(el => observer.observe(el));
  }

  // ============================================================
  // 2. COUNTER ANIMATION (Stats Section)
  // ============================================================
  function animateCounter(el) {
    const target = parseInt(el.dataset.target || el.textContent, 10);
    const duration = 1800;
    const step = 20;
    const increment = target / (duration / step);
    let current = 0;
    const suffix = el.dataset.suffix || '';

    const timer = setInterval(() => {
      current += increment;
      if (current >= target) {
        current = target;
        clearInterval(timer);
      }
      el.textContent = Math.floor(current).toLocaleString('id-ID') + suffix;
    }, step);
  }

  const counterEls = document.querySelectorAll('.counter-number');
  if (counterEls.length) {
    const counterObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            animateCounter(entry.target);
            counterObserver.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.3 }
    );
    counterEls.forEach(el => counterObserver.observe(el));
  }

  // ============================================================
  // 3. AUTO-DISMISS FLASH MESSAGES
  // ============================================================
  const flashMessages = document.querySelectorAll('.flash-message[data-auto-dismiss]');
  flashMessages.forEach(msg => {
    const delay = parseInt(msg.dataset.autoDismiss, 10) || 4000;
    setTimeout(() => {
      msg.style.transition = 'all 0.4s ease';
      msg.style.opacity = '0';
      msg.style.transform = 'translateY(-10px)';
      setTimeout(() => msg.remove(), 400);
    }, delay);
  });

  // ============================================================
  // 4. NAVBAR SCROLL EFFECT
  // ============================================================
  const navbar = document.querySelector('.navbar-main');
  if (navbar) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 50) {
        navbar.style.boxShadow = '0 4px 20px rgba(0,0,0,0.3)';
      } else {
        navbar.style.boxShadow = '';
      }
    }, { passive: true });
  }

  // ============================================================
  // 5. ACTIVE NAV LINK HIGHLIGHT
  // ============================================================
  const currentPath = window.location.pathname;
  document.querySelectorAll('.navbar-nav-main a').forEach(link => {
    if (link.getAttribute('href') && currentPath.includes(link.getAttribute('href').split('/').pop().split('?')[0])) {
      link.closest('.nav-item')?.classList.add('active');
    }
  });

  // ============================================================
  // 6. SIDEBAR ACCORDION (Artikel sub-menu)
  // ============================================================
  const accordionToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');
  accordionToggles.forEach(toggle => {
    const targetId = toggle.dataset.bsTarget;
    const target = document.querySelector(targetId);
    if (target) {
      const chevron = toggle.querySelector('.chevron-icon');
      target.addEventListener('show.bs.collapse', () => {
        if (chevron) chevron.style.transform = 'rotate(180deg)';
      });
      target.addEventListener('hide.bs.collapse', () => {
        if (chevron) chevron.style.transform = 'rotate(0deg)';
      });
    }
  });

  // ============================================================
  // 7. FORM VALIDATION
  // ============================================================
  const forms = document.querySelectorAll('.needs-validation');
  forms.forEach(form => {
    form.addEventListener('submit', function (e) {
      if (!form.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
      }
      form.classList.add('was-validated');
    });
  });

  // ============================================================
  // 8. CONTACT FORM AJAX SUBMIT (optional)
  // ============================================================
  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const btn = this.querySelector('[type="submit"]');
      const originalText = btn.innerHTML;
      btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';
      btn.disabled = true;

      // Simulate submission delay
      setTimeout(() => {
        showAlert('Pesan Anda berhasil dikirim! Tim kami akan segera menghubungi Anda.', 'success', contactForm);
        contactForm.reset();
        btn.innerHTML = originalText;
        btn.disabled = false;
      }, 1500);
    });
  }

  /**
   * Helper: Show alert message
   */
  function showAlert(message, type = 'success', parent = document.body) {
    const icons = { success: 'bi-check-circle-fill', danger: 'bi-x-circle-fill', warning: 'bi-exclamation-triangle-fill', info: 'bi-info-circle-fill' };
    const div = document.createElement('div');
    div.className = `alert alert-${type} d-flex align-items-center gap-2 mt-3`;
    div.innerHTML = `<i class="bi ${icons[type] || icons.info}"></i> ${message}`;
    parent.appendChild(div);
    setTimeout(() => div.remove(), 5000);
  }

  // ============================================================
  // 9. GALLERY LIGHTBOX (simple)
  // ============================================================
  const galleryItems = document.querySelectorAll('.gallery-item[data-src]');
  if (galleryItems.length) {
    // Create modal
    const modal = document.createElement('div');
    modal.id = 'galleryModal';
    modal.style.cssText = `display:none;position:fixed;inset:0;background:rgba(0,0,0,0.9);z-index:9999;align-items:center;justify-content:center;cursor:zoom-out;`;
    modal.innerHTML = `<img id="galleryModalImg" style="max-width:90vw;max-height:90vh;border-radius:12px;box-shadow:0 20px 60px rgba(0,0,0,0.5);" src="" alt="">
      <button onclick="document.getElementById('galleryModal').style.display='none'" 
        style="position:absolute;top:20px;right:24px;background:none;border:none;color:white;font-size:2rem;cursor:pointer;line-height:1;">✕</button>`;
    document.body.appendChild(modal);

    galleryItems.forEach(item => {
      item.addEventListener('click', () => {
        document.getElementById('galleryModalImg').src = item.dataset.src;
        modal.style.display = 'flex';
      });
    });

    modal.addEventListener('click', (e) => {
      if (e.target === modal) modal.style.display = 'none';
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') modal.style.display = 'none';
    });
  }

  // ============================================================
  // 10. SMOOTH SCROLL for anchor links
  // ============================================================
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  // ============================================================
  // 11. TOOLTIP INITIALIZATION (Bootstrap)
  // ============================================================
  const tooltipEls = document.querySelectorAll('[data-bs-toggle="tooltip"]');
  if (tooltipEls.length && typeof bootstrap !== 'undefined') {
    tooltipEls.forEach(el => new bootstrap.Tooltip(el));
  }

  // ============================================================
  // 12. BACK TO TOP BUTTON
  // ============================================================
  const backTopBtn = document.getElementById('backToTop');
  if (backTopBtn) {
    window.addEventListener('scroll', () => {
      backTopBtn.style.opacity = window.scrollY > 300 ? '1' : '0';
      backTopBtn.style.pointerEvents = window.scrollY > 300 ? 'all' : 'none';
    }, { passive: true });

    backTopBtn.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // ============================================================
  // 13. IMAGE LAZY LOADING
  // ============================================================
  const lazyImages = document.querySelectorAll('img[data-src]');
  if (lazyImages.length) {
    const imgObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.src = entry.target.dataset.src;
          entry.target.removeAttribute('data-src');
          imgObserver.unobserve(entry.target);
        }
      });
    });
    lazyImages.forEach(img => imgObserver.observe(img));
  }

    // ============================================================
  // 14. MOBILE MENU + SIDEBAR TOGGLE
  // ============================================================
  const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
  const sidebarEl = document.getElementById('mainSidebar');
  const mainNavbar = document.getElementById('mainNavbar');

  function closeMobilePanels() {
    if (mainNavbar) mainNavbar.classList.remove('mobile-open');
    if (sidebarEl) sidebarEl.classList.remove('sidebar-open');
    document.body.classList.remove('sidebar-overlay');

    if (mobileSidebarToggle) {
      mobileSidebarToggle.setAttribute('aria-expanded', 'false');
    }
  }

  if (mobileSidebarToggle) {
    mobileSidebarToggle.setAttribute('aria-controls', 'mainNavbar mainSidebar');
    mobileSidebarToggle.setAttribute('aria-expanded', 'false');

    mobileSidebarToggle.addEventListener('click', function (e) {
      e.stopPropagation();

      if (mainNavbar) mainNavbar.classList.toggle('mobile-open');
      if (sidebarEl) sidebarEl.classList.toggle('sidebar-open');

      const isOpen =
        (mainNavbar && mainNavbar.classList.contains('mobile-open')) ||
        (sidebarEl && sidebarEl.classList.contains('sidebar-open'));

      document.body.classList.toggle('sidebar-overlay', Boolean(isOpen));
      mobileSidebarToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    document.addEventListener('click', function (e) {
      const clickedInsideNavbar = mainNavbar && mainNavbar.contains(e.target);
      const clickedInsideSidebar = sidebarEl && sidebarEl.contains(e.target);
      const clickedToggle = mobileSidebarToggle.contains(e.target);

      if (!clickedInsideNavbar && !clickedInsideSidebar && !clickedToggle) {
        closeMobilePanels();
      }
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        closeMobilePanels();
      }
    });

    document.querySelectorAll('#mainNavbar a, #mainSidebar a').forEach(function (link) {
      link.addEventListener('click', function () {
        if (window.innerWidth < 992 && !link.classList.contains('dropdown-toggle')) {
          closeMobilePanels();
        }
      });
    });
  }
// ============================================================
// 15. Admin: Confirm Delete
// ============================================================
function confirmDelete(formId) {
  if (confirm('⚠️ Apakah Anda yakin ingin menghapus data ini?\n\nTindakan ini tidak dapat dibatalkan.')) {
    document.getElementById(formId).submit();
  }
  return false;
}

// ============================================================
// 16. Admin: Preview Image Upload
// ============================================================
function previewImage(inputId, previewId) {
  const input = document.getElementById(inputId);
  const preview = document.getElementById(previewId);

  if (input && preview) {
    input.addEventListener('change', function () {
      if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
          preview.src = e.target.result;
          preview.style.display = 'block';
        };
        reader.readAsDataURL(this.files[0]);
      }
    });
  }
}
/* ============================================================
   ADDITIONAL MODERN INTERACTION
   Tempelkan di paling bawah assets/js/main.js
   ============================================================ */

document.addEventListener('DOMContentLoaded', function () {
  // Efek ripple pada tombol
  document.querySelectorAll('.btn').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      const ripple = document.createElement('span');
      const rect = btn.getBoundingClientRect();
      const size = Math.max(rect.width, rect.height);

      ripple.style.width = ripple.style.height = size + 'px';
      ripple.style.left = e.clientX - rect.left - size / 2 + 'px';
      ripple.style.top = e.clientY - rect.top - size / 2 + 'px';
      ripple.className = 'btn-ripple';

      btn.appendChild(ripple);

      setTimeout(function () {
        ripple.remove();
      }, 600);
    });
  });

  // Tambahkan class animasi ke card
  document.querySelectorAll('.card, .stat-card, .product-card, .article-card, .artikel-card, .event-card').forEach(function (el) {
    el.classList.add('fade-in-up');
  });

  // Back to top jika tombol ada
  const backToTop = document.getElementById('backToTop');

  if (backToTop) {
    window.addEventListener('scroll', function () {
      if (window.scrollY > 350) {
        backToTop.style.opacity = '1';
        backToTop.style.pointerEvents = 'auto';
      } else {
        backToTop.style.opacity = '0';
        backToTop.style.pointerEvents = 'none';
      }
    });

    backToTop.addEventListener('click', function () {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }
});
});