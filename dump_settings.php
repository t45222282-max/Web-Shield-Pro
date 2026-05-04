<?php
require 'config.php';
$query = $mysqli->query("SELECT * FROM `psec_settings`");
$row = $query->fetch_assoc();
echo "ui_engine: " . $row['ui_engine'] . "\n";
echo "ui_theme: " . $row['ui_theme'] . "\n";
?>
