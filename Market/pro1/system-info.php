<?php
require "core.php";
head();

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
<<div class="content-wrapper">

<!--حاوية المحتوى-->
<!--===================================================-->
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
		  <div class="card card-primary card-outline">
				<div class="card-header">
					<h3 class="card-title"><?php
echo $site;
?></h3>
				</div>
				<div class="card-body">
				<div class="table-responsive">
						<table class="table table-bordered">
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

					<div class="info-box-content">
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
				<div class="card">
					<div class="card-body text-center">
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
				<div class="card">
					<div class="card-body text-center">
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
				<div class="card">
					<div class="card-body text-center">
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
				<div class="card">
					<div class="card-body text-center">
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
				<div class="card">
					<div class="card-body text-center">
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
				<div class="card">
					<div class="card-body text-center">
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
				<div class="card">
					<div class="card-body text-center">
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
				<div class="card">
					<div class="card-body text-center">
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
				<div class="card">
					<div class="card-body text-center">
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
				<div class="card">
					<div class="card-body text-center">
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
				<div class="card">
					<div class="card-body text-center">
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
				<div class="card">
					<div class="card-body text-center">
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
				<!--===================================================-->
				<!--End page content-->

			</div>
			<!--===================================================-->
			<!--END CONTENT CONTAINER-->
</div>
<?php
footer();
?>