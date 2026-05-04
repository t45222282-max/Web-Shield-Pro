<?php
include "core.php";
include "../config_settings.php";
head();

$database_host     = $_SESSION['database_host'];
$database_username = $_SESSION['database_username'];
$database_password = $_SESSION['database_password'];
$database_name     = $_SESSION['database_name'];

if (isset($_SERVER['HTTPS'])) {
    $htp = 'https';
} else {
    $htp = 'http';
}
$settings['site_url']             = $htp . '://' . $_SERVER['SERVER_NAME'];
$fullpath                         = "$htp://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$settings['projectsecurity_path'] = substr($fullpath, 0, strpos($fullpath, '/install'));
$settings['sqli_redirect']        = $settings['projectsecurity_path'] . '/pages/blocked.php';
$settings['proxy_redirect']       = $settings['projectsecurity_path'] . '/pages/proxy.php';
$settings['spam_redirect']        = $settings['projectsecurity_path'] . '/pages/spammer.php';
$settings['username']             = $_SESSION['username'];
$settings['password']             = hash('sha256', $_SESSION['password']);

file_put_contents('../config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');

@$db = new mysqli($database_host, $database_username, $database_password, $database_name);
if ($db) {
    
    //Importing SQL Tables
    $query = '';
    
    $sql_dump = file('database.sql');
    
    foreach ($sql_dump as $line) {
        
        $startWith = substr(trim($line), 0, 2);
        $endWith   = substr(trim($line), -1, 1);
        
        if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
            continue;
        }
        
        $query = $query . $line;
        if ($endWith == ';') {
            mysqli_query($db, $query) or die('مشكلة في تنفيذ استعلام SQL <b>' . $query . '</b>');
            $query = '';
        }
    }
    
    // Config file creating and writing information
    $config_file = file_get_contents(CONFIG_FILE_TEMPLATE);
    $config_file = str_replace("<DB_HOST>", $database_host, $config_file);
    $config_file = str_replace("<DB_NAME>", $database_name, $config_file);
    $config_file = str_replace("<DB_USER>", $database_username, $config_file);
    $config_file = str_replace("<DB_PASSWORD>", $database_password, $config_file);

    @chmod(CONFIG_FILE_PATH, 0777);
    @$f = fopen(CONFIG_FILE_PATH, "w+");
    if (!fwrite($f, $config_file) > 0) {
        echo 'لا يمكن فتح ملف الإعدادات لحفظ المعلومات';
    }
    fclose($f);

} else {
    echo 'خطأ في إنشاء اتصال بقاعدة البيانات. يرجى التحقق من معلمات اتصال قاعدة البيانات.<br />';
}
?>
<center>
<div class="alert alert-success">
  تم تثبيت درع الويب بنجاح على موقعك الإلكتروني!
</div>
    
<div class="alert alert-warning">
	لأسباب أمن kitten، يرجى إزالة مجلد <b>install/</b> من خادومك!
</div>
    
<div class="alert alert-info"> 
<b>ضع كود التكامل في الجزء العلوي (أو السفلي) من ملف <i>.php</i> رئيسي واحد في موقعك الإلكتروني لدمجه مع مشروع الأمان</b><br />
(<b>أمثلة</b>: <i>ملف index.php؛ ملف إعدادات قاعدة البيانات (الاتصال)؛ ملف الدوال؛ ملف الهيدر؛ ملف أساسي يتم تضمينه في جميع ملفات .php الأخرى.</i>)
<br /><br />
	<kbd>
	    include "security/config.php";<br />
	    include "security/project-security.php";
	</kbd>
</div>
    
<a href="../" class="btn-success btn col-12"><i class="fas fa-arrow-circle-right"></i> المتابعة إلى درع الويب</a><br /><br />
</center>
<?php
footer();
?>