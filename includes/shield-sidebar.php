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

            <li class="shield-nav__item">
                <a href="settings-2fa.php"
                   class="shield-nav__link <?= ($current_page === 'settings-2fa.php') ? 'is-active' : '' ?>"
                   data-label="المصادقة الثنائية">
                    <i data-lucide="key-round" class="icon icon-sm"></i>
                    <span>المصادقة الثنائية</span>
                    <span class="status-dot <?= (!empty($settings['2fa_enabled']) && $settings['2fa_enabled'] == 1) ? 'status-dot--on' : 'status-dot--off' ?>"></span>
                </a>
            </li>

            <!-- ── القوائم البيضاء ── -->
            <li class="shield-nav__title">القوائم البيضاء</li>

            <li class="shield-nav__item shield-nav__has-treeview">
                <a href="#" class="shield-nav__link" data-label="القائمة البيضاء">
                    <i data-lucide="flag" class="icon icon-sm"></i>
                    <span>القائمة البيضاء</span>
                </a>
                <ul class="shield-nav__treeview">
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
                </ul>
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

            // Safely get counts
            global $mysqli;
            $lcount1 = $lcount2 = $lcount3 = $lcount4 = $lcount5 = 0;
            $bcount1 = $bcount2 = $bcount3 = $bcount4 = 0;

            if (isset($mysqli) && $mysqli instanceof mysqli) {
                // Log counts
                $lquery1 = $mysqli->query("SELECT id FROM `psec_logs`");
                $lcount1 = $lquery1 ? mysqli_num_rows($lquery1) : 0;
                $lquery2 = $mysqli->query("SELECT id FROM `psec_logs` WHERE `type`='SQLi'");
                $lcount2 = $lquery2 ? mysqli_num_rows($lquery2) : 0;
                $lquery3 = $mysqli->query("SELECT id FROM `psec_logs` WHERE `type`='Bad Bot' or `type`='Fake Bot' or type='Missing User-Agent header' or type='Missing header Accept' or type='Invalid IP Address header'");
                $lcount3 = $lquery3 ? mysqli_num_rows($lquery3) : 0;
                $lquery4 = $mysqli->query("SELECT id FROM `psec_logs` WHERE `type`='Proxy'");
                $lcount4 = $lquery4 ? mysqli_num_rows($lcount4) : 0;
                $lquery5 = $mysqli->query("SELECT id FROM `psec_logs` WHERE `type`='Spammer'");
                $lcount5 = $lquery5 ? mysqli_num_rows($lquery5) : 0;

                // Ban counts
                $bquery1 = $mysqli->query("SELECT id FROM `psec_bans`");
                $bcount1 = $bquery1 ? mysqli_num_rows($bquery1) : 0;
                $bquery2 = $mysqli->query("SELECT id FROM `psec_bans-country`");
                $bcount2 = $bquery2 ? mysqli_num_rows($bquery2) : 0;
                $bquery3 = $mysqli->query("SELECT id FROM `psec_bans-ranges`");
                $bcount3 = $bquery3 ? mysqli_num_rows($bquery3) : 0;
                $bquery4 = $mysqli->query("SELECT id FROM `psec_bans-other`");
                $bcount4 = $bquery4 ? mysqli_num_rows($bquery4) : 0;
            }
            ?>

            <!-- سجلات Treeview -->
            <li class="shield-nav__item shield-nav__has-treeview <?= $is_log_page ? 'is-expanded' : '' ?>">
                <a href="#" class="shield-nav__link <?= $is_log_page ? 'is-active' : '' ?>" data-label="سجلات">
                    <i data-lucide="align-justify" class="icon icon-sm"></i>
                    <span>سجلات</span>
                </a>
                <ul class="shield-nav__treeview <?= $is_log_page ? 'is-open' : '' ?>">
                    <li class="shield-nav__item">
                        <a href="all-logs.php"
                           class="shield-nav__link <?= ($current_page === 'all-logs.php') ? 'is-active' : '' ?>"
                           data-label="جميع السجلات">
                            <i data-lucide="align-justify" class="icon icon-sm"></i>
                            <span>جميع السجلات</span>
                            <span class="shield-sidebar-badge shield-sidebar-badge--primary"><?= $lcount1 ?></span>
                        </a>
                    </li>
                    <li class="shield-nav__item">
                        <a href="sqli-logs.php"
                           class="shield-nav__link <?= ($current_page === 'sqli-logs.php') ? 'is-active' : '' ?>"
                           data-label="سجلات SQLi">
                            <i data-lucide="code" class="icon icon-sm"></i>
                            <span>سجلات SQLi</span>
                            <span class="shield-sidebar-badge shield-sidebar-badge--primary"><?= $lcount2 ?></span>
                        </a>
                    </li>
                    <li class="shield-nav__item">
                        <a href="badbot-logs.php"
                           class="shield-nav__link <?= ($current_page === 'badbot-logs.php') ? 'is-active' : '' ?>"
                           data-label="سجلات الروبوتات السيئة">
                            <i data-lucide="bot" class="icon icon-sm"></i>
                            <span>سجلات الروبوتات السيئة</span>
                            <span class="shield-sidebar-badge shield-sidebar-badge--danger"><?= $lcount3 ?></span>
                        </a>
                    </li>
                    <li class="shield-nav__item">
                        <a href="proxy-logs.php"
                           class="shield-nav__link <?= ($current_page === 'proxy-logs.php') ? 'is-active' : '' ?>"
                           data-label="سجلات الوكيل">
                            <i data-lucide="globe" class="icon icon-sm"></i>
                            <span>سجلات الوكيل</span>
                            <span class="shield-sidebar-badge shield-sidebar-badge--success"><?= $lcount4 ?></span>
                        </a>
                    </li>
                    <li class="shield-nav__item">
                        <a href="spammer-logs.php"
                           class="shield-nav__link <?= ($current_page === 'spammer-logs.php') ? 'is-active' : '' ?>"
                           data-label="سجلات المزعجون">
                            <i data-lucide="keyboard" class="icon icon-sm"></i>
                            <span>سجلات المزعجون</span>
                            <span class="shield-sidebar-badge shield-sidebar-badge--warning"><?= $lcount5 ?></span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- قوائم الحظر Treeview -->
            <li class="shield-nav__item shield-nav__has-treeview <?= $is_ban_page ? 'is-expanded' : '' ?>">
                <a href="#" class="shield-nav__link <?= $is_ban_page ? 'is-active' : '' ?>" data-label="الحظر">
                    <i data-lucide="shield-ban" class="icon icon-sm"></i>
                    <span>الحظر</span>
                </a>
                <ul class="shield-nav__treeview <?= $is_ban_page ? 'is-open' : '' ?>">
                    <li class="shield-nav__item">
                        <a href="bans-ip.php"
                           class="shield-nav__link <?= ($current_page === 'bans-ip.php') ? 'is-active' : '' ?>"
                           data-label="حظر عناوين IP">
                            <i data-lucide="user-x" class="icon icon-sm"></i>
                            <span>حظر عناوين IP</span>
                            <span class="shield-sidebar-badge"><?= $bcount1 ?></span>
                        </a>
                    </li>
                    <li class="shield-nav__item">
                        <a href="bans-country.php"
                           class="shield-nav__link <?= ($current_page === 'bans-country.php') ? 'is-active' : '' ?>"
                           data-label="حظر الدول">
                            <i data-lucide="globe" class="icon icon-sm"></i>
                            <span>حظر الدول</span>
                            <span class="shield-sidebar-badge"><?= $bcount2 ?></span>
                        </a>
                    </li>
                    <li class="shield-nav__item">
                        <a href="bans-iprange.php"
                           class="shield-nav__link <?= ($current_page === 'bans-iprange.php') ? 'is-active' : '' ?>"
                           data-label="حظر نطاقات IP">
                            <i data-lucide="layout-grid" class="icon icon-sm"></i>
                            <span>حظر نطاقات IP</span>
                            <span class="shield-sidebar-badge"><?= $bcount3 ?></span>
                        </a>
                    </li>
                    <li class="shield-nav__item">
                        <a href="bans-other.php"
                           class="shield-nav__link <?= ($current_page === 'bans-other.php') ? 'is-active' : '' ?>"
                           data-label="حظر أخرى">
                            <i data-lucide="monitor-x" class="icon icon-sm"></i>
                            <span>حظر أخرى</span>
                            <span class="shield-sidebar-badge"><?= $bcount4 ?></span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- ── التحليلات ── -->
            <li class="shield-nav__title">التحليلات</li>

            <li class="shield-nav__item">
                <a href="live-traffic.php"
                   class="shield-nav__link <?= ($current_page === 'live-traffic.php') ? 'is-active' : '' ?>"
                   data-label="مراقبة الزيارات">
                    <i data-lucide="globe-2" class="icon icon-sm"></i>
                    <span>مراقبة الزيارات</span>
                    <span class="status-dot <?= (!empty($settings['live_traffic']) && $settings['live_traffic'] == 1) ? 'status-dot--on' : 'status-dot--off' ?>"></span>
                </a>
            </li>

            <li class="shield-nav__item">
                <a href="live-traffic-lite.php"
                   class="shield-nav__link <?= ($current_page === 'live-traffic-lite.php') ? 'is-active' : '' ?>"
                   data-label="إحصائيات الزيارات">
                    <i data-lucide="globe" class="icon icon-sm"></i>
                    <span>إحصائيات الزيارات</span>
                </a>
            </li>

            <li class="shield-nav__item">
                <a href="visit-analytics.php"
                   class="shield-nav__link <?= ($current_page === 'visit-analytics.php') ? 'is-active' : '' ?>"
                   data-label="الرصد والتحليل">
                    <i data-lucide="line-chart" class="icon icon-sm"></i>
                    <span>الرصد والتحليل</span>
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
