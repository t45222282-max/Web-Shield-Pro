<?php
/**
 * shield-kpi-today.php
 * KPI Cards for Today's Stats
 * Reference: docs/04-component-library.md § 3.2
 */
?>
<div class="shield-grid shield-grid--4" style="margin-bottom: var(--space-6);">
    <!-- SQLi Attacks -->
    <div class="shield-kpi-card shield-kpi--primary">
        <div class="shield-kpi-card__header">
            <span class="shield-kpi-card__title">هجمات SQLi</span>
            <div class="shield-kpi-card__icon">
                <i data-lucide="code" class="icon icon-sm"></i>
            </div>
        </div>
        <div class="shield-kpi-card__body">
            <div class="shield-kpi-card__value num"><?= htmlspecialchars($count) ?></div>
        </div>
        <div class="shield-kpi-card__footer" style="padding-top: var(--space-2); border-top: 1px solid var(--border-subtle); margin-top: var(--space-2);">
            <a href="sqli-logs.php" class="txt-body-sm txt-secondary" style="text-decoration: none; display: flex; align-items: center; gap: 4px;">
                عرض السجلات <i data-lucide="arrow-right" class="icon icon-xs"></i>
            </a>
        </div>
    </div>

    <!-- Bad Bots -->
    <div class="shield-kpi-card shield-kpi--critical">
        <div class="shield-kpi-card__header">
            <span class="shield-kpi-card__title">البوتات السيئة</span>
            <div class="shield-kpi-card__icon">
                <i data-lucide="bot" class="icon icon-sm"></i>
            </div>
        </div>
        <div class="shield-kpi-card__body">
            <div class="shield-kpi-card__value num"><?= htmlspecialchars($count2) ?></div>
        </div>
        <div class="shield-kpi-card__footer" style="padding-top: var(--space-2); border-top: 1px solid var(--border-subtle); margin-top: var(--space-2);">
            <a href="badbot-logs.php" class="txt-body-sm txt-secondary" style="text-decoration: none; display: flex; align-items: center; gap: 4px;">
                عرض السجلات <i data-lucide="arrow-right" class="icon icon-xs"></i>
            </a>
        </div>
    </div>

    <!-- Proxies -->
    <div class="shield-kpi-card shield-kpi--success">
        <div class="shield-kpi-card__header">
            <span class="shield-kpi-card__title">الوكلاء</span>
            <div class="shield-kpi-card__icon">
                <i data-lucide="globe" class="icon icon-sm"></i>
            </div>
        </div>
        <div class="shield-kpi-card__body">
            <div class="shield-kpi-card__value num"><?= htmlspecialchars($count3) ?></div>
        </div>
        <div class="shield-kpi-card__footer" style="padding-top: var(--space-2); border-top: 1px solid var(--border-subtle); margin-top: var(--space-2);">
            <a href="proxy-logs.php" class="txt-body-sm txt-secondary" style="text-decoration: none; display: flex; align-items: center; gap: 4px;">
                عرض السجلات <i data-lucide="arrow-right" class="icon icon-xs"></i>
            </a>
        </div>
    </div>

    <!-- Spammers -->
    <div class="shield-kpi-card shield-kpi--warning">
        <div class="shield-kpi-card__header">
            <span class="shield-kpi-card__title">المزعجون</span>
            <div class="shield-kpi-card__icon">
                <i data-lucide="keyboard" class="icon icon-sm"></i>
            </div>
        </div>
        <div class="shield-kpi-card__body">
            <div class="shield-kpi-card__value num"><?= htmlspecialchars($count4) ?></div>
        </div>
        <div class="shield-kpi-card__footer" style="padding-top: var(--space-2); border-top: 1px solid var(--border-subtle); margin-top: var(--space-2);">
            <a href="spammer-logs.php" class="txt-body-sm txt-secondary" style="text-decoration: none; display: flex; align-items: center; gap: 4px;">
                عرض السجلات <i data-lucide="arrow-right" class="icon icon-xs"></i>
            </a>
        </div>
    </div>
</div>





