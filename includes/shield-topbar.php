<?php
/**
 * includes/shield-topbar.php
 * Topbar Component — Markup only, no logic
 * Reference: docs/05-layout-and-navigation.md § 3
 * Styles: assets/css/shield/layout/_topbar.css
 */
?>
<header class="shield-topbar" id="shield-topbar">

    <!-- Start: Sidebar Toggle + Breadcrumb -->
    <div class="shield-topbar__start">
        <button class="btn-shield-icon" data-toggle="sidebar" aria-label="Toggle Sidebar" title="طي/توسيع القائمة">
            <i data-lucide="panel-left-close" class="icon icon-md"></i>
        </button>

        <!-- Command Palette Trigger (Phase 6: functionality added later) -->
        <button class="shield-cmdk-trigger d-none d-md-flex" id="cmdk-trigger" title="بحث سريع">
            <i data-lucide="search" class="icon icon-sm"></i>
            <span>بحث سريع...</span>
            <kbd>Ctrl K</kbd>
        </button>
    </div>

    <!-- End: Actions -->
    <div class="shield-topbar__end">
        <!-- External site link -->
        <a href="<?= htmlspecialchars($settings['site_url'] ?? '#') ?>"
           class="btn-shield-icon" target="_blank" rel="noopener"
           title="زيارة الموقع">
            <i data-lucide="external-link" class="icon icon-md"></i>
        </a>

        <!-- Theme Toggle -->
        <button class="btn-shield-icon" id="theme-toggle" title="تبديل المظهر">
            <i data-lucide="sun" class="icon icon-md" id="theme-icon-light"></i>
            <i data-lucide="moon" class="icon icon-md" id="theme-icon-dark"></i>
        </button>

        <!-- Settings -->
        <a href="settings.php" class="btn-shield-icon" title="الإعدادات">
            <i data-lucide="settings" class="icon icon-md"></i>
        </a>

        <!-- Logout -->
        <a href="logout.php" class="btn-shield-icon" title="تسجيل الخروج" style="color: var(--color-critical);">
            <i data-lucide="log-out" class="icon icon-md"></i>
        </a>
    </div>

</header>
