<?php
$cache_file = __DIR__ . "/cache/ip-details/" . str_replace(":", "-", $ip) . ".json";

// ✅ تحديد الصفحة الحالية
$current_page = basename($_SERVER['PHP_SELF']);

// ✅ صفحات مستثناة (مهم جدًا لمنع loop)
$excluded_pages = [
    'banned.php',
    'banned-country.php',
    'blocked-browser.php',
    'blocked-os.php',
    'blocked-isp.php',
    'blocked-referrer.php'
];

if (in_array($current_page, $excluded_pages)) {
    return;
}

// ✅ تحديد إذا كان localhost
$is_local = ($ip == '127.0.0.1' || $ip == '::1');

// ========================
// 🔴 Ban System
// ========================
if (!$is_local) {
    $querybanned = $mysqli->query("SELECT ip FROM `psec_bans` WHERE ip='$ip' LIMIT 1");

    if ($querybanned && $querybanned->num_rows > 0) {
        header("Location: " . $settings['projectsecurity_path'] . "/pages/banned.php");
        exit;
    }
}

// ========================
// 🔴 IP Range Ban
// ========================
if (!$is_local) {
    $querybanned = $mysqli->query("SELECT ip_range FROM `psec_bans-ranges` WHERE ip_range='$ip_range' LIMIT 1");

    if ($querybanned && $querybanned->num_rows > 0) {
        header("Location: " . $settings['projectsecurity_path'] . "/pages/banned.php");
        exit;
    }
}

// ========================
// 🌍 Country / ISP Check
// ========================
$query1 = $mysqli->query("SELECT * FROM `psec_bans-country`");
$query2 = $mysqli->query("SELECT * FROM `psec_bans-other` WHERE type='isp'");

if ($query1->num_rows > 0 || $query2->num_rows > 0) {

    if (psec_getcache($cache_file) == 'PSEC_NoCache') {
        $url = 'https://ipapi.co/' . $ip . '/json/';
        $ch  = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
            CURLOPT_ENCODING => 'gzip,deflate',
            CURLOPT_USERAGENT => $useragent
        ]);

        $ipcontent = curl_exec($ch);
        curl_close($ch);

        $ip_data = @json_decode($ipcontent);
        @file_put_contents($cache_file, $ipcontent);

    } else {
        $ip_data = @json_decode(psec_getcache($cache_file));
    }

    if ($ip_data && !isset($ip_data->error)) {
        $country_check = $ip_data->country_name ?? "Unknown";
        $isp_check     = $ip_data->org ?? "Unknown";
    } else {
        $country_check = "Unknown";
        $isp_check     = "Unknown";
    }
}

// ========================
// 🌍 Country Ban
// ========================
$querybanned = $mysqli->query("SELECT id FROM `psec_bans-country` WHERE country='$country_check'");

if (!$is_local && $country_check != 'Unknown') {

    if ($settings['countryban_blacklist'] == 1 && $querybanned->num_rows > 0) {
        header("Location: " . $settings['projectsecurity_path'] . "/pages/banned-country.php");
        exit;
    }
}

// ========================
// 🖥️ Browser / OS / ISP / Referrer
// ========================
$checks = [
    ['type' => 'browser',  'value' => $browser,   'page' => 'blocked-browser.php'],
    ['type' => 'os',       'value' => $os,        'page' => 'blocked-os.php'],
    ['type' => 'isp',      'value' => $isp_check, 'page' => 'blocked-isp.php'],
    ['type' => 'referrer', 'value' => $referer ?? '', 'page' => 'blocked-referrer.php']
];

foreach ($checks as $check) {
    $query = $mysqli->query("SELECT value FROM `psec_bans-other` WHERE type='{$check['type']}'");

    while ($row = $query->fetch_assoc()) {
        if (strpos(strtolower($check['value']), strtolower($row['value'])) !== false) {
            if (!$is_local) {
                header("Location: " . $settings['projectsecurity_path'] . "/pages/" . $check['page']);
                exit;
            }
        }
    }
}
?>