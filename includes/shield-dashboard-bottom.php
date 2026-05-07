<?php
// shield-dashboard-bottom.php
// Uses same SQL queries as legacy section — data is identical, only markup differs.
// Per docs/nn/07: variables keep same names, only HTML wrapper changes.

// GeoIP API status
if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $s_api_ua = $_SERVER['HTTP_USER_AGENT'];
} else {
    $s_api_ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36';
}
$s_ch = curl_init();
curl_setopt($s_ch, CURLOPT_URL, 'https://ipapi.co/8.8.8.8/json/');
curl_setopt($s_ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($s_ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($s_ch, CURLOPT_ENCODING, 'gzip,deflate');
curl_setopt($s_ch, CURLOPT_USERAGENT, $s_api_ua);
curl_setopt($s_ch, CURLOPT_REFERER, 'https://ipapi.co');
$s_ipcontent = curl_exec($s_ch);
curl_close($s_ch);
$s_ip_data   = @json_decode($s_ipcontent);
$s_gstatus   = ($s_ip_data && !isset($s_ip_data->{'error'}));

// Proxy API status
$s_proxy_check = 0;
if ($settings['proxy_protection'] > 0 && $settings['proxy_protection'] != 4) {
    $s_apik = 'api' . $settings['proxy_protection'];
    $s_key  = $settings['proxy_' . $s_apik] ?? '';
}
if ($settings['proxy_protection'] == 1) {
    $s_ch2 = curl_init();
    curl_setopt_array($s_ch2, [CURLOPT_URL => 'http://v2.api.iphub.info', CURLOPT_CONNECTTIMEOUT => 10, CURLOPT_RETURNTRANSFER => true]);
    curl_exec($s_ch2);
    $s_proxy_check = (curl_getinfo($s_ch2, CURLINFO_RESPONSE_CODE) >= 200) ? 1 : 0;
    curl_close($s_ch2);
} elseif ($settings['proxy_protection'] == 2) {
    $s_ch2 = curl_init('http://proxycheck.io/v2/8.8.8.8');
    curl_setopt_array($s_ch2, [CURLOPT_CONNECTTIMEOUT => 10, CURLOPT_RETURNTRANSFER => true]);
    curl_exec($s_ch2);
    $s_proxy_check = (curl_getinfo($s_ch2, CURLINFO_RESPONSE_CODE) >= 200) ? 1 : 0;
    curl_close($s_ch2);
} elseif ($settings['proxy_protection'] == 3) {
    $s_ch2 = curl_init('https://www.iphunter.info:8082/v1/ip/8.8.8.8');
    curl_setopt($s_ch2, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($s_ch2, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($s_ch2, CURLOPT_HTTPHEADER, ['X-Key: ' . ($s_key ?? '')]);
    curl_exec($s_ch2);
    $s_proxy_check = (curl_getinfo($s_ch2, CURLINFO_RESPONSE_CODE) >= 200) ? 1 : 0;
    curl_close($s_ch2);
} else {
    $s_proxy_check = -1;
}

// Recent logs
$s_q_logs  = $mysqli->query("SELECT * FROM `psec_logs` ORDER BY id DESC LIMIT 2");
$s_c_logs  = mysqli_num_rows($s_q_logs);

// Recent bans
$s_q_bans  = $mysqli->query("SELECT * FROM `psec_bans` ORDER BY id DESC LIMIT 2");
$s_c_bans  = mysqli_num_rows($s_q_bans);

// Threat stats
$s_c_lt    = mysqli_num_rows($mysqli->query("SELECT id FROM `psec_logs`"));
$s_d_today = date("d F Y");
$s_c_ld    = mysqli_num_rows($mysqli->query("SELECT id FROM `psec_logs` WHERE `date`='$s_d_today'"));
$s_d_mon   = date("F Y");
$s_c_lm    = mysqli_num_rows($mysqli->query("SELECT id FROM `psec_logs` WHERE `date` LIKE '% $s_d_mon'"));
$s_d_yr    = date("Y");
$s_c_ly    = mysqli_num_rows($mysqli->query("SELECT id FROM `psec_logs` WHERE `date` LIKE '% $s_d_yr'"));

// Ban stats
$s_c_bt    = mysqli_num_rows($mysqli->query("SELECT id FROM `psec_bans`"));
$s_c_bd    = mysqli_num_rows($mysqli->query("SELECT id FROM `psec_bans` WHERE `date`='$s_d_today'"));
$s_c_bm    = mysqli_num_rows($mysqli->query("SELECT id FROM `psec_bans` WHERE `date` LIKE '% $s_d_mon'"));
$s_c_by    = mysqli_num_rows($mysqli->query("SELECT id FROM `psec_bans` WHERE `date` LIKE '% $s_d_yr'"));

// Countries list (same as legacy)
$s_countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Antigua and Barbuda","Argentina","Armenia","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Brazil","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Central African Republic","Chad","Chile","China","Colombi","Comoros","Congo (Brazzaville)","Congo","Costa Rica","Cote d'Ivoire","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","East Timor (Timor Timur)","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Fiji","Finland","France","Gabon","Gambia, The","Georgia","Germany","Ghana","Greece","Grenada","Guatemala","Guinea","Guinea-Bissau","Guyana","Haiti","Honduras","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Korea, North","Korea, South","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","New Zealand","Nicaragua","Niger","Nigeria","Norway","Oman","Pakistan","Palau","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Qatar","Romania","Russia","Rwanda","Saint Kitts and Nevis","Saint Lucia","Saint Vincent","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia and Montenegro","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","Spain","Sri Lanka","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Togo","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Yemen","Zambia","Zimbabwe"];
?>

<!-- ── API Status ── -->
<div class="shield-grid shield-grid--2" style="gap:var(--space-4);margin-bottom:var(--space-4);">
    <div class="shield-card">
        <div class="shield-card__body" style="display:flex;align-items:center;gap:var(--space-3);">
            <i data-lucide="globe" class="icon icon-md text-brand"></i>
            <div>
                <div class="txt-body-sm txt-secondary" style="margin-bottom:var(--space-1);">حالة GeoIP API</div>
                <?php if ($s_gstatus): ?>
                    <span class="shield-badge shield-badge--success">متصل</span>
                <?php else: ?>
                    <span class="shield-badge shield-badge--critical">غير متصل</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="shield-card">
        <div class="shield-card__body" style="display:flex;align-items:center;gap:var(--space-3);">
            <i data-lucide="cloud" class="icon icon-md text-brand"></i>
            <div>
                <div class="txt-body-sm txt-secondary" style="margin-bottom:var(--space-1);">حالة Proxy Detection API</div>
                <?php if ($s_proxy_check == 1): ?>
                    <span class="shield-badge shield-badge--success">متصل</span>
                <?php elseif ($s_proxy_check == 0): ?>
                    <span class="shield-badge shield-badge--critical">غير متصل</span>
                <?php else: ?>
                    <span class="shield-badge shield-badge--neutral">معطل</span>
                <?php endif; ?>
            </div>
        </div>
</div>

<!-- ── Threat Statistics Chart ── -->
<div class="shield-card" style="margin-bottom:var(--space-4);">
    <div class="shield-card__header">
        <div style="display:flex;align-items:center;gap:var(--space-2);">
            <i data-lucide="line-chart" class="icon icon-sm text-brand"></i>
            <span class="shield-card__title">إحصائيات التهديدات</span>
        </div>
    </div>
    <div class="shield-card__body">
        <div style="height:350px; position:relative; width:100%;">
            <canvas id="log-stats"></canvas>
        </div>
    </div>
</div>


<!-- ── Recent Activity + Stats ── -->
<div class="shield-grid shield-grid--3" style="gap:var(--space-4);margin-bottom:var(--space-4);">

    <!-- Recent Logs -->
    <div class="shield-card">
        <div class="shield-card__header" style="justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:var(--space-2);">
                <i data-lucide="scroll-text" class="icon icon-sm text-brand"></i>
                <span class="shield-card__title">السجلات الأخيرة</span>
            </div>
            <a href="all-logs.php" class="btn-shield-secondary btn-shield-sm">عرض الكل</a>
        </div>
        <div class="shield-card__body">
            <?php if ($s_c_logs > 0): ?>
                <?php while ($s_row_l = $s_q_logs->fetch_assoc()):
                    $s_badge_cls = match(true) {
                        $s_row_l['type'] === 'SQLi' => 'shield-badge--info',
                        in_array($s_row_l['type'], ['Bad Bot','Fake Bot','Missing User-Agent header','Missing header Accept','Invalid IP Address header']) => 'shield-badge--critical',
                        $s_row_l['type'] === 'Proxy' => 'shield-badge--warning',
                        $s_row_l['type'] === 'Spammer' => 'shield-badge--warning',
                        default => 'shield-badge--neutral'
                    };
                ?>
                <div style="padding:var(--space-3) 0;border-bottom:1px solid var(--border-subtle);">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--space-1);">
                        <span class="txt-body-sm font-medium"><?= $s_row_l['ip'] ?></span>
                        <span class="shield-badge <?= $s_badge_cls ?>"><?= $s_row_l['type'] ?></span>
                    </div>
                    <div class="txt-body-sm txt-secondary" style="margin-bottom:var(--space-2);"><?= $s_row_l['date'] ?> — <?= $s_row_l['time'] ?></div>
                    <div style="display:flex;gap:var(--space-2);">
                        <a href="log-details.php?id=<?= $s_row_l['id'] ?>" class="btn-shield-secondary btn-shield-sm"><i data-lucide="info" class="icon icon-xs"></i> تفاصيل</a>
                        <a href="all-logs.php?delete-id=<?= $s_row_l['id'] ?>" class="btn-shield-secondary btn-shield-sm" style="color:var(--color-critical);border-color:var(--color-critical);"><i data-lucide="trash" class="icon icon-xs"></i></a>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="txt-body-sm txt-secondary" style="text-align:center;padding:var(--space-6);">لا توجد سجلات حديثة</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent IP Bans -->
    <div class="shield-card">
        <div class="shield-card__header" style="justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:var(--space-2);">
                <i data-lucide="ban" class="icon icon-sm text-brand"></i>
                <span class="shield-card__title">عمليات حظر IP الأخيرة</span>
            </div>
            <a href="bans-ip.php" class="btn-shield-secondary btn-shield-sm">عرض الكل</a>
        </div>
        <div class="shield-card__body">
            <?php if ($s_c_bans > 0): ?>
                <?php while ($s_row_b = $s_q_bans->fetch_assoc()): ?>
                <div style="padding:var(--space-3) 0;border-bottom:1px solid var(--border-subtle);">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--space-1);">
                        <span class="txt-body-sm font-medium"><?= $s_row_b['ip'] ?></span>
                        <?php if ($s_row_b['autoban'] == 1): ?>
                            <span class="shield-badge shield-badge--info">تلقائي</span>
                        <?php endif; ?>
                    </div>
                    <div class="txt-body-sm txt-secondary" style="margin-bottom:var(--space-2);"><?= $s_row_b['reason'] ?> — <?= $s_row_b['date'] ?></div>
                    <div style="display:flex;gap:var(--space-2);">
                        <a href="bans-ip.php?edit-id=<?= $s_row_b['id'] ?>" class="btn-shield-secondary btn-shield-sm"><i data-lucide="edit" class="icon icon-xs"></i> تعديل</a>
                        <a href="bans-ip.php?delete-id=<?= $s_row_b['id'] ?>" class="btn-shield-secondary btn-shield-sm" style="color:var(--color-success);border-color:var(--color-success);"><i data-lucide="unlock" class="icon icon-xs"></i> رفع الحظر</a>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="txt-body-sm txt-secondary" style="text-align:center;padding:var(--space-6);">لا توجد عمليات حظر حديثة</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Stats Table -->
    <div class="shield-card">
        <div class="shield-card__header">
            <i data-lucide="bar-chart-2" class="icon icon-sm text-brand"></i>
            <span class="shield-card__title">إحصائيات سريعة</span>
        </div>
        <div class="shield-card__body p-0">
            <table class="shield-table">
                <thead><tr><th colspan="2">سجلات التهديدات</th></tr></thead>
                <tbody>
                    <tr><td>المجموع</td><td class="num"><?= $s_c_lt ?></td></tr>
                    <tr><td>اليوم</td><td class="num"><?= $s_c_ld ?></td></tr>
                    <tr><td>هذا الشهر</td><td class="num"><?= $s_c_lm ?></td></tr>
                    <tr><td>هذا العام</td><td class="num"><?= $s_c_ly ?></td></tr>
                </tbody>
                <thead><tr><th colspan="2">حظر عناوين IP</th></tr></thead>
                <tbody>
                    <tr><td>المجموع</td><td class="num"><?= $s_c_bt ?></td></tr>
                    <tr><td>اليوم</td><td class="num"><?= $s_c_bd ?></td></tr>
                    <tr><td>هذا الشهر</td><td class="num"><?= $s_c_bm ?></td></tr>
                    <tr><td>هذا العام</td><td class="num"><?= $s_c_by ?></td></tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- ── Countries Table ── -->
<div class="shield-card">
    <div class="shield-card__header">
        <i data-lucide="globe-2" class="icon icon-sm text-brand"></i>
        <span class="shield-card__title">التهديدات حسب البلد</span>
    </div>
    <div class="shield-card__body p-0">
        <div class="shield-table-wrapper">
            <table class="shield-table" id="dt-basic" width="100%">
                <thead>
                    <tr>
                        <th><i data-lucide="globe" class="icon icon-xs"></i> الدولة</th>
                        <th><i data-lucide="bug" class="icon icon-xs"></i> التهديدات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($s_countries as $s_country):
                        $s_lr      = $mysqli->query("SELECT * FROM `psec_logs` WHERE `country` LIKE '%$s_country%'");
                        $s_lr_rows = mysqli_num_rows($s_lr);
                        $s_lr_row  = mysqli_fetch_assoc($s_lr);
                        if ($s_lr_rows > 0): ?>
                        <tr>
                            <td data-label="الدولة">
                                <img src="assets/plugins/flags/blank.png" class="flag flag-<?= strtolower($s_lr_row['country_code']) ?>"/>
                                &nbsp;<?= $s_country ?>
                            </td>
                            <td data-label="التهديدات" class="num"><?= $s_lr_rows ?></td>
                        </tr>
                    <?php endif; endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


