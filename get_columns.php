<?php
require 'config.php';
$result = $mysqli->query("DESCRIBE `psec_logs`");
while ($row = $result->fetch_assoc()) {
    echo $row['Field'] . "\n";
}
?>
