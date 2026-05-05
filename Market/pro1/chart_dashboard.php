<?php
// منع إظهار أي أخطاء PHP قد تخرج وتفسد الـ JSON
error_reporting(0);
ini_set('display_errors', 0);

// بدء التخزين المؤقت
ob_start();

require "core.php";

// مسح شامل لكل ما تم طباعته (بما في ذلك الرسالة الخضراء وأكواد الـ Style)
while (ob_get_level() > 0) {
    ob_end_clean();
}

// الآن نبدأ مخرجات جديدة كلياً ونحدد نوعها JSON
header('Content-Type: application/json; charset=utf-8');

$i = 1;
$array_count = array();

// كود جلب البيانات (تأكد أن متغير $mysqli معرف داخل core.php)
if ($mysqli) {
    while ($i <= 12) {
        $date = date('F Y', mktime(0, 0, 0, $i, 1));
        
        $squery = $mysqli->query("SELECT type FROM `psec_logs` WHERE `date` LIKE '%$date' AND `type` = 'SQLi'");
        $array_count['SQLi'][] = ($squery) ? $squery->num_rows : 0;

        $bquery = $mysqli->query("SELECT type FROM `psec_logs` WHERE `date` LIKE '%$date' AND (`type` = 'Bad Bot' OR `type` = 'Fake Bot' OR `type` = 'Missing User-Agent header')");
        $array_count['Bad Bot'][] = ($bquery) ? $bquery->num_rows : 0;
        
        $array_count['Proxies'][] = 0; // تبسيط مؤقت للتأكد من العمل
        $array_count['Spammers'][] = 0;

        $i++;
    }
}

echo json_encode($array_count);
exit();
?>