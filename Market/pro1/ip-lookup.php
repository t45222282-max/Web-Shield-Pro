<?php
require "core.php";
head();

if (isset($_GET['ip'])) {
    $ip = $_GET["ip"];
    
    if (empty($ip) || !filter_var($ip, FILTER_VALIDATE_IP)) {
        echo '<meta http-equiv="refresh" content="0; url=dashboard.php">';
        exit();
    }
    
	if (isset($_SERVER['HTTP_USER_AGENT'])) {
		$api_useragent = $_SERVER['HTTP_USER_AGENT'];
	} else {
		$api_useragent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118';
	}
	
    $url = 'https://ipapi.co/' . $ip . '/json/';
    $ch  = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($ch, CURLOPT_USERAGENT, $api_useragent);
    curl_setopt($ch, CURLOPT_REFERER, "https://ipapi.co");
    $ipcontent = curl_exec($ch);
    curl_close($ch);
    
    $ip_data = @json_decode($ipcontent);
    if ($ip_data && !isset($ip_data->{'error'})) {
        $country     = $ip_data->{'country_name'};
        $countrycode = $ip_data->{'country_code'};
        $region      = $ip_data->{'region'};
        $city        = $ip_data->{'city'};
        $latitude    = $ip_data->{'latitude'};
        $longitude   = $ip_data->{'longitude'};
        $isp         = $ip_data->{'org'};
    } else {
        $country     = "Unknown";
        $countrycode = "XX";
        $region      = "Unknown";
        $city        = "Unknown";
        $latitude    = "0";
        $longitude   = "0";
        $isp         = "Unknown";
    }
?>
<<div class="content-wrapper">

<!--حاوية المحتوى-->
<!--===================================================-->
<div class="content-header">
	
	<div class="container-fluid">
	  <div class="row mb-2">
		<div class="col-sm-6">
		  <h1 class="m-0"><i class="fas fa-search"></i> البحث عن IP</h1>
		</div>
		<div class="col-sm-6">
		  <ol class="breadcrumb float-sm-right">
			<li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> لوحة الإدارة</a></li>
			<li class="breadcrumb-item active">البحث عن IP</li>
		  </ol>
		</div>
	  </div>
	</div>
</div>

	<!--محتوى الصفحة-->
	<!--===================================================-->
	<div class="content">
	<div class="container-fluid">

	<div class="row">
	<div class="col-md-12">
		
	<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title"><i class="fas fa-info-circle"></i> تفاصيل IP - <?php
echo $ip;
?></h3>
			</div>
			<div class="card-body">

							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label">
											 <i class="fas fa-flag"></i> الدولة
										</label>
										<div class="input-group mar-btm">
											<span class="input-group-addon">
												<img src="assets/plugins/flags/blank.png" class="flag flag-<?php
echo strtolower($countrycode);
?>" alt="<?php
echo $country;
?>" />
											</span>
											<input type="text" class="form-control" value="<?php
echo $country;
?>" readonly>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label">
											 <i class="fas fa-map-pin"></i> المنطقة
										</label>
										<input type="text" class="form-control" value="<?php
echo $region;
?>" readonly>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label">
											 <i class="fas fa-map"></i> المدينة
										</label>
										<input type="text" class="form-control" value="<?php
echo $city;
?>" readonly>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label">
											 <i class="fas fa-cloud"></i> مزود خدمة الإنترنت
										</label>
										<input type="text" class="form-control" value="<?php
echo $isp;
?>" readonly>
									</div>
								</div>
							</div>
							
							<hr />						            
			</div>
	</div>
	
	<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title"><i class="fas fa-align-justify"></i> البحث في السجلات</h3>
			</div>
			<div class="card-body">
<?php
$result = $mysqli->query("SELECT * FROM `psec_logs` WHERE ip = '$ip'");

if (mysqli_num_rows($result) == 0) {
echo '<div class="callout callout-info">
	<strong>لم يتم العثور على نتائج لهذا العنوان IP</strong>
  </div>';
} else {
?>
					<div class="table-responsive">
					<table class="table table-bordered table-hover table-sm">
						<thead class="<?php echo $thead; ?>">
							<tr>
							  <th><i class="fas fa-list-ol"></i> المعرف</th>
							  <th><i class="fas fa-user"></i> عنوان IP</th>
							  <th><i class="fas fa-exclamation-triangle"></i> النوع</th>
							  <th><i class="fas fa-calendar"></i> التاريخ</th>
							  <th><i class="fas fa-globe"></i> المتصفح</th>
							  <th><i class="fas fa-desktop"></i> نظام التشغيل</th>
							  <th><i class="fas fa-flag"></i> الدولة</th>
							  <th><i class="fas fa-cog"></i> الإجراءات</th>
							</tr>
						</thead>
						<tbody>
<?php
while ($row = mysqli_fetch_assoc($result)) {
echo '
							<tr>
							  <td>' . $row['id'] . '</td>
							  <td>' . $row['ip'] . '</td>
							  <td>' . $row['type'] . '</td>
							  <td>' . $row['date'] . '</td>
							  <td><img src="assets/img/icons/browser/' . $row['browser_code'] . '.png" /> ' . $row['browser'] . '</td>
							  <td><img src="assets/img/icons/os/' . $row['os_code'] . '.png" /> ' . $row['os'] . '</td>
							  <td><img src="assets/plugins/flags/blank.png" class="flag flag-' . strtolower($row['country_code']) . '" alt="' . $row['country'] . '" /> ' . $row['country'] . '</td>
							  <td>
								<a href="log-details.php?id=' . $row['id'] . '" class="btn btn-flat btn-primary btn-sm" data-toggle="tooltip" title="تفاصيل السجل"><i class="fas fa-tasks"></i></a>
								<a href="all-logs.php?delete-id=' . $row['id'] . '" class="btn btn-flat btn-danger btn-sm" data-toggle="tooltip" title="حذف السجل"><i class="fas fa-trash"></i></a>
							  </td>
							</tr>
';
}
?>
						</tbody>
					</table></div>
<?php
}
?>
			
			</div>
	</div>	 
	
	<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title"><i class="fas fa-ban"></i> البحث عن الحظر</h3>
			</div>
			<div class="card-body">
<?php
$query = $mysqli->query("SELECT * FROM `psec_bans` WHERE ip = '$ip'");

if (mysqli_num_rows($query) == 0) {
echo '<div class="callout callout-info">
	<strong>لم يتم العثور على نتائج لهذا العنوان IP</strong>
  </div>';
} else {
?>
					<div class="table-responsive">
					<table class="table table-bordered table-hover table-sm">
						<thead class="<?php echo $thead; ?>">
							<tr>
							  <th><i class="fas fa-list-ul"></i> المعرف</th>
							  <th><i class="fas fa-user"></i> عنوان IP</th>
							  <th><i class="fas fa-calendar"></i> تاريخ الحظر</th>
							  <th><i class="fas fa-share"></i> إعادة التوجيه</th>
							  <th><i class="fas fa-magic"></i> الحظر التلقائي</th>
							  <th><i class="fas fa-cog"></i> الإجراءات</th>
							</tr>
						</thead>
						<tbody>
<?php
while ($row = $query->fetch_assoc()) {
echo '
							<tr>
								<td>' . $row['id'] . '</td>
								<td>' . $row['ip'] . '</td>
								<td>' . $row['date'] . '</td>
								<td>';
if ($row['redirect'] == 1) {
echo 'نعم';
} else {
echo 'لا';
}
echo '</td>
								<td>';
if ($row['autoban'] == 1) {
echo 'نعم';
} else {
echo 'لا';
}
echo '</td>
								<td>
								<a href="bans-ip.php?edit-id=' . $row['id'] . '" class="btn btn-flat btn-primary btn-sm"><i class="fas fa-edit"></i> تعديل</a>
								<a href="bans-ip.php?delete-id=' . $row['id'] . '" class="btn btn-flat btn-success btn-sm"><i class="fas fa-ban"></i> إلغاء الحظر</a>
								</td>
							</tr>
';
}
?>
						</tbody>
					</table></div>
<?php
}
?>
			
			</div>
	</div>
	
<?php
// IPHunter
$iphub = '<td class="table-secondary">مفتاح API فارغ</td>';
if ($settings['proxy_api1'] != NULL) {

$key = $settings['proxy_api1'];

$ch  = curl_init();
$url = 'http://v2.api.iphub.info/ip/' . $ip . '';
curl_setopt_array($ch, [
CURLOPT_URL => $url,
CURLOPT_CONNECTTIMEOUT => 30,
CURLOPT_RETURNTRANSFER => true,
CURLOPT_HTTPHEADER => [ "X-Key: {$key}" ]
]);
$choutput = curl_exec($ch);
@$block   = json_decode($choutput)->block;
curl_close($ch);

if ($block == 1) {
$iphub = '<td class="table-danger"><i class="fas fa-times-circle"></i> إيجابي</td>';
} else {
$iphub = '<td class="table-success"><i class="fas fa-check-circle"></i> سلبي</td>';
}
}

// ProxyCheck
$proxy_check = '';
$key = $settings['proxy_api2'];

$ch           = curl_init('http://proxycheck.io/v2/' . $ip . '?key=' . $key . '&vpn=1');
$curl_options = array(
CURLOPT_CONNECTTIMEOUT => 30,
CURLOPT_RETURNTRANSFER => true
);
curl_setopt_array($ch, $curl_options);
$response = curl_exec($ch);
curl_close($ch);

$jsonc = json_decode($response);

if (isset($jsonc->$ip->proxy) && $jsonc->$ip->proxy == "yes") {
$proxy_check = '<td class="table-danger"><i class="fas fa-times-circle"></i> إيجابي</td>';
} else {
$proxy_check = '<td class="table-success"><i class="fas fa-check-circle"></i> سلبي</td>';
}

// IPHunter
$iphunter = '<td class="table-secondary">مفتاح API فارغ</td>';
if ($settings['proxy_api3'] != NULL) {

$key = $settings['proxy_api3'];

$headers = [
'X-Key: '.$key,
];
$ch = curl_init("https://www.iphunter.info:8082/v1/ip/" . $ip);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$choutput    = curl_exec($ch);
$output      = json_decode($choutput, 1);
$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_status == 200 && $output['data']['block'] == 1) {
$iphunter = '<td class="table-danger"><i class="fas fa-times-circle"></i> إيجابي</td>';
} else {
$iphunter = '<td class="table-success"><i class="fas fa-check-circle"></i> سلبي</td>';
}
}
?>
<div class="card card-primary card-outline">
	<div class="card-header">
		<h3 class="card-title">
			<i class="fas fa-globe"></i> فحص الوكيل
		</h3>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
				  <tr>
					<th><i class="fas fa-database"></i> واجهة برمجة تطبيقات الوكيل</th>
					<th><i class="fas fa-info-circle"></i> النتيجة</th>
				  </tr>
				</thead>
				<tbody>
					<tr>
						<td>IPHub</td>
<?php echo $iphub; ?>
					</tr>
					<tr>
						<td>ProxyCheck</td>
<?php echo $proxy_check; ?>
					</tr>
					<tr>
						<td>IPHunter</td>
<?php echo $iphunter; ?>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php
	@set_time_limit(360);
    ini_set('max_execution_time', 300); //300 Seconds = 5 Minutes
    ini_set('memory_limit', '512M');
        
    $dnsbl_lookup = array(
            "all.s5h.net",
			"b.barracudacentral.org",
			"bl.0spam.org",
			"bl.spamcop.net",
			"blacklist.woody.ch",
			"bogons.cymru.com",
			"combined.abuse.ch",
			"db.wpbl.info",
			"dnsbl-1.uceprotect.net",
			"dnsbl-2.uceprotect.net",
			"dnsbl-3.uceprotect.net",
			"dnsbl.dronebl.org",
			"drone.abuse.ch",
			"duinv.aupads.org",
			"dyna.spamrats.com",
			"ips.backscatterer.org",
			"ix.dnsbl.manitu.net",
			"korea.services.net",
			"noptr.spamrats.com",
			"orvedb.aupads.org",
			"proxy.bl.gweep.ca",
			"psbl.surriel.com",
			"rbl.0spam.org",
			"relays.bl.gweep.ca",
			"relays.nether.net",
			"singular.ttk.pte.hu",
			"spam.abuse.ch",
			"spam.dnsbl.anonmails.de",
			"spam.spamrats.com",
			"spambot.bls.digibase.ca",
			"spamrbl.imp.ch",
			"spamsources.fabel.dk",
			"ubl.lashback.com",
			"ubl.unsubscore.com",
			"virus.rbl.jp",
			"wormrbl.imp.ch",
			"z.mailspike.net"
        );
        
	$AllCount = count($dnsbl_lookup);
    $BadCount = 0;
        
    $reverse_ip = implode(".", array_reverse(explode(".", $ip)));
        
    echo '<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title"><i class="fas fa-th-list"></i>فحص القائمة السوداء </h3>
			</div>
			<div class="card-body">';
        
    echo '<div class="table-responsive"><table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th><i class="fas fa-database"></i> DNSBL</th>
        <th><i class="fas fa-cogs"></i> عكس العنوان IP</th>
        <th><i class="fas fa-info-circle"></i> الحالة</th>
      </tr>
    </thead>
    <tbody>';
        
    foreach ($dnsbl_lookup as $host) {
        echo '<tr><td>' . $host . '</td><td>' . $reverse_ip . '.' . $host . '</td>';
        if (checkdnsrr($reverse_ip . "." . $host . ".", "A")) {
            echo '<td class="table-danger"><i class="fas fa-times-circle"></i> مدرج</td></tr>';
            $BadCount++;
        } else {
            echo '<td class="table-success"><i class="fas fa-check-circle"></i> غير مدرج</td></tr>';
        }
    }
        
    echo '</tbody>
    </table></div>';
        
    echo "تم إدراج عنوان IP هذا في <b>" . $BadCount . " القوائم السوداء</b> من اصل <b>" . $AllCount . " إجمالياُ</b><br/>";
        
    echo '</div></div></div>';
?>
                    
				</div>
                    
				</div>
				</div>
				<!--===================================================-->
				<!--End page content-->

			</div>
			<!--===================================================-->
			<!--END CONTENT CONTAINER-->
</div>

<script type="text/javascript">
    map = new OpenLayers.Map("mapdiv");
    map.addLayer(new OpenLayers.Layer.OSM());

    var lonLat = new OpenLayers.LonLat(<?php
    echo $longitude;
?>, <?php
    echo $latitude;
?>)
          .transform(
            new OpenLayers.Projection("EPSG:4326"),
            map.getProjectionObject()
          );
          
    var zoom = 18;
    var markers = new OpenLayers.Layer.Markers("Markers");
	
    map.addLayer(markers);
    markers.addMarker(new OpenLayers.Marker(lonLat));
    map.setCenter(lonLat, zoom);
</script>
<?php
    footer();
} else {
    echo '<meta http-equiv="refresh" content="0; url=dashboard.php">';
    exit();
}
?>