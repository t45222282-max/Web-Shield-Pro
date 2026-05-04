<?php
require 'config.php';

// Clear existing logs to have a clean slate for the demo
$mysqli->query("TRUNCATE TABLE `psec_logs`");

$types = ['SQLi', 'Bad Bot', 'Proxy', 'Spammer'];
$countries = ['Saudi Arabia', 'United States', 'Egypt', 'United Kingdom', 'Germany'];
$country_codes = ['sa', 'us', 'eg', 'gb', 'de'];

$current_time = time();

// Generate data for the last 12 months (for the chart)
for ($i = 0; $i < 120; $i++) {
    $random_month_offset = rand(0, 11);
    $timestamp = strtotime("-$random_month_offset months", $current_time);
    
    $date = date('d F Y', $timestamp);
    $time = date('H:i', $timestamp);
    $type = $types[array_rand($types)];
    $country_idx = array_rand($countries);
    $country = $countries[$country_idx];
    $country_code = $country_codes[$country_idx];
    $ip = rand(1,255).'.'.rand(1,255).'.'.rand(1,255).'.'.rand(1,255);
    
    $query = "INSERT INTO `psec_logs` (`ip`, `date`, `time`, `page`, `query`, `type`, `browser`, `browser_code`, `os`, `os_code`, `country`, `country_code`, `region`, `city`, `latitude`, `longitude`, `isp`, `useragent`, `referer_url`) VALUES 
    ('$ip', '$date', '$time', '/index.php', '', '$type', 'Chrome', 'chrome', 'Windows 10', 'windows', '$country', '$country_code', 'Unknown', 'Unknown', '0', '0', 'Unknown', 'Mozilla/5.0...', '')";
    
    $mysqli->query($query);
}

// Generate data specifically for TODAY (for the KPI cards)
$today_date = date('d F Y');
for ($i = 0; $i < 30; $i++) {
    $time = date('H:i');
    $type = $types[array_rand($types)];
    $country_idx = array_rand($countries);
    $country = $countries[$country_idx];
    $country_code = $country_codes[$country_idx];
    $ip = rand(1,255).'.'.rand(1,255).'.'.rand(1,255).'.'.rand(1,255);
    
    $query = "INSERT INTO `psec_logs` (`ip`, `date`, `time`, `page`, `query`, `type`, `browser`, `browser_code`, `os`, `os_code`, `country`, `country_code`, `region`, `city`, `latitude`, `longitude`, `isp`, `useragent`, `referer_url`) VALUES 
    ('$ip', '$today_date', '$time', '/index.php', '', '$type', 'Chrome', 'chrome', 'Windows 10', 'windows', '$country', '$country_code', 'Unknown', 'Unknown', '0', '0', 'Unknown', 'Mozilla/5.0...', '')";
    
    $mysqli->query($query);
}

echo "Successfully populated psec_logs with dummy data.\n";
?>
