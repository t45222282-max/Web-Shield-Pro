/**
 * assets/js/shield/shield-ui.js
 * Shield UI Engine — JavaScript Controller
 * Reference: docs/07-implementation-roadmap.md § 3.4
 */

const ShieldUI = {
  init() {
    this.initSidebarToggle();
    this.initThemeToggle();
    this.initTopbarScroll();
    this.initToasts();
    this.initLucide();
    this.initPalette();
    this.initIPHoverCards();
    this.initTreeviews();
    this.initTableSkeletons();
  },

  /* ── Table Skeletons ── */
  initTableSkeletons() {
    const tableWrappers = document.querySelectorAll('.shield-table-wrapper');
    if (tableWrappers.length === 0) return;

    tableWrappers.forEach(wrapper => {
      // Create skeleton overlay HTML
      const skeletonHTML = `
        <div class="shield-table-skeleton">
          <div class="shield-table-skeleton-row">
            <div class="shield-table-skeleton-cell" style="flex: 1;"></div>
            <div class="shield-table-skeleton-cell" style="flex: 2;"></div>
            <div class="shield-table-skeleton-cell" style="flex: 1;"></div>
            <div class="shield-table-skeleton-cell" style="flex: 1;"></div>
          </div>
          <div class="shield-table-skeleton-row">
            <div class="shield-table-skeleton-cell" style="flex: 1;"></div>
            <div class="shield-table-skeleton-cell" style="flex: 2;"></div>
            <div class="shield-table-skeleton-cell" style="flex: 1;"></div>
            <div class="shield-table-skeleton-cell" style="flex: 1;"></div>
          </div>
          <div class="shield-table-skeleton-row">
            <div class="shield-table-skeleton-cell" style="flex: 1;"></div>
            <div class="shield-table-skeleton-cell" style="flex: 2;"></div>
            <div class="shield-table-skeleton-cell" style="flex: 1;"></div>
            <div class="shield-table-skeleton-cell" style="flex: 1;"></div>
          </div>
        </div>
      `;
      wrapper.insertAdjacentHTML('beforeend', skeletonHTML);
      
      // Add loading state initially if DataTables is present
      const table = wrapper.querySelector('table');
      if (table && table.id && window.jQuery) {
        wrapper.classList.add('is-loading');
        
        // Listen for DataTables init event
        window.jQuery('#' + table.id).on('init.dt', function() {
          setTimeout(() => {
            wrapper.classList.remove('is-loading');
          }, 300); // slight delay for smooth transition
        });
        
        // Listen for draw event (e.g. pagination) to show skeleton briefly
        window.jQuery('#' + table.id).on('preDraw.dt', function() {
          wrapper.classList.add('is-loading');
        }).on('draw.dt', function() {
          setTimeout(() => {
            wrapper.classList.remove('is-loading');
          }, 300);
        });
      }
    });
  },

  /* ── Treeview Menus ── */
  initTreeviews() {
    const treeviewLinks = document.querySelectorAll('.shield-nav__item.shield-nav__has-treeview > a');
    
    treeviewLinks.forEach(link => {
      link.addEventListener('click', (e) => {
        e.preventDefault();
        const parent = link.parentElement;
        const treeview = parent.querySelector('.shield-nav__treeview');
        
        if (!treeview) return;
        
        // Toggle open state
        const isOpen = treeview.classList.contains('is-open');
        
        // Close siblings if you want accordion style (optional, let's keep it simple for now)
        // document.querySelectorAll('.shield-nav__treeview.is-open').forEach(tv => {
        //   if (tv !== treeview) {
        //     tv.classList.remove('is-open');
        //     tv.parentElement.classList.remove('is-expanded');
        //   }
        // });

        if (isOpen) {
          treeview.classList.remove('is-open');
          parent.classList.remove('is-expanded');
        } else {
          treeview.classList.add('is-open');
          parent.classList.add('is-expanded');
        }
      });
    });

    // Auto-open treeviews if a child is active
    document.querySelectorAll('.shield-nav__treeview .shield-nav__link.is-active').forEach(activeLink => {
      const treeview = activeLink.closest('.shield-nav__treeview');
      const parent = activeLink.closest('.shield-nav__item.shield-nav__has-treeview');
      if (treeview && parent) {
        treeview.classList.add('is-open');
        parent.classList.add('is-expanded');
        
        // Also ensure parent link looks somewhat active or highlighted
        const parentLink = parent.querySelector('> a');
        if (parentLink) {
          parentLink.classList.add('is-active');
        }
      }
    });
  },

  /* ── IP Hover Cards (Advanced Tooltips) ── */
  initIPHoverCards() {
    // Regex for IP detection
    const ipRegex = /\b(?:[0-9]{1,3}\.){3}[0-9]{1,3}\b/;
    
    // Event delegation on the body to support DataTables pagination/redraws
    document.body.addEventListener('mouseover', (e) => {
      const target = e.target;
      if (target.tagName === 'TD') {
        const text = target.textContent.trim();
        if (ipRegex.test(text) && text.length <= 15) {
          target.classList.add('shield-ip-cell');
          this.showIPCard(e, text);
        }
      } else if (target.classList.contains('shield-ip-cell')) {
        this.showIPCard(e, target.textContent.trim());
      }
    });

    document.body.addEventListener('mouseout', (e) => {
      const target = e.target;
      // If leaving a TD or IP cell, hide the card
      if (target.tagName === 'TD' || target.classList.contains('shield-ip-cell')) {
        // Only hide if we aren't moving to the card itself
        const related = e.relatedTarget;
        if (!related || !related.closest('#shield-ip-card')) {
          this.hideIPCard();
        }
      }
    });
    
    // Ensure card doesn't disappear when hovering over it
    document.body.addEventListener('mouseleave', (e) => {
        const target = e.target;
        if (target && target.id === 'shield-ip-card') {
           this.hideIPCard();
        }
    }, true);
  },

  showIPCard(e, ip) {
    let card = document.getElementById('shield-ip-card');
    if (!card) {
      card = document.createElement('div');
      card.id = 'shield-ip-card';
      card.className = 'shield-ip-card';
      document.body.appendChild(card);
    }

    // Mock data for now (or fetch if API exists)
    card.innerHTML = `
      <div class="shield-ip-card__header">
        <i data-lucide="globe" class="icon icon-sm text-brand"></i>
        <span>تفاصيل العنوان: ${ip}</span>
      </div>
      <div class="shield-ip-card__body">
        <div class="shield-ip-card__row">
          <span class="label">الدولة:</span>
          <span class="value">جاري التحميل...</span>
        </div>
        <div class="shield-ip-card__row">
          <span class="label">الشبكة (ASN):</span>
          <span class="value">AS15169 (Google)</span>
        </div>
        <div class="shield-ip-card__row">
          <span class="label">مستوى الخطورة:</span>
          <span class="value text-success">آمن (0/100)</span>
        </div>
      </div>
      <div class="shield-ip-card__footer">
        <a href="ip-lookup.php?ip=${ip}" class="btn-shield-secondary btn-shield-sm">عرض التحليل الكامل</a>
      </div>
    `;

    this.initLucide(); // Update icons in card

    const rect = e.target.getBoundingClientRect();
    card.style.top = `${rect.bottom + window.scrollY + 8}px`;
    card.style.left = `${rect.left + window.scrollX}px`;
    card.classList.add('is-visible');
  },

  hideIPCard() {
    const card = document.getElementById('shield-ip-card');
    card?.classList.remove('is-visible');
  },

  /* ── Command Palette (Quick Search) ── */
  initPalette() {
    const palette = document.getElementById('shield-command-palette');
    const input = document.getElementById('palette-search');
    if (!palette || !input) return;

    // Keyboard trigger (Ctrl+K or Command+K)
    document.addEventListener('keydown', (e) => {
      if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        this.openPalette();
      }
      if (e.key === 'Escape' && palette.classList.contains('is-open')) {
        this.closePalette();
      }
    });

    // Filtering logic
    input.addEventListener('input', (e) => {
      const q = e.target.value.toLowerCase();
      const items = palette.querySelectorAll('.shield-palette__item');
      items.forEach(item => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(q) ? 'flex' : 'none';
      });
      
      // Hide empty groups
      palette.querySelectorAll('.shield-palette__group').forEach(group => {
        const visibleItems = group.querySelectorAll('.shield-palette__item:not([style*="display: none"])');
        group.style.display = visibleItems.length > 0 ? 'block' : 'none';
      });
    });
  },

  openPalette() {
    const palette = document.getElementById('shield-command-palette');
    const input = document.getElementById('palette-search');
    if (!palette) return;
    
    palette.classList.add('is-open');
    setTimeout(() => input?.focus(), 50);
  },

  closePalette() {
    const palette = document.getElementById('shield-command-palette');
    palette?.classList.remove('is-open');
  },

  /* ── Sidebar Toggle ── */
  initSidebarToggle() {
    const btn = document.querySelector('[data-toggle="sidebar"]');
    const sidebar = document.querySelector('.shield-sidebar');
    if (!sidebar) return;

    // Restore saved state
    const saved = localStorage.getItem('shield:sidebar');
    if (saved === 'collapsed') {
      sidebar.classList.add('is-collapsed');
      document.body.classList.add('sidebar-collapsed');
    }

    btn?.addEventListener('click', () => {
      sidebar.classList.toggle('is-collapsed');
      document.body.classList.toggle('sidebar-collapsed');
      const isCollapsed = sidebar.classList.contains('is-collapsed');
      localStorage.setItem('shield:sidebar', isCollapsed ? 'collapsed' : 'expanded');
    });

    // Mobile: close sidebar when clicking outside
    document.addEventListener('click', (e) => {
      if (window.innerWidth <= 991 &&
          sidebar.classList.contains('is-open') &&
          !sidebar.contains(e.target) &&
          !btn?.contains(e.target)) {
        sidebar.classList.remove('is-open');
      }
    });

    // Mobile: open as drawer
    if (window.innerWidth <= 991) {
      btn?.addEventListener('click', () => {
        sidebar.classList.toggle('is-open');
      });
    }
  },

  /* ── Theme Toggle ── */
  initThemeToggle() {
    const btn = document.getElementById('theme-toggle');
    const iconDark = document.getElementById('theme-icon-dark');
    const iconLight = document.getElementById('theme-icon-light');
    if (!btn) return;

    const applyTheme = (theme) => {
      document.documentElement.setAttribute('data-theme', theme);
      localStorage.setItem('shield:theme', theme);
      if (iconDark)  iconDark.style.display  = (theme === 'light') ? 'inline-block' : 'none';
      if (iconLight) iconLight.style.display = (theme === 'dark')  ? 'inline-block' : 'none';
    };

    // Restore saved theme
    const saved = localStorage.getItem('shield:theme') ||
                  document.documentElement.getAttribute('data-theme') || 'dark';
    applyTheme(saved);

    btn.addEventListener('click', () => {
      const current = document.documentElement.getAttribute('data-theme');
      const newTheme = current === 'dark' ? 'light' : 'dark';
      applyTheme(newTheme);
      
      // Notify components (like charts) that theme has changed
      document.dispatchEvent(new CustomEvent('shield:theme-change', { detail: { theme: newTheme } }));
    });
  },

  /* ── Topbar Scroll Glass Effect ── */
  initTopbarScroll() {
    const topbar = document.querySelector('.shield-topbar');
    if (!topbar) return;

    const content = document.querySelector('.content-wrapper');
    const scrollEl = content || window;

    const onScroll = () => {
      const scrollY = content ? content.scrollTop : window.scrollY;
      topbar.classList.toggle('is-scrolled', scrollY > 8);
    };

    scrollEl.addEventListener('scroll', onScroll, { passive: true });
  },

  /* ── Toast System ── */
  initToasts() {
    // Auto-hide visible toasts after 4 seconds
    document.querySelectorAll('.shield-toast').forEach(toast => {
      if (toast.classList.contains('is-visible')) {
        setTimeout(() => ShieldUI.hideToast(toast), 4000);
      }
      const closeBtn = toast.querySelector('.shield-toast__close');
      closeBtn?.addEventListener('click', () => ShieldUI.hideToast(toast));
    });
  },

  showToast(message, type = 'info', title = '') {
    const iconMap = {
      success: 'check-circle-2',
      critical: 'alert-circle',
      warning: 'alert-triangle',
      info: 'info'
    };

    const toast = document.createElement('div');
    toast.className = `shield-toast shield-toast--${type}`;
    toast.innerHTML = `
      <i data-lucide="${iconMap[type] || 'info'}" class="icon icon-md"></i>
      <div class="shield-toast__body">
        ${title ? `<div class="shield-toast__title">${title}</div>` : ''}
        <div class="shield-toast__desc">${message}</div>
      </div>
      <button class="btn-shield-icon shield-toast__close">
        <i data-lucide="x" class="icon icon-sm"></i>
      </button>
    `;

    document.body.appendChild(toast);
    lucide?.createIcons();

    requestAnimationFrame(() => {
      requestAnimationFrame(() => toast.classList.add('is-visible'));
    });

    setTimeout(() => ShieldUI.hideToast(toast), 4000);
    toast.querySelector('.shield-toast__close')?.addEventListener('click', () => ShieldUI.hideToast(toast));
    return toast;
  },

  hideToast(toast) {
    toast.classList.remove('is-visible');
    setTimeout(() => toast.remove(), 300);
  },

  /* ── Re-init Lucide after dynamic content ── */
  initLucide() {
    if (typeof lucide !== 'undefined') {
      lucide.createIcons();
    }
  }
};

document.addEventListener('DOMContentLoaded', () => ShieldUI.init());
