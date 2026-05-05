<?php
/**
 * includes/shield-kpi-analytics.php
 * Visit Analytics — KPI Cards
 * Uses existing PHP variables from visit-analytics.php:
 * $tscount1, $tscount2, $tscount3, $tscount4 (Today)
 * $mscount1, $mscount2, $mscount3 (Month)
 */
?>

<h4 class="txt-h4 neon-text-info" style="margin-bottom: var(--space-4); text-align: right; font-size: 1.6em; text-shadow: 0 0 10px rgba(0, 184, 230, 0.4);">إحصائيات اليوم</h4>
<div class="shield-grid shield-grid--4" style="margin-bottom: var(--space-6); direction: rtl;">
    <div class="neon-host-card neon-border-info" style="padding: 25px 15px; text-align: center; transition: transform 0.3s ease;">
        <i data-lucide="users" class="neon-icon-info neon-icon-animated micro-anim-pulse" style="width: 50px; height: 50px; margin: 0 auto 15px;"></i>
        <div class="neon-host-title" style="font-size: 1.1em; margin-bottom: 10px;">الزوار المتصلين</div>
        <div class="neon-host-val" style="font-size: 1.8em; font-weight: bold; font-family: monospace;"><?php echo $tscount1 ?? 0; ?></div>
    </div>

    <div class="neon-host-card neon-border-purple" style="padding: 25px 15px; text-align: center; transition: transform 0.3s ease;">
        <i data-lucide="fingerprint" class="neon-icon-purple neon-icon-animated micro-anim-pulse" style="width: 50px; height: 50px; margin: 0 auto 15px;"></i>
        <div class="neon-host-title" style="font-size: 1.1em; margin-bottom: 10px;">الزيارات الفريدة</div>
        <div class="neon-host-val" style="font-size: 1.8em; font-weight: bold; font-family: monospace;"><?php echo $tscount2 ?? 0; ?></div>
    </div>

    <div class="neon-host-card neon-border-info" style="padding: 25px 15px; text-align: center; transition: transform 0.3s ease;">
        <i data-lucide="bar-chart-3" class="neon-icon-info neon-icon-animated micro-anim-pulse" style="width: 50px; height: 50px; margin: 0 auto 15px;"></i>
        <div class="neon-host-title" style="font-size: 1.1em; margin-bottom: 10px;">إجمالي الزيارات</div>
        <div class="neon-host-val" style="font-size: 1.8em; font-weight: bold; font-family: monospace;"><?php echo $tscount3 ?? 0; ?></div>
    </div>

    <div class="neon-host-card neon-border-pink" style="padding: 25px 15px; text-align: center; transition: transform 0.3s ease;">
        <i data-lucide="bot" class="neon-icon-pink neon-icon-animated micro-anim-pulse" style="width: 50px; height: 50px; margin: 0 auto 15px;"></i>
        <div class="neon-host-title" style="font-size: 1.1em; margin-bottom: 10px;">زيارات الروبوتات</div>
        <div class="neon-host-val" style="font-size: 1.8em; font-weight: bold; font-family: monospace;"><?php echo $tscount4 ?? 0; ?></div>
    </div>
</div>

<h4 class="txt-h4 neon-text-purple" style="margin-bottom: var(--space-4); text-align: right; font-size: 1.6em; text-shadow: 0 0 10px rgba(139, 92, 246, 0.4);">إحصائيات هذا الشهر</h4>
<div class="shield-grid shield-grid--3" style="margin-bottom: var(--space-6); direction: rtl;">
    <div class="neon-host-card neon-border-purple" style="padding: 25px 15px; text-align: center; transition: transform 0.3s ease;">
        <i data-lucide="fingerprint" class="neon-icon-purple neon-icon-animated micro-anim-pulse" style="width: 50px; height: 50px; margin: 0 auto 15px;"></i>
        <div class="neon-host-title" style="font-size: 1.1em; margin-bottom: 10px;">الزيارات الفريدة</div>
        <div class="neon-host-val" style="font-size: 1.8em; font-weight: bold; font-family: monospace;"><?php echo $mscount1 ?? 0; ?></div>
    </div>

    <div class="neon-host-card neon-border-info" style="padding: 25px 15px; text-align: center; transition: transform 0.3s ease;">
        <i data-lucide="bar-chart-3" class="neon-icon-info neon-icon-animated micro-anim-pulse" style="width: 50px; height: 50px; margin: 0 auto 15px;"></i>
        <div class="neon-host-title" style="font-size: 1.1em; margin-bottom: 10px;">إجمالي الزيارات</div>
        <div class="neon-host-val" style="font-size: 1.8em; font-weight: bold; font-family: monospace;"><?php echo $mscount2 ?? 0; ?></div>
    </div>

    <div class="neon-host-card neon-border-pink" style="padding: 25px 15px; text-align: center; transition: transform 0.3s ease;">
        <i data-lucide="bot" class="neon-icon-pink neon-icon-animated micro-anim-pulse" style="width: 50px; height: 50px; margin: 0 auto 15px;"></i>
        <div class="neon-host-title" style="font-size: 1.1em; margin-bottom: 10px;">زيارات الروبوتات</div>
        <div class="neon-host-val" style="font-size: 1.8em; font-weight: bold; font-family: monospace;"><?php echo $mscount3 ?? 0; ?></div>
    </div>
</div>
