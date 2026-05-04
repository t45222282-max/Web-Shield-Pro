<?php
/**
 * includes/shield-kpi-total.php
 * Dashboard — Total Threat Statistics (Bottom Row)
 * Uses existing PHP variables from dashboard.php:
 * $countm  (SQLi)
 * $countm2 (Bad Bots)
 * $countm3 (Proxies)
 * $countm4 (Spammers)
 */
?>
<div class="shield-grid shield-grid--4" style="margin-bottom: var(--space-6);">
    <!-- SQLi Total -->
    <div class="shield-kpi-card shield-kpi--primary">
        <div class="shield-kpi-card__header">
            <span class="shield-kpi-card__title">إجمالي حقن SQL</span>
            <div class="shield-kpi-card__icon">
                <i data-lucide="database-zap" class="icon icon-sm"></i>
            </div>
        </div>
        <div class="shield-kpi-card__body">
            <div class="shield-kpi-card__value"><?php echo $countm ?? 0; ?></div>
        </div>
    </div>

    <!-- Bad Bots Total -->
    <div class="shield-kpi-card shield-kpi--critical">
        <div class="shield-kpi-card__header">
            <span class="shield-kpi-card__title">إجمالي البوتات السيئة</span>
            <div class="shield-kpi-card__icon">
                <i data-lucide="bot-off" class="icon icon-sm"></i>
            </div>
        </div>
        <div class="shield-kpi-card__body">
            <div class="shield-kpi-card__value"><?php echo $countm2 ?? 0; ?></div>
        </div>
    </div>

    <!-- Proxies Total -->
    <div class="shield-kpi-card shield-kpi--success">
        <div class="shield-kpi-card__header">
            <span class="shield-kpi-card__title">إجمالي الوكلاء</span>
            <div class="shield-kpi-card__icon">
                <i data-lucide="globe-lock" class="icon icon-sm"></i>
            </div>
        </div>
        <div class="shield-kpi-card__body">
            <div class="shield-kpi-card__value"><?php echo $countm3 ?? 0; ?></div>
        </div>
    </div>

    <!-- Spammers Total -->
    <div class="shield-kpi-card shield-kpi--warning">
        <div class="shield-kpi-card__header">
            <span class="shield-kpi-card__title">إجمالي المزعجون</span>
            <div class="shield-kpi-card__icon">
                <i data-lucide="mail-x" class="icon icon-sm"></i>
            </div>
        </div>
        <div class="shield-kpi-card__body">
            <div class="shield-kpi-card__value"><?php echo $countm4 ?? 0; ?></div>
        </div>
    </div>
</div>
