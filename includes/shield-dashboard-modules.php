<?php
/**
 * includes/shield-dashboard-modules.php
 * Dashboard — Module Status Cards Component
 * Reference: docs/04-component-library.md § shield-card
 * Depends on: dashboard.php variables: $settings, $querysp
 * NO DB queries here — uses $settings passed from dashboard.php
 */

// Determine spam status
$spam_on = (!empty($settings['spam_protection']) && $settings['spam_protection'] == 1 && isset($querysp) && mysqli_num_rows($querysp) > 0);

$protection_modules = [
    [
        'label'   => 'حقن SQL',
        'icon'    => 'database-zap',
        'on'      => !empty($settings['sqli_protection']) && $settings['sqli_protection'] == 1,
        'link'    => 'sql-injection.php',
    ],
    [
        'label'   => 'الروبوتات السيئة',
        'icon'    => 'bot-off',
        'on'      => !empty($settings['badbot_protection']) && ($settings['badbot_protection'] == 1 || !empty($settings['badbot_protection2']) || !empty($settings['badbot_protection3'])),
        'link'    => 'badbots.php',
    ],
    [
        'label'   => 'الوكيل',
        'icon'    => 'globe-lock',
        'on'      => !empty($settings['proxy_protection']) && ($settings['proxy_protection'] > 0 || !empty($settings['proxy_protection2'])),
        'link'    => 'proxy.php',
    ],
    [
        'label'   => 'المزعجون',
        'icon'    => 'mail-x',
        'on'      => $spam_on,
        'link'    => 'spam.php',
    ],
];

$logging_modules = [
    [
        'label'   => 'حقن SQL',
        'icon'    => 'database-zap',
        'on'      => !empty($settings['sqli_logging']) && $settings['sqli_logging'] == 1,
        'link'    => 'sql-injection.php',
    ],
    [
        'label'   => 'الروبوتات السيئة',
        'icon'    => 'bot-off',
        'on'      => !empty($settings['badbot_logging']) && $settings['badbot_logging'] == 1,
        'link'    => 'badbots.php',
    ],
    [
        'label'   => 'الوكيل',
        'icon'    => 'globe-lock',
        'on'      => !empty($settings['proxy_logging']) && $settings['proxy_logging'] == 1,
        'link'    => 'proxy.php',
    ],
    [
        'label'   => 'المزعجون',
        'icon'    => 'mail-x',
        'on'      => !empty($settings['spam_logging']) && $settings['spam_logging'] == 1,
        'link'    => 'spam.php',
    ],
];
?>

<!-- Protection Modules Section -->
<div class="shield-card" style="margin-bottom: var(--space-4);">
    <div class="shield-card__header">
        <i data-lucide="shield-alert" class="icon icon-sm text-brand"></i>
        <span class="shield-card__title">حالة وحدات الحماية</span>
    </div>
    <div class="shield-card__body">
        <div class="grid grid-cols-4 gap-4">
            <?php foreach ($protection_modules as $mod): ?>
            <a href="<?= htmlspecialchars($mod['link']) ?>" class="shield-module-card <?= $mod['on'] ? 'shield-module-card--on' : 'shield-module-card--off' ?>">
                <div class="shield-module-card__icon">
                    <i data-lucide="<?= htmlspecialchars($mod['icon']) ?>" class="icon icon-md"></i>
                </div>
                <div class="shield-module-card__info">
                    <span class="shield-module-card__label"><?= htmlspecialchars($mod['label']) ?></span>
                    <span class="shield-module-card__status">
                        <span class="status-dot <?= $mod['on'] ? 'status-dot--on' : 'status-dot--off' ?>"></span>
                        <?= $mod['on'] ? 'مفعّل' : 'معطل' ?>
                    </span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Logging Modules Section -->
<div class="shield-card" style="margin-bottom: var(--space-4);">
    <div class="shield-card__header">
        <i data-lucide="file-clock" class="icon icon-sm text-brand"></i>
        <span class="shield-card__title">إعدادات التسجيل (Logging)</span>
    </div>
    <div class="shield-card__body">
        <div class="grid grid-cols-4 gap-4">
            <?php foreach ($logging_modules as $mod): ?>
            <a href="<?= htmlspecialchars($mod['link']) ?>" class="shield-module-card <?= $mod['on'] ? 'shield-module-card--on' : 'shield-module-card--off' ?>">
                <div class="shield-module-card__icon">
                    <i data-lucide="<?= htmlspecialchars($mod['icon']) ?>" class="icon icon-md"></i>
                </div>
                <div class="shield-module-card__info">
                    <span class="shield-module-card__label"><?= htmlspecialchars($mod['label']) ?></span>
                    <span class="shield-module-card__status">
                        <span class="status-dot <?= $mod['on'] ? 'status-dot--on' : 'status-dot--off' ?>"></span>
                        <?= $mod['on'] ? 'مفعّل' : 'معطل' ?>
                    </span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

