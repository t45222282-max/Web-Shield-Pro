<?php
/**
 * includes/shield-sidebar.php
 * Sidebar Navigation Component — Markup only, no logic
 * Reference: docs/05-layout-and-navigation.md § 2
 * Styles: assets/css/shield/layout/_sidebar.css
 */
$current_page = basename($_SERVER['SCRIPT_NAME']);
?>
<aside class="shield-sidebar" id="shield-sidebar">

    <!-- Brand Header -->
    <div class="shield-sidebar__header">
        <a href="dashboard.php" class="shield-sidebar__brand">
            <i data-lucide="shield" class="icon"></i>
            <span class="shield-sidebar__brand-text">درع الويب</span>
        </a>
    </div>

    <!-- Navigation Body -->
    <div class="shield-sidebar__body">
        <ul class="shield-nav">

            <!-- ── عام ── -->
            <li class="shield-nav__title">عام</li>

            <li class="shield-nav__item">
                <a href="dashboard.php"
                   class="shield-nav__link <?= ($current_page === 'dashboard.php') ? 'is-active' : '' ?>"
                   data-label="لوحة التحكم">
                    <i data-lucide="layout-dashboard" class="icon icon-sm"></i>
                    <span>لوحة التحكم</span>
                </a>
            </li>

            <li class="shield-nav__item">
                <a href="system-info.php"
                   class="shield-nav__link <?= ($current_page === 'system-info.php') ? 'is-active' : '' ?>"
                   data-label="معلومات النظام">
                    <i data-lucide="monitor-check" class="icon icon-sm"></i>
                    <span>معلومات النظام</span>
                </a>
            </li>

            <li class="shield-nav__item">
                <a href="login-history.php"
                   class="shield-nav__link <?= ($current_page === 'login-history.php') ? 'is-active' : '' ?>"
                   data-label="سجل الدخول">
                    <i data-lucide="history" class="icon icon-sm"></i>
                    <span>سجل الدخول</span>
                </a>
            </li>

            <!-- ── القوائم البيضاء ── -->
            <li class="shield-nav__title">القوائم البيضاء</li>

            <li class="shield-nav__item">
                <a href="ip-whitelist.php"
                   class="shield-nav__link <?= ($current_page === 'ip-whitelist.php') ? 'is-active' : '' ?>"
                   data-label="IP القائمة البيضاء">
                    <i data-lucide="user-check" class="icon icon-sm"></i>
                    <span>IP القائمة البيضاء</span>
                </a>
            </li>

            <li class="shield-nav__item">
                <a href="file-whitelist.php"
                   class="shield-nav__link <?= ($current_page === 'file-whitelist.php') ? 'is-active' : '' ?>"
                   data-label="File القائمة البيضاء">
                    <i data-lucide="file-check-2" class="icon icon-sm"></i>
                    <span>File القائمة البيضاء</span>
                </a>
            </li>

            <!-- ── الحماية ── -->
            <li class="shield-nav__title">الحماية</li>

            <li class="shield-nav__item">
                <a href="sql-injection.php"
                   class="shield-nav__link <?= ($current_page === 'sql-injection.php') ? 'is-active' : '' ?>"
                   data-label="حقن SQL">
                    <i data-lucide="database-zap" class="icon icon-sm"></i>
                    <span>حقن SQL</span>
                    <span class="status-dot <?= (!empty($settings['sqli_protection']) && $settings['sqli_protection'] == 1) ? 'status-dot--on' : 'status-dot--off' ?>" title="<?= (!empty($settings['sqli_protection']) && $settings['sqli_protection'] == 1) ? 'مفعل' : 'معطل' ?>"></span>
                </a>
            </li>

            <li class="shield-nav__item">
                <a href="badbots.php"
                   class="shield-nav__link <?= ($current_page === 'badbots.php') ? 'is-active' : '' ?>"
                   data-label="الروبوتات السيئة">
                    <i data-lucide="bot-off" class="icon icon-sm"></i>
                    <span>الروبوتات السيئة</span>
                    <span class="status-dot <?= (!empty($settings['badbot_protection']) && ($settings['badbot_protection'] == 1 || !empty($settings['badbot_protection2']) || !empty($settings['badbot_protection3']))) ? 'status-dot--on' : 'status-dot--off' ?>"></span>
                </a>
            </li>

            <li class="shield-nav__item">
                <a href="proxy.php"
                   class="shield-nav__link <?= ($current_page === 'proxy.php') ? 'is-active' : '' ?>"
                   data-label="الوكيل">
                    <i data-lucide="globe-lock" class="icon icon-sm"></i>
                    <span>الوكيل</span>
                    <span class="status-dot <?= (!empty($settings['proxy_protection']) && ($settings['proxy_protection'] > 0 || !empty($settings['proxy_protection2']))) ? 'status-dot--on' : 'status-dot--off' ?>"></span>
                </a>
            </li>

            <li class="shield-nav__item">
                <a href="spam.php"
                   class="shield-nav__link <?= ($current_page === 'spam.php') ? 'is-active' : '' ?>"
                   data-label="المزعجون">
                    <i data-lucide="mail-x" class="icon icon-sm"></i>
                    <span>المزعجون</span>
                    <span class="status-dot <?= (!empty($settings['spam_protection']) && $settings['spam_protection'] == 1) ? 'status-dot--on' : 'status-dot--off' ?>"></span>
                </a>
            </li>

            <li class="shield-nav__item">
                <a href="bad-words.php"
                   class="shield-nav__link <?= ($current_page === 'bad-words.php') ? 'is-active' : '' ?>"
                   data-label="كلمات سيئة">
                    <i data-lucide="message-square-x" class="icon icon-sm"></i>
                    <span>كلمات سيئة</span>
                </a>
            </li>

            <!-- ── السجلات والحظر ── -->
            <li class="shield-nav__title">السجلات والحظر</li>

            <?php
            $log_pages = ['all-logs.php','sqli-logs.php','badbot-logs.php','proxy-logs.php','spammer-logs.php','log-details.php'];
            $is_log_page = in_array($current_page, $log_pages);
            $ban_pages = ['bans-ip.php','bans-iprange.php','bans-country.php','bans-other.php'];
            $is_ban_page = in_array($current_page, $ban_pages);
            ?>

            <li class="shield-nav__item">
                <a href="all-logs.php"
                   class="shield-nav__link <?= $is_log_page ? 'is-active' : '' ?>"
                   data-label="السجلات">
                    <i data-lucide="scroll-text" class="icon icon-sm"></i>
                    <span>السجلات</span>
                </a>
            </li>

            <li class="shield-nav__item">
                <a href="bans-ip.php"
                   class="shield-nav__link <?= $is_ban_page ? 'is-active' : '' ?>"
                   data-label="قوائم الحظر">
                    <i data-lucide="shield-ban" class="icon icon-sm"></i>
                    <span>قوائم الحظر</span>
                </a>
            </li>

            <!-- ── التحليلات ── -->
            <li class="shield-nav__title">التحليلات</li>

            <li class="shield-nav__item">
                <a href="live-traffic.php"
                   class="shield-nav__link <?= ($current_page === 'live-traffic.php') ? 'is-active' : '' ?>"
                   data-label="حركة المرور الحية">
                    <i data-lucide="activity" class="icon icon-sm"></i>
                    <span>حركة المرور الحية</span>
                    <span class="status-dot <?= (!empty($settings['live_traffic']) && $settings['live_traffic'] == 1) ? 'status-dot--on' : 'status-dot--off' ?>"></span>
                </a>
            </li>

            <li class="shield-nav__item">
                <a href="visit-analytics.php"
                   class="shield-nav__link <?= ($current_page === 'visit-analytics.php') ? 'is-active' : '' ?>"
                   data-label="تحليلات الزيارات">
                    <i data-lucide="bar-chart-3" class="icon icon-sm"></i>
                    <span>تحليلات الزيارات</span>
                </a>
            </li>

            <!-- ── فحص الأمان ── -->
            <li class="shield-nav__title">فحص الأمان</li>

            <li class="shield-nav__item">
                <a href="phpfunctions-check.php"
                   class="shield-nav__link <?= ($current_page === 'phpfunctions-check.php') ? 'is-active' : '' ?>"
                   data-label="وظائف PHP">
                    <i data-lucide="code-2" class="icon icon-sm"></i>
                    <span>وظائف PHP</span>
                </a>
            </li>

            <li class="shield-nav__item">
                <a href="phpconfig-check.php"
                   class="shield-nav__link <?= ($current_page === 'phpconfig-check.php') ? 'is-active' : '' ?>"
                   data-label="تكوين PHP">
                    <i data-lucide="settings-2" class="icon icon-sm"></i>
                    <span>تكوين PHP</span>
                </a>
            </li>

        </ul>
    </div>

    <!-- User Zone -->
    <div class="shield-sidebar__footer">
        <a href="account.php" class="shield-sidebar__user">
            <div class="shield-sidebar__avatar">
                <?= strtoupper(substr($settings['username'] ?? 'A', 0, 1)) ?>
            </div>
            <div class="shield-sidebar__user-info">
                <span class="shield-sidebar__username"><?= htmlspecialchars($settings['username'] ?? 'Admin') ?></span>
                <span class="shield-sidebar__status">● Online</span>
            </div>
        </a>
    </div>

</aside>
