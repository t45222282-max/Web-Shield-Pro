<?php
require "core.php";
head();

date_default_timezone_set('Asia/Riyadh');

//Clean URL
function clean_url($site)
{
    $site = strtolower($site);
    $site = str_replace(array(
        'http://',
        'https://',
        'www.'
    ), '', $site);
    return $site;
}

$site = clean_url($settings['site_url']);
?>
<div class="content-wrapper">

<!--حاوية المحتوى-->
<!--===================================================-->
<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>
    <header class="shield-page-header">
        <div class="shield-page-header__main" style="text-align: right;">
            <h1 class="txt-h1 neon-text-info" style="font-size: 2.8em; margin-bottom: 10px;">معلومات النظام</h1>
            <p class="txt-body-sm txt-secondary" style="font-size: 1.2em;">نظرة عامة على حالة الخادم، استهلاك الموارد، وبيانات المضيف.</p>
        </div>
    </header>

    <div class="content">
        <div class="container-fluid">
            
<?php
//فحص معلومات المضيف
function host_info($site)
{
if (isset($_SERVER['HTTP_USER_AGENT'])) {
$api_useragent = $_SERVER['HTTP_USER_AGENT'];
} else {
$api_useragent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118';
}

$ip  = getHostByName(getHostName());
$url = 'https://ipapi.co/' . $ip . '/json/';
$ch  = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
curl_setopt($ch, CURLOPT_USERAGENT, $api_useragent);
@curl_setopt($ch, CURLOPT_REFERER, "https://ipapi.co");
@$ipcontent = curl_exec($ch);
curl_close($ch);

$ip_data = @json_decode($ipcontent);
if ($ip_data && !isset($ip_data->{'error'})) {
$country = $ip_data->{'country_name'};
$isp     = $ip_data->{'org'};
} else {
$country = "غير معروف";
$isp     = "غير معروف";
}

if ($country == '') {
$country = "غير معروف";
}

if ($isp == '') {
$isp = "غير معروف";
}

$data = $ip . "::" . $country . "::" . $isp . "::";
return $data;
}

// زمن الاستجابة
$ch_resptime = curl_init($settings['site_url']);
curl_setopt($ch_resptime, CURLOPT_RETURNTRANSFER,1);
if(curl_exec($ch_resptime)) {

$curl_resptime = curl_getinfo($ch_resptime);
$response_time = $curl_resptime['total_time'];
} else {
$response_time = 0.01;
}

//معلومات المضيف
$data         = host_info($site);
$data         = explode("::", $data);
$host_ip      = $data[0];
$serverip     = getHostByName(getHostName());
$host_country = $data[1];
$host_isp     = $data[2];

$inipath = php_ini_loaded_file();

if ($inipath) {
$iniflp = $inipath;
} else {
$iniflp = 'لم يتم تحميل ملف php.ini';
}

$zend_version = zend_version();

$errorlog_path = ini_get('error_log');
?>
            
            <div class="shield-grid shield-grid--2" style="margin-bottom: var(--space-6);">
                <div class="shield-card shield-stats-card">
                    <div class="shield-card__header shield-stats-row" style="justify-content: flex-start; padding: 15px 20px; flex-direction: row-reverse;">
                        <i class="fas fa-server" style="color: #6B7587; margin-right: 10px; font-size: 1.2em;"></i>
                        <span class="shield-card__title" style="font-size: 1.2em;">إحصائيات الموقع (<?php echo $site; ?>)</span>
                    </div>
                    <div class="shield-card__body p-0">
                        <div style="display: flex; flex-direction: column;">
                            <div class="shield-stats-row" style="display: flex; align-items: center; justify-content: space-between; padding: 12px 20px;">
                                <div class="neon-host-title" style="flex: 1; text-align: right; font-size: 1.1em;">زمن الاستجابة</div>
                                <div class="shield-stats-val" style="flex: 2; text-align: center; font-family: monospace; padding: 6px 10px; border-radius: 6px; margin: 0 15px; font-size: 1.1em;"><?php echo $response_time; ?>s</div>
                                <div style="width: 30px; text-align: left; color: #6B7587;"><i class="fas fa-clock" style="font-size: 1.2em;"></i></div>
                            </div>
                            <div class="shield-stats-row" style="display: flex; align-items: center; justify-content: space-between; padding: 12px 20px;">
                                <div class="neon-host-title" style="flex: 1; text-align: right; font-size: 1.1em;">ملف تكوين PHP</div>
                                <div class="shield-stats-val" style="flex: 2; text-align: center; font-family: monospace; padding: 6px 10px; border-radius: 6px; margin: 0 15px; font-size: 1.1em;"><?php echo $iniflp; ?></div>
                                <div style="width: 30px; text-align: left; color: #6B7587;"><i class="fas fa-file-code" style="font-size: 1.2em;"></i></div>
                            </div>
                            <div class="shield-stats-row" style="display: flex; align-items: center; justify-content: space-between; padding: 12px 20px;">
                                <div class="neon-host-title" style="flex: 1; text-align: right; font-size: 1.1em;">سجل اخطاء PHP</div>
                                <div class="shield-stats-val" style="flex: 2; text-align: center; font-family: monospace; padding: 6px 10px; border-radius: 6px; margin: 0 15px; font-size: 1.1em;"><?php echo $errorlog_path; ?></div>
                                <div style="width: 30px; text-align: left; color: #6B7587;"><i class="fas fa-file-alt" style="font-size: 1.2em;"></i></div>
                            </div>
                            <div class="shield-stats-row" style="display: flex; align-items: center; justify-content: space-between; padding: 12px 20px;">
                                <div class="neon-host-title" style="flex: 1; text-align: right; font-size: 1.1em;">إصدار Zend</div>
                                <div class="shield-stats-val" style="flex: 2; text-align: center; font-family: monospace; padding: 6px 10px; border-radius: 6px; margin: 0 15px; font-size: 1.1em;"><?php echo $zend_version; ?></div>
                                <div style="width: 30px; text-align: left; color: #6B7587;"><i class="fas fa-code-branch" style="font-size: 1.2em;"></i></div>
                            </div>
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 20px;">
                                <div class="neon-host-title" style="flex: 1; text-align: right; font-size: 1.1em;">المنطقة الجغرافية</div>
                                <div class="shield-stats-val" style="flex: 2; text-align: center; font-family: monospace; padding: 6px 10px; border-radius: 6px; margin: 0 15px; font-size: 1.1em;"><?php echo date_default_timezone_get(); ?></div>
                                <div style="width: 30px; text-align: left; color: #6B7587;"><i class="fas fa-globe" style="font-size: 1.2em;"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <div class="shield-card shield-stats-card neon-border-info" style="margin-bottom: var(--space-6);">
                        <div class="shield-card__header shield-stats-row" style="justify-content: flex-start; padding: 15px 30px; flex-direction: row-reverse;">
                            <i class="fas fa-hdd" style="color: #A3ACBD; margin-right: 10px; font-size: 1.2em;"></i>
                            <span class="shield-card__title" style="font-size: 1.3em;">مساحة التخزين</span>
                        </div>
                        <div class="shield-card__body" style="padding: 40px 30px;">
<?php
if (!function_exists("view_size")) {
function view_size($size)
{
if (!is_numeric($size)) {
return FALSE;
} else {
if ($size >= 1073741824) {
    $size = round($size / 1073741824 * 100) / 100 . " جيجابايت";
} elseif ($size >= 1048576) {
    $size = round($size / 1048576 * 100) / 100 . " ميجابايت";
} elseif ($size >= 1024) {
    $size = round($size / 1024 * 100) / 100 . " كيلوبايت";
} else {
    $size = $size . " بايت";
}
return $size;
}
}
}

if (is_callable("disk_free_space") && is_callable("disk_total_space")) {
$directory = '/';

@$total = disk_total_space($directory);
@$free = disk_free_space($directory);

if ($total === FALSE || $total <= 0) {
$total = 0;
}
if ($free === FALSE || $free < 0) {
$free = 0;
}

@$used = $total - $free;
@$free_percent = round(100 / ($total / $free), 2);
@$used_percent = round(100 / ($total / $used), 2);
?>
                            <div style="display: flex; align-items: center; gap: 50px; direction: rtl;">
                                <div style="flex: 1; display: flex; flex-direction: column; justify-content: center;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                                        <span class="neon-host-title" style="font-size: 1.4em;">الإجمالي: <?php echo view_size($total); ?></span>
                                        <span class="neon-host-title" style="font-size: 1.4em;">المستخدم: <?php echo view_size($used); ?></span>
                                    </div>
                                    <div class="shield-stats-val" style="width: 100%; height: 16px; border-radius: 8px; overflow: hidden; margin-bottom: 20px; box-shadow: inset 0 2px 5px rgba(0,0,0,0.2);">
                                        <div style="height: 100%; width: <?php echo $used_percent; ?>%; background: linear-gradient(270deg, #8B5CF6, #00B8E6); border-radius: 8px; box-shadow: 0 0 10px rgba(0, 184, 230, 0.8);"></div>
                                    </div>
                                    <div class="neon-host-title" style="font-size: 1.3em; text-align: right;">المستخدم: <?php echo view_size($used); ?> (<?php echo $used_percent; ?>%)</div>
                                </div>
                                <div style="width: 180px; height: 180px; border-radius: 50%; background: conic-gradient(#00B8E6 <?php echo $used_percent; ?>%, rgba(0,0,0,0.1) 0); display: flex; align-items: center; justify-content: center; box-shadow: 0 0 15px rgba(0, 184, 230, 0.2), inset 0 0 15px rgba(0, 184, 230, 0.2);">
                                    <div class="shield-storage-circle" style="width: 140px; height: 140px; border-radius: 50%;"></div>
                                </div>
                            </div>
<?php
} else {
echo '<p class="txt-body-sm txt-secondary" style="font-size: 1.2em;"><i>هذه الميزة غير متوفرة على هذا المضيف.</i></p>';   
}
?>
                        </div>
                    </div>
                </div>
            </div>
            
            <h2 class="txt-h2 neon-text-info" style="margin-bottom: 25px; font-size: 2.2em; text-align: right; text-shadow: 0 0 15px rgba(0, 184, 230, 0.6); color: #00B8E6;">معلومات المضيف</h2>
            
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 40px; direction: rtl;">
                
                <!-- Row 1 -->
                <div class="neon-host-card neon-border-info" style="padding: 30px 15px; text-align: center; transition: transform 0.3s ease;">
                    <i data-lucide="fingerprint" class="neon-icon-info neon-icon-animated micro-anim-fingerprint" style="width: 56px; height: 56px; margin: 0 auto 20px;"></i>
                    <div class="neon-host-title" style="font-size: 1.1em; margin-bottom: 10px;">عنوان IP للنطاق</div>
                    <div class="neon-host-val" style="font-size: 1.4em; font-weight: bold; font-family: monospace;"><?php echo $serverip; ?></div>
                </div>
                
                <div class="neon-host-card neon-border-purple" style="padding: 30px 15px; text-align: center; transition: transform 0.3s ease;">
                    <i data-lucide="globe" class="neon-icon-purple neon-icon-animated micro-anim-globe" style="width: 56px; height: 56px; margin: 0 auto 20px;"></i>
                    <div class="neon-host-title" style="font-size: 1.1em; margin-bottom: 10px;">الدولة</div>
                    <div class="neon-host-val" style="font-size: 1.4em; font-weight: bold;"><?php echo $host_country; ?></div>
                </div>
                
                <div class="neon-host-card neon-border-info" style="padding: 30px 15px; text-align: center; transition: transform 0.3s ease;">
                    <i data-lucide="server" class="neon-icon-info neon-icon-animated micro-anim-server" style="width: 56px; height: 56px; margin: 0 auto 20px;"></i>
                    <div class="neon-host-title" style="font-size: 1.1em; margin-bottom: 10px;">برمجيات الخادم</div>
                    <div class="neon-host-val" style="font-size: 1.4em; font-weight: bold;"><?php @$version = explode("/", $_SERVER['SERVER_SOFTWARE']); @$softNum = explode(" ", $version[1]); @$soft = $version[0] . '/' . $softNum[0]; echo $soft; ?></div>
                </div>
                
                <div class="neon-host-card neon-border-info" style="padding: 30px 15px; text-align: center; transition: transform 0.3s ease;">
                    <i data-lucide="network" class="neon-icon-info neon-icon-animated micro-anim-network" style="width: 56px; height: 56px; margin: 0 auto 20px;"></i>
                    <div class="neon-host-title" style="font-size: 1.1em; margin-bottom: 10px;">مزود الخدمة</div>
                    <div class="neon-host-val" style="font-size: 1.4em; font-weight: bold;"><?php echo $host_isp; ?></div>
                </div>
                
                <!-- Row 2 -->
                <div class="neon-host-card neon-border-info" style="padding: 30px 15px; text-align: center; transition: transform 0.3s ease;">
                    <i data-lucide="terminal" class="neon-icon-info neon-icon-animated micro-anim-terminal" style="width: 56px; height: 56px; margin: 0 auto 20px;"></i>
                    <div class="neon-host-title" style="font-size: 1.1em; margin-bottom: 10px;">نظام تشغيل الخادم</div>
                    <div class="neon-host-val" style="font-size: 1.4em; font-weight: bold;">
<?php
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') { echo 'ويندوز'; } elseif (PHP_OS === 'Linux') { echo 'لينكس'; } elseif (PHP_OS === 'FreeBSD') { echo 'فري بي إس دي'; } elseif (PHP_OS === 'OpenBSD') { echo 'أوبن بي إس دي'; } elseif (PHP_OS === 'NetBSD') { echo 'نت بي إس دي'; } elseif (PHP_OS === 'SunOS') { echo 'سون أو إس'; } elseif (PHP_OS === 'Unix') { echo 'يونكس'; } elseif (PHP_OS === 'Darwin') { echo 'داروين'; } elseif (PHP_OS === 'HP-UX') { echo 'إتش بي-يو إكس'; } elseif (PHP_OS === 'IRIX64') { echo 'إيريكس64'; } elseif (PHP_OS === 'CYGWIN_NT-5.1') { echo 'سيجوين'; } elseif (PHP_OS === 'GNU') { echo 'جنو'; } elseif (PHP_OS === 'DragonFly') { echo 'دراجون فلاي'; } elseif (PHP_OS === 'MSYS_NT-6.1') { echo 'إم إس واي إس'; } else { echo 'غير معروف'; }
?>
                    </div>
                </div>
                
                <div class="neon-host-card neon-border-info" style="padding: 30px 15px; text-align: center; transition: transform 0.3s ease;">
                    <i data-lucide="cpu" class="neon-icon-info neon-icon-animated micro-anim-cpu" style="width: 56px; height: 56px; margin: 0 auto 20px;"></i>
                    <div class="neon-host-title" style="font-size: 1.1em; margin-bottom: 10px;">إصدار PHP</div>
                    <div class="neon-host-val" style="font-size: 1.4em; font-weight: bold;"><?php echo phpversion(); ?></div>
                </div>
                
                <div class="neon-host-card neon-border-purple" style="padding: 30px 15px; text-align: center; transition: transform 0.3s ease;">
                    <i data-lucide="database" class="neon-icon-purple neon-icon-animated micro-anim-database" style="width: 56px; height: 56px; margin: 0 auto 20px;"></i>
                    <div class="neon-host-title" style="font-size: 1.1em; margin-bottom: 10px;">إصدار MySQL</div>
                    <div class="neon-host-val" style="font-size: 1.4em; font-weight: bold;"><?php echo mysqli_get_server_info($mysqli); ?></div>
                </div>
                
                <div class="neon-host-card neon-border-purple" style="padding: 30px 15px; text-align: center; transition: transform 0.3s ease;">
                    <i data-lucide="plug-zap" class="neon-icon-purple neon-icon-animated micro-anim-zap" style="width: 56px; height: 56px; margin: 0 auto 20px;"></i>
                    <div class="neon-host-title" style="font-size: 1.1em; margin-bottom: 10px;">منفذ الخادم</div>
                    <div class="neon-host-val" style="font-size: 1.4em; font-weight: bold; font-family: monospace;"><?php echo $_SERVER['SERVER_PORT']; ?></div>
                </div>
                
                <!-- Row 3 -->
                <div class="neon-host-card neon-border-info" style="padding: 30px 15px; text-align: center; transition: transform 0.3s ease;">
                    <i data-lucide="layout-dashboard" class="neon-icon-info neon-icon-animated micro-anim-dashboard" style="width: 56px; height: 56px; margin: 0 auto 20px;"></i>
                    <div class="neon-host-title" style="font-size: 1.1em; margin-bottom: 10px;">واجهة البوابة</div>
                    <div class="neon-host-val" style="font-size: 1.4em; font-weight: bold;"><?php echo @$_SERVER['GATEWAY_INTERFACE']; ?></div>
                </div>
                
                <div class="neon-host-card neon-border-purple" style="padding: 30px 15px; text-align: center; transition: transform 0.3s ease;">
                    <i data-lucide="cable" class="neon-icon-purple neon-icon-animated micro-anim-cable" style="width: 56px; height: 56px; margin: 0 auto 20px;"></i>
                    <div class="neon-host-title" style="font-size: 1.1em; margin-bottom: 10px;">بروتوكول HTTP</div>
                    <div class="neon-host-val" style="font-size: 1.4em; font-weight: bold;"><?php echo $_SERVER['SERVER_PROTOCOL']; ?></div>
                </div>
                
                <div class="neon-host-card neon-border-pink" style="padding: 30px 15px; text-align: center; transition: transform 0.3s ease;">
                    <i data-lucide="activity" class="neon-icon-pink neon-icon-animated micro-anim-activity" style="width: 56px; height: 56px; margin: 0 auto 20px;"></i>
                    <div class="neon-host-title" style="font-size: 1.1em; margin-bottom: 10px;">امتداد cURL</div>
                    <div class="neon-host-val" style="font-size: 1.4em; font-weight: bold;">
<?php
if (function_exists('curl_version')) { $values = curl_version(); echo $values["version"]; } else { echo '<span class="text-critical">معطل</span>'; }
?>
                    </div>
                </div>
                
                <div class="neon-host-card neon-border-info" style="padding: 30px 15px; text-align: center; transition: transform 0.3s ease;">
                    <i data-lucide="lock" class="neon-icon-info neon-icon-animated micro-anim-lock" style="width: 56px; height: 56px; margin: 0 auto 20px;"></i>
                    <div class="neon-host-title" style="font-size: 1.1em; margin-bottom: 10px;">إصدار OpenSSL</div>
                    <div class="neon-host-val" style="font-size: 1.4em; font-weight: bold;">
<?php
if (!extension_loaded('openssl')) { echo '<span class="text-critical">معطل</span>'; } else { echo str_replace("OpenSSL", "", OPENSSL_VERSION_TEXT); }
?>
                    </div>
                </div>

            </div>
            
        </div>
    </div>
<?php else: ?>
<div class="content-header">
	
	<div class="container-fluid">
	  <div class="row mb-2">
		<div class="col-sm-6">
		  <h1 class="m-0"><i class="fas fa-info-circle"></i> معلومات النظام</h1>
		</div>
		<div class="col-sm-6">
		  <ol class="breadcrumb float-sm-right">
			<li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> لوحة الإدارة</a></li>
			<li class="breadcrumb-item active">معلومات النظام</li>
		  </ol>
		</div>
	  </div>
	</div>
</div>

	<!--محتوى الصفحة-->
	<!--===================================================-->
	<div class="content">
	<div class="container-fluid">

<?php
//فحص معلومات المضيف
function host_info($site)
{
if (isset($_SERVER['HTTP_USER_AGENT'])) {
$api_useragent = $_SERVER['HTTP_USER_AGENT'];
} else {
$api_useragent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118';
}

$ip  = getHostByName(getHostName());
$url = 'https://ipapi.co/' . $ip . '/json/';
$ch  = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
curl_setopt($ch, CURLOPT_USERAGENT, $api_useragent);
@curl_setopt($ch, CURLOPT_REFERER, "https://ipapi.co");
@$ipcontent = curl_exec($ch);
curl_close($ch);

$ip_data = @json_decode($ipcontent);
if ($ip_data && !isset($ip_data->{'error'})) {
$country = $ip_data->{'country_name'};
$isp     = $ip_data->{'org'};
} else {
$country = "غير معروف";
$isp     = "غير معروف";
}

if ($country == '') {
$country = "غير معروف";
}

if ($isp == '') {
$isp = "غير معروف";
}

$data = $ip . "::" . $country . "::" . $isp . "::";
return $data;
}

// زمن الاستجابة
$ch_resptime = curl_init($settings['site_url']);
curl_setopt($ch_resptime, CURLOPT_RETURNTRANSFER,1);
if(curl_exec($ch_resptime)) {

$curl_resptime = curl_getinfo($ch_resptime);
$response_time = $curl_resptime['total_time'];
} else {
$response_time = 0.01;
}

//معلومات المضيف
$data         = host_info($site);
$data         = explode("::", $data);
$host_ip      = $data[0];
$serverip     = getHostByName(getHostName());
$host_country = $data[1];
$host_isp     = $data[2];

$inipath = php_ini_loaded_file();

if ($inipath) {
$iniflp = $inipath;
} else {
$iniflp = 'لم يتم تحميل ملف php.ini';
}

$zend_version = zend_version();

$errorlog_path = ini_get('error_log');
?>
		
	<div class="row">
	<div class="col-md-6">
		  <div class="shield-card">
				<div class="shield-card">
					<h3 class="shield-card"><?php
echo $site;
?></h3>
				</div>
				<div class="shield-card">
				<div class="shield-table">
						<table class="shield-table">
									<thead class="<?php echo $thead; ?>">
										<tr>
											<th>إحصائيات ومعلومات الموقع</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>زمن الاستجابة</td>
											<td><h5><span class="badge badge-success"><?php
echo $response_time;
?> ثانية</span></h5></td>
										</tr>
										<tr>
											<td>ملف تكوين PHP (php.ini)</td>
											<td><h5><span class="badge badge-warning"><?php
echo $iniflp;
?></span></h5></td>
										</tr>
										<tr>
											<td>سجل أخطاء PHP</td>
											<td><h5><span class="badge badge-warning"><?php
echo $errorlog_path;
?></span></h5></td>
										</tr>
										<tr>
											<td>إصدار Zend</td>
											<td><h5><span class="badge badge-danger"><?php
echo $zend_version;
?></span></h5></td>
										</tr>
										<tr>
											<td>المنطقة الزمنية الافتراضية</td>
											<td><h5><span class="badge badge-primary"><?php
echo date_default_timezone_get();
?></span></h5></td>
										</tr>
									</tbody>
						 </table>
				</div>
				</div>
		  </div>
		

 
			<div class="col-md-12">
				<div class="info-box bg-info">
					<span class="info-box-icon"><i class="fas fa-hdd"></i></span>

					<div class="info-box-content shield-info-box__content">
						<span class="info-box-text">التخزين</span>
<?php
if (!function_exists("view_size")) {
function view_size($size)
{
if (!is_numeric($size)) {
return FALSE;
} else {
if ($size >= 1073741824) {
	$size = round($size / 1073741824 * 100) / 100 . " جيجابايت";
} elseif ($size >= 1048576) {
	$size = round($size / 1048576 * 100) / 100 . " ميجابايت";
} elseif ($size >= 1024) {
	$size = round($size / 1024 * 100) / 100 . " كيلوبايت";
} else {
	$size = $size . " بايت";
}
return $size;
}
}
}

if (is_callable("disk_free_space") && is_callable("disk_total_space")) {
$directory = '/';

@$total = disk_total_space($directory);
@$free = disk_free_space($directory);

if ($total === FALSE || $total <= 0) {
$total = 0;
}
if ($free === FALSE || $free < 0) {
$free = 0;
}

@$used = $total - $free;
@$free_percent = round(100 / ($total / $free), 2);
@$used_percent = round(100 / ($total / $used), 2);
?>
		  
					 <span class="info-box-number">الإجمالي: <?php
echo view_size($total);
?></span>

					 <div class="progress">
					   <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: <?php
echo $used_percent;
?>%"></div>
					 </div>
						 <span class="progress-description">
							 المستخدم: <span class="text-semibold"><?php
echo view_size($used);
?> (<?php
echo $used_percent;
?>%)</span>
						 </span>
<?php
} else {
echo '<i>هذه الميزة غير متوفرة على هذا المضيف.</i>';	
}
?>
					</div>
				</div>
			</div>
		</div>
	   <br />
</div>
	
	<div class="col-md-6">
</ul></pre>
		</div>
	</div>
		
	</div>
	
	<br /><br />
	
	<div class="col-md-12">
		<h3 class="mt-none">معلومات المضيف</h3>
		<p>معلومات النظام حول مضيف الويب.</p>
		
		<div class="row">
		   <div class="col-md-3">
				<div class="shield-card">
					<div class="shield-card">
						<p class="text-uppercase mar-btm text-sm" class="font20">عنوان IP للنطاق</p>
						<i class="fas fa-user fa-3x"></i>
						<hr />
						<p class="h4 text-thin"><?php
echo $serverip;
?></p>
					</div>
				</div>
		   </div>
		
		   <div class="col-md-3">
				<div class="shield-card">
					<div class="shield-card">
						<p class="text-uppercase mar-btm text-sm" class="font20">الدولة</p>
						<i class="fas fa-globe fa-3x"></i>
						<hr />
						<p class="h4 text-thin"><?php
echo $host_country;
?></p>
					</div>
				</div>
		   </div>

		   <div class="col-md-3">
				<div class="shield-card">
					<div class="shield-card">
						<p class="text-uppercase mar-btm text-sm" class="font20">برمجيات الخادم</p>
						<i class="fas fa-database fa-3x"></i>
						<hr />
						<p class="h4 text-thin">
<?php
@$version = explode("/", $_SERVER['SERVER_SOFTWARE']);
@$softNum = explode(" ", $version[1]);
@$soft = $version[0] . '/' . $softNum[0];
echo $soft;
?>
						</p>
					</div>
				</div>
		   </div>
		
		   <div class="col-md-3">
				<div class="shield-card">
					<div class="shield-card">
						<p class="text-uppercase mar-btm text-sm" class="font20">مزود الخدمة</p>
						<i class="fas fa-tasks fa-3x"></i>
						<hr />
						<p class="h4 text-thin"><?php
echo $host_isp;
?></p>
					</div>
				</div>
		   </div>
		</div>
		
		<div class="row">
		   <div class="col-md-3">
				<div class="shield-card">
					<div class="shield-card">
						<p class="text-uppercase mar-btm text-sm" class="font20">نظام تشغيل الخادم</p>
						<i class="fas fa-desktop fa-3x"></i>
						<hr />
						<p class="h4 text-thin">
<?php
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
echo 'ويندوز';
} elseif (PHP_OS === 'Linux') {
echo 'لينكس';
} elseif (PHP_OS === 'FreeBSD') {
echo 'فري بي إس دي';
} elseif (PHP_OS === 'OpenBSD') {
echo 'أوبن بي إس دي';
} elseif (PHP_OS === 'NetBSD') {
echo 'نت بي إس دي';
} elseif (PHP_OS === 'SunOS') {
echo 'سون أو إس';
} elseif (PHP_OS === 'Unix') {
echo 'يونكس';
} elseif (PHP_OS === 'Darwin') {
echo 'داروين';
} elseif (PHP_OS === 'HP-UX') {
echo 'إتش بي-يو إكس';
} elseif (PHP_OS === 'IRIX64') {
echo 'إيريكس64';
} elseif (PHP_OS === 'CYGWIN_NT-5.1') {
echo 'سيجوين';
} elseif (PHP_OS === 'GNU') {
echo 'جنو';
} elseif (PHP_OS === 'DragonFly') {
echo 'دراجون فلاي';
} elseif (PHP_OS === 'MSYS_NT-6.1') {
echo 'إم إس واي إس';
} else {
echo 'غير معروف';
}
?>                                    
						</p>
					</div>
				</div>
		   </div>
		   
		   <div class="col-md-3">
				<div class="shield-card">
					<div class="shield-card">
						<p class="text-uppercase mar-btm text-sm" class="font20">إصدار PHP</p>
						<i class="fas fa-file-code fa-3x"></i>
						<hr />
						<p class="h4 text-thin"><?php
echo phpversion();
?></p>
					</div>
				</div>
		   </div>
		
		   <div class="col-md-3">
				<div class="shield-card">
					<div class="shield-card">
						<p class="text-uppercase mar-btm text-sm" class="font20">إصدار MySQL</p>
						<i class="fas fa-list-alt fa-3x"></i>
						<hr />
						<p class="h4 text-thin"><?php
echo mysqli_get_server_info($mysqli);
?></p>
					</div>
				</div>
		   </div>
		
		   <div class="col-md-3">
				<div class="shield-card">
					<div class="shield-card">
						<p class="text-uppercase mar-btm text-sm" class="font20">منفذ الخادم</p>
						<i class="fas fa-plug fa-3x"></i>
						<hr />
						<p class="h4 text-thin"><?php
echo $_SERVER['SERVER_PORT'];
?></p>
					</div>
				</div>
		   </div>
		</div>
		
		<div class="row">
		   <div class="col-md-3">
				<div class="shield-card">
					<div class="shield-card">
						<p class="text-uppercase mar-btm text-sm" class="font20">إصدار OpenSSL</p>
						<i class="fas fa-lock fa-3x"></i>
						<hr />
						<p class="h4 text-thin">
<?php
if (!extension_loaded('openssl')) {
echo '<font style="color: red;">معطل</font>';
} else {
echo str_replace("OpenSSL", "", OPENSSL_VERSION_TEXT);
}
?></p>
					</div>
				</div>
		   </div>
		
		   <div class="col-md-3">
				<div class="shield-card">
					<div class="shield-card">
						<p class="text-uppercase mar-btm text-sm" class="font20">امتداد cURL</p>
						<i class="fas fa-link fa-3x"></i>
						<hr />
						<p class="h4 text-thin">
<?php
if (function_exists('curl_version')) {
$values = curl_version();
echo $values["version"];
} else {
echo '<font style="color: red;">معطل</font>';
}
?></p>
					</div>
				</div>
		   </div>
		  
		   <div class="col-md-3">
				<div class="shield-card">
					<div class="shield-card">
						<p class="text-uppercase mar-btm text-sm" class="font20">بروتوكول HTTP</p>
						<i class="fas fa-hdd fa-3x"></i>
						<hr />
						<p class="h4 text-thin"><?php
echo $_SERVER['SERVER_PROTOCOL'];
?></p>
					</div>
				</div>
		   </div>
		 
		   <div class="col-md-3">
				<div class="shield-card">
					<div class="shield-card">
						<p class="text-uppercase mar-btm text-sm" class="font20">واجهة البوابة</p>
						<i class="fas fa-sitemap fa-3x"></i>
						<hr />
						<p class="h4 text-thin"><?php
echo @$_SERVER['GATEWAY_INTERFACE'];
?></p>
								</div>
							</div>
                       </div>
                    </div>
                    
				</div>
				</div>
				</div>
<?php endif; ?>
				<!--===================================================-->
				<!--End page content-->

			</div>
			<!--===================================================-->
			<!--END CONTENT CONTAINER-->
</div>
<?php
footer();
?>