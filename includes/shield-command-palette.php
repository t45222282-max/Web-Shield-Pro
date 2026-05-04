<?php
/**
 * includes/shield-command-palette.php
 * Command Palette (Ctrl+K) — Shield Design System
 * Reference: docs/07-implementation-roadmap.md § 6.1
 */
?>
<div id="shield-command-palette" class="shield-palette">
    <div class="shield-palette__backdrop" onclick="ShieldUI.closePalette()"></div>
    <div class="shield-palette__dialog">
        <div class="shield-palette__search">
            <i data-lucide="search" class="icon icon-md text-tertiary"></i>
            <input type="text" id="palette-search" placeholder="ابحث عن صفحة، IP، أو أمر..." autocomplete="off">
            <kbd class="shield-kbd">ESC</kbd>
        </div>
        <div class="shield-palette__results" id="palette-results">
            <div class="shield-palette__group">
                <div class="shield-palette__group-title">التنقل السريع</div>
                <a href="dashboard.php" class="shield-palette__item">
                    <i data-lucide="home" class="icon icon-sm"></i>
                    <span>لوحة التحكم</span>
                    <kbd class="shield-kbd">D</kbd>
                </a>
                <a href="all-logs.php" class="shield-palette__item">
                    <i data-lucide="scroll-text" class="icon icon-sm"></i>
                    <span>سجلات التهديدات</span>
                    <kbd class="shield-kbd">L</kbd>
                </a>
                <a href="bans-ip.php" class="shield-palette__item">
                    <i data-lucide="ban" class="icon icon-sm"></i>
                    <span>قائمة الحظر</span>
                    <kbd class="shield-kbd">B</kbd>
                </a>
                <a href="visit-analytics.php" class="shield-palette__item">
                    <i data-lucide="bar-chart-3" class="icon icon-sm"></i>
                    <span>تحليلات الزيارات</span>
                    <kbd class="shield-kbd">A</kbd>
                </a>
            </div>
            <div class="shield-palette__group">
                <div class="shield-palette__group-title">أدوات الأمان</div>
                <a href="sql-injection.php" class="shield-palette__item">
                    <i data-lucide="database-zap" class="icon icon-sm"></i>
                    <span>حماية SQLi</span>
                </a>
                <a href="proxy.php" class="shield-palette__item">
                    <i data-lucide="globe-lock" class="icon icon-sm"></i>
                    <span>حماية الوكيل</span>
                </a>
                <a href="settings.php" class="shield-palette__item">
                    <i data-lucide="settings" class="icon icon-sm"></i>
                    <span>إعدادات النظام</span>
                    <kbd class="shield-kbd">S</kbd>
                </a>
            </div>
        </div>
        <div class="shield-palette__footer">
            <span>تحرك بـ <kbd class="shield-kbd">↑↓</kbd></span>
            <span>اختر بـ <kbd class="shield-kbd">Enter</kbd></span>
        </div>
    </div>
</div>
