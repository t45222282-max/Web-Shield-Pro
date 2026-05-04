<?php
/**
 * includes/shield-kpi-analytics.php
 * Visit Analytics — KPI Cards
 * Uses existing PHP variables from visit-analytics.php:
 * $tscount1, $tscount2, $tscount3, $tscount4 (Today)
 * $mscount1, $mscount2, $mscount3 (Month)
 */
?>

<h4 class="txt-h4" style="margin-bottom: var(--space-4);">إحصائيات اليوم</h4>
<div class="shield-grid shield-grid--4" style="margin-bottom: var(--space-6);">
    <div class="shield-kpi-card shield-kpi--success">
        <div class="shield-kpi-card__header">
            <span class="shield-kpi-card__title">الزوار المتصلين</span>
            <div class="shield-kpi-card__icon">
                <i data-lucide="users" class="icon icon-sm"></i>
            </div>
        </div>
        <div class="shield-kpi-card__body">
            <div class="shield-kpi-card__value"><?php echo $tscount1 ?? 0; ?></div>
        </div>
    </div>

    <div class="shield-kpi-card shield-kpi--info">
        <div class="shield-kpi-card__header">
            <span class="shield-kpi-card__title">الزيارات الفريدة</span>
            <div class="shield-kpi-card__icon">
                <i data-lucide="fingerprint" class="icon icon-sm"></i>
            </div>
        </div>
        <div class="shield-kpi-card__body">
            <div class="shield-kpi-card__value"><?php echo $tscount2 ?? 0; ?></div>
        </div>
    </div>

    <div class="shield-kpi-card shield-kpi--primary">
        <div class="shield-kpi-card__header">
            <span class="shield-kpi-card__title">إجمالي الزيارات</span>
            <div class="shield-kpi-card__icon">
                <i data-lucide="bar-chart-3" class="icon icon-sm"></i>
            </div>
        </div>
        <div class="shield-kpi-card__body">
            <div class="shield-kpi-card__value"><?php echo $tscount3 ?? 0; ?></div>
        </div>
    </div>

    <div class="shield-kpi-card shield-kpi--warning">
        <div class="shield-kpi-card__header">
            <span class="shield-kpi-card__title">زيارات الروبوتات</span>
            <div class="shield-kpi-card__icon">
                <i data-lucide="bot" class="icon icon-sm"></i>
            </div>
        </div>
        <div class="shield-kpi-card__body">
            <div class="shield-kpi-card__value"><?php echo $tscount4 ?? 0; ?></div>
        </div>
    </div>
</div>

<h4 class="txt-h4" style="margin-bottom: var(--space-4);">إحصائيات هذا الشهر</h4>
<div class="shield-grid shield-grid--3" style="margin-bottom: var(--space-6);">
    <div class="shield-kpi-card shield-kpi--info">
        <div class="shield-kpi-card__header">
            <span class="shield-kpi-card__title">الزيارات الفريدة</span>
            <div class="shield-kpi-card__icon">
                <i data-lucide="fingerprint" class="icon icon-sm"></i>
            </div>
        </div>
        <div class="shield-kpi-card__body">
            <div class="shield-kpi-card__value"><?php echo $mscount1 ?? 0; ?></div>
        </div>
    </div>

    <div class="shield-kpi-card shield-kpi--primary">
        <div class="shield-kpi-card__header">
            <span class="shield-kpi-card__title">إجمالي الزيارات</span>
            <div class="shield-kpi-card__icon">
                <i data-lucide="bar-chart-3" class="icon icon-sm"></i>
            </div>
        </div>
        <div class="shield-kpi-card__body">
            <div class="shield-kpi-card__value"><?php echo $mscount2 ?? 0; ?></div>
        </div>
    </div>

    <div class="shield-kpi-card shield-kpi--warning">
        <div class="shield-kpi-card__header">
            <span class="shield-kpi-card__title">زيارات الروبوتات</span>
            <div class="shield-kpi-card__icon">
                <i data-lucide="bot" class="icon icon-sm"></i>
            </div>
        </div>
        <div class="shield-kpi-card__body">
            <div class="shield-kpi-card__value"><?php echo $mscount3 ?? 0; ?></div>
        </div>
    </div>
</div>
