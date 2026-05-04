<?php
require 'config.php';

// Clear existing bans
$mysqli->query("TRUNCATE TABLE `psec_bans`");

$reasons = ['Malicious IP', 'Spamming', 'SQL Injection Attempt', 'Brute Force Attack'];
$today_date = date('d F Y');
$time = date('H:i');

for ($i = 0; $i < 5; $i++) {
    $ip = rand(1,255).'.'.rand(1,255).'.'.rand(1,255).'.'.rand(1,255);
    $reason = $reasons[array_rand($reasons)];
    $autoban = rand(0, 1);
    
    $query = "INSERT INTO `psec_bans` (`ip`, `date`, `time`, `reason`, `redirect`, `url`, `autoban`) VALUES 
    ('$ip', '$today_date', '$time', '$reason', 0, '', $autoban)";
    
    $mysqli->query($query);
}

echo "Successfully populated psec_bans with dummy data.\n";
?>
