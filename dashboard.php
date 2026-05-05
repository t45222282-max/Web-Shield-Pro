<?php
require "core.php";
head();

$now   = time();

$files = glob("modules/cache/ip-details" . "/*");
foreach ($files as $file) {
    if (is_file($file)) {
		if (($now - filemtime($file)) >= (1 * 24 * 60 * 60)) { // 1 day
			unlink($file);
		}
    }
}
$files = glob("modules/cache/live-traffic" . "/*");
foreach ($files as $file) {
    if (is_file($file)) {
		if (($now - filemtime($file)) >= (1 * 24 * 60 * 60)) { // 1 day
			unlink($file);
		}
    }
}
$files = glob("modules/cache/proxy" . "/*");
foreach ($files as $file) {
    if (is_file($file)) {
		if (($now - filemtime($file)) >= (1 * 24 * 60 * 60)) { // 1 day
			unlink($file);
		}
    }
}
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div class="shield-page-header">
				<div class="shield-page-header__main">
					<h1 class="txt-h1"><i class="fas fa-home"></i> لوحة التحكم</h1>
					<p class="txt-body-sm txt-secondary">مرحباً بك في لوحة الإدارة المركزية لحماية الموقع.</p>
				</div>
            </div>

				<!--Page content-->
				<!--===================================================-->
				<div class="content">
				<div class="container-fluid">

<h4 class="shield-card__title">إحصائيات اليوم</h4><br />
<?php
$date   = date('d F Y');

$query  = $mysqli->query("SELECT * FROM `psec_logs` WHERE `date`='$date' AND `type`='SQLi'");
$count  = mysqli_num_rows($query);
$query2 = $mysqli->query("SELECT * FROM `psec_logs` WHERE `date`='$date' AND `type`='Bad Bot' or `type`='Fake Bot' or type='Missing User-Agent header' or type='Missing header Accept' or type='Invalid IP Address header'");
$count2 = mysqli_num_rows($query2);
$query3 = $mysqli->query("SELECT * FROM `psec_logs` WHERE `date`='$date' AND `type`='Proxy'");
$count3 = mysqli_num_rows($query3);
$query4 = $mysqli->query("SELECT * FROM `psec_logs` WHERE `date`='$date' AND `type`='Spammer'");
$count4 = mysqli_num_rows($query4);
?>
                 <div class="row">

			    <div class="col-sm-6 col-lg-3">
                            <div class="shield-kpi-card shield-kpi--info" style="box-shadow: 0 0 15px rgba(0,210,255,0.1); border: 1px solid rgba(0,210,255,0.2);">
                               <div class="shield-kpi__content">
                                   <div class="shield-kpi__icon">
                                       <i data-lucide="code" class="neon-icon-info" style="width: 24px; height: 24px;"></i>
                                   </div>
                                   <div class="shield-kpi__text">
                                       <div class="shield-kpi__value"><?php echo $count; ?></div>
                                       <div class="shield-kpi__label">هجمات SQLi</div>
                                   </div>
                               </div>
                               <a href="sqli-logs.php" class="shield-kpi__action">عرض السجلات</a>
                            </div>
			    </div>
			    <div class="col-sm-6 col-lg-3">
			        <div class="shield-kpi-card shield-kpi--critical" style="box-shadow: 0 0 15px rgba(255,0,85,0.1); border: 1px solid rgba(255,0,85,0.2);">
                               <div class="shield-kpi__content">
                                   <div class="shield-kpi__icon">
                                       <i data-lucide="bot" class="neon-icon-pink" style="width: 24px; height: 24px; filter: hue-rotate(300deg);"></i>
                                   </div>
                                   <div class="shield-kpi__text">
                                       <div class="shield-kpi__value"><?php echo $count2; ?></div>
                                       <div class="shield-kpi__label">البوتات السيئة</div>
                                   </div>
                               </div>
                               <a href="badbot-logs.php" class="shield-kpi__action">عرض السجلات</a>
                            </div>
			    </div>
			    <div class="col-sm-6 col-lg-3">
			        <div class="shield-kpi-card shield-kpi--success" style="box-shadow: 0 0 15px rgba(0,255,150,0.1); border: 1px solid rgba(0,255,150,0.2);">
                               <div class="shield-kpi__content">
                                   <div class="shield-kpi__icon">
                                       <i data-lucide="globe" class="neon-icon-success" style="width: 24px; height: 24px;"></i>
                                   </div>
                                   <div class="shield-kpi__text">
                                       <div class="shield-kpi__value"><?php echo $count3; ?></div>
                                       <div class="shield-kpi__label">الوكلاء</div>
                                   </div>
                               </div>
                               <a href="proxy-logs.php" class="shield-kpi__action">عرض السجلات</a>
                            </div>
			    </div>
			    <div class="col-sm-6 col-lg-3">
			        <div class="shield-kpi-card shield-kpi--warning" style="box-shadow: 0 0 15px rgba(255,180,0,0.1); border: 1px solid rgba(255,180,0,0.2);">
                               <div class="shield-kpi__content">
                                   <div class="shield-kpi__icon">
                                       <i data-lucide="mail-warning" class="neon-icon-warning" style="width: 24px; height: 24px;"></i>
                                   </div>
                                   <div class="shield-kpi__text">
                                       <div class="shield-kpi__value"><?php echo $count4; ?></div>
                                       <div class="shield-kpi__label">المزعجون</div>
                                   </div>
                               </div>
                               <a href="spammer-logs.php" class="shield-kpi__action">عرض السجلات</a>
                            </div>
			    </div>
			</div>

                <br /><h4 class="shield-card__title">الإحصائيات الشاملة</h4><br />

                <div class="row d-flex align-items-stretch">
					    <div class="col-lg-7 d-flex flex-column mb-4 mb-lg-0">
					        <div id="panel-network" class="neon-panel-cyan flex-fill w-100 mb-0">
					            <div class="shield-card__header" style="padding: 20px 20px 0;">
					                <h3 class="shield-card__title"><i data-lucide="bar-chart-3" class="neon-icon-info" style="width: 20px; height: 20px; margin-right: 8px;"></i> إحصائيات التهديد</h3>
					            </div>
					            <div class="shield-card__body" style="padding: 20px;">
                                    <canvas id="log-stats" class="flex-fill" style="min-height: 300px;"></canvas>
                                </div>
                            </div>

					    </div>
<?php
$querym  = $mysqli->query("SELECT * FROM `psec_logs` WHERE `type`='SQLi'");
$countm  = mysqli_num_rows($querym);
$querym2 = $mysqli->query("SELECT * FROM `psec_logs` WHERE `type`='Bad Bot' or `type`='Fake Bot' or type='Missing User-Agent header' or type='Missing header Accept' or type='Invalid IP Address header'");
$countm2 = mysqli_num_rows($querym2);
$querym3 = $mysqli->query("SELECT * FROM `psec_logs` WHERE `type`='Proxy'");
$countm3 = mysqli_num_rows($querym3);
$querym4 = $mysqli->query("SELECT * FROM `psec_logs` WHERE `type`='Spammer'");
$countm4 = mysqli_num_rows($querym4);
?>
                        <div class="col-lg-5 d-flex flex-column">
					        <div class="row flex-fill">
					            <div class="col-sm-6 col-lg-6 d-flex flex-column">
					         <div class="shield-card flex-fill w-100 mb-4">
								<div class="shield-card__body text-center d-flex flex-column justify-content-center">
									<p class="text-uppercase mar-btm text-lg">حقن SQL</p>
									<i class="fas fa-code fa-2x"></i>
									<hr />
									<p class="h3 text-thin"><?php
echo $countm;
?></p>
								</div>
							 </div>
					            </div>
					            <div class="col-sm-6 col-lg-6 d-flex flex-column">
					         <div class="shield-card flex-fill w-100 mb-4">
								<div class="shield-card__body text-center d-flex flex-column justify-content-center">
									<p class="text-uppercase mar-btm text-lg">البوتات السيئة</p>
									<i class="fas fa-robot fa-2x"></i>
									<hr />
									<p class="h3 text-thin"><?php
echo $countm2;
?></p>
								</div>
							 </div>
					            </div>
					        </div>
					        <div class="row flex-fill">
					            <div class="col-sm-6 col-lg-6 d-flex flex-column">
					        <div class="shield-card flex-fill w-100 mb-0">
								<div class="shield-card__body text-center d-flex flex-column justify-content-center">
									<p class="text-uppercase mar-btm text-lg">الوكلاء</p>
									<i class="fas fa-globe fa-2x"></i>
									<hr />
									<p class="h3 text-thin"><?php
echo $countm3;
?></p>
								</div>
							 </div>
					            </div>
					            <div class="col-sm-6 col-lg-6 d-flex flex-column">
					        <div class="shield-card flex-fill w-100 mb-0">
								<div class="shield-card__body text-center d-flex flex-column justify-content-center">
									<p class="text-uppercase mar-btm text-lg">المزعجون</p>
									<i class="fas fa-keyboard fa-2x"></i>
									<hr />
									<p class="h3 text-thin"><?php
echo $countm4;
?></p>
								</div>
							 </div>
					            </div>
					        </div>

					    </div>
					</div>

                    <div class="shield-card">
						<div class="shield-card__header">
								<h3 class="shield-card__title"><i class="fas fa-stream"></i>حالة الوحدات</h3>
						</div>
						<div class="shield-card__body">
<div class="row">
					<div class="col-md-4">
                        <div class="shield-card shield-card__body">
						    <center>
							<h5><i class="fas fa-shield-alt"></i> &nbsp;وحدات الحماية</h5>
                            </center>
						</div>
					</div>
					<div class="col-md-2">
                        <div class="shield-card shield-card__body">
						    <center>
							<strong><i class="fas fa-code"></i>حقن SQL</strong><br />حماية<hr />
<?php
if ($settings['sqli_protection'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>
						</div>
					</div>
					<div class="col-md-2">
                        <div class="shield-card shield-card__body">
						    <center>
							<strong><i class="fas fa-robot"></i> البوتات السيئة</strong><br />حماية<hr />
<?php
if ($settings['badbot_protection'] == 1 OR $settings['badbot_protection2'] == 1 OR $settings['badbot_protection3'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>
						</div>
					</div>
					<div class="col-md-2">
                        <div class="shield-card shield-card__body">
						    <center>
							<strong><i class="fas fa-globe"></i> الوكيل</strong><br />حماية<br /><hr />
<?php
if ($settings['proxy_protection'] == 1 OR $settings['proxy_protection2'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>
						</div>
					</div>
					<div class="col-md-2">
                        <div class="shield-card shield-card__body">
						    <center>
							<strong><i class="fas fa-keyboard"></i>المزعجون</strong><br />حماية<br /><hr />
<?php
$querysp = $mysqli->query("SELECT * FROM `psec_dnsbl-databases`");
if ($settings['spam_protection'] == 1 && mysqli_num_rows($querysp) > 0) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>
						</div>
					</div>
					</div>

					<div class="row">
					<div class="col-md-4">
                        <div class="shield-card shield-card__body">
						    <center>
							<h5><i class="fas fa-list-ul"></i> &nbsp;إعدادات التسجيل</h5>
                            </center>
						</div>
					</div>
					<div class="col-md-2">
                        <div class="shield-card shield-card__body">
						    <center>
							<strong><i class="fas fa-code"></i> حقن SQL</strong><br />التسجيل<hr />
<?php
if ($settings['sqli_logging'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>
						</div>
					</div>
					<div class="col-md-2">
                        <div class="shield-card shield-card__body">
						    <center>
							<strong><i class="fas fa-robot"></i>  البوتات السيئة</strong><br />التسجيل<hr />
<?php
if ($settings['badbot_logging'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>
						</div>
					</div>
					<div class="col-md-2">
                        <div class="shield-card shield-card__body">
						    <center>
							<strong><i class="fas fa-globe"></i>الوكلاء</strong><br />التسجيل<br /><hr />
<?php
if ($settings['proxy_logging'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>
						</div>
					</div>
					<div class="col-md-2">
                        <div class="shield-card shield-card__body">
						    <center>
							<strong><i class="fas fa-keyboard"></i> المزعجون</strong><br />التسجيل<br /><hr />
<?php
if ($settings['spam_logging'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>
						</div>
					</div>
					</div>
						</div>
				   </div>

				   <div class="row">
<?php
if (isset($_SERVER['HTTP_USER_AGENT'])) {
	$api_useragent = $_SERVER['HTTP_USER_AGENT'];
} else {
	$api_useragent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118';
}

$url = 'https://ipapi.co/8.8.8.8/json/';
$ch  = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
curl_setopt($ch, CURLOPT_USERAGENT, $api_useragent);
curl_setopt($ch, CURLOPT_REFERER, "https://ipapi.co");
$ipcontent = curl_exec($ch);
curl_close($ch);

$ip_data = @json_decode($ipcontent);
if ($ip_data && !isset($ip_data->{'error'})) {
    $gstatus = '<span class="neon-text-success">متصل</span>';
    $gBorder = 'neon-border-success';
    $gIcon = 'neon-text-success';
} else {
    $gstatus = '<span class="neon-text-danger">غير متصل</span>';
    $gBorder = 'neon-border-danger';
    $gIcon = 'neon-text-danger';
}
?>
				        <div class="col-md-6">
						    <div class="info-box shield-info-box <?php echo $gBorder; ?>">
            			    <span class="info-box-icon bg-dark <?php echo $gIcon; ?>"><i class="fas fa-globe"></i></span>
            			    <div class="info-box-content shield-info-box__content">
            			      <span class="info-box-text">حالة واجهة برمجة تطبيقات GeoIP</span>
            			      <span class="info-box-number"><?php
echo $gstatus;
?></span>
            			    </div>
          			        </div>
						</div>
<?php
$proxy_check = 0;

if ($settings['proxy_protection'] > 0 && $settings['proxy_protection'] != 4) {
    $apik = 'api' . $settings['proxy_protection'];
    $key  = $settings['proxy_' . $apik];
}

if ($settings['proxy_protection'] == 1) {
    //Invalid API Key ==> Offline
    $ch  = curl_init();
    $url = "http://v2.api.iphub.info";
    curl_setopt_array($ch, [
		CURLOPT_URL => $url,
		CURLOPT_CONNECTTIMEOUT => 30,
		CURLOPT_RETURNTRANSFER => true,
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);

    if ($httpCode >= 200 && $httpCode < 300) {
        $proxy_check = 1;
    }

} else if ($settings['proxy_protection'] == 2) {

    $ch = curl_init('http://proxycheck.io/v2/8.8.8.8');
    $curl_options = array(
        CURLOPT_CONNECTTIMEOUT => 30,
        CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $curl_options);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);

    if ($httpCode >= 200 && $httpCode < 300) {
        $proxy_check = 1;
    }

} else if ($settings['proxy_protection'] == 3) {
    //Invalid API Key ==> Offline
    $headers = [
		'X-Key: '.$key.'',
    ];
    $ch = curl_init("https://www.iphunter.info:8082/v1/ip/8.8.8.8");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);

    if ($httpCode >= 200 && $httpCode < 300) {
        $proxy_check = 1;
    }

} else {
	$proxy_check = -1;
}

if ($proxy_check == 1) {
    $pstatus = '<span class="neon-text-success">متصل</span>';
    $pBorder = 'neon-border-success';
    $pIcon = 'neon-text-success';
} else if ($proxy_check == 0) {
    $pstatus = '<span class="neon-text-danger">غير متصل</span>';
    $pBorder = 'neon-border-danger';
    $pIcon = 'neon-text-danger';
} else {
	$pstatus = '<span class="neon-text-danger">معطل</span>';
    $pBorder = 'neon-border-danger';
    $pIcon = 'neon-text-danger';
}
?>
				        <div class="col-md-6">
						    <div class="info-box shield-info-box <?php echo $pBorder; ?>">
            			    <span class="info-box-icon bg-dark <?php echo $pIcon; ?>"><i class="fas fa-cloud"></i></span>
            			    <div class="info-box-content shield-info-box__content">
            			      <span class="info-box-text">حالة واجهة برمجة تطبيقات اكتشاف الوكيل</span>
            			      <span class="info-box-number"><?php
echo $pstatus;
?></span>
            			    </div>
          			        </div>
						</div>
				   </div>

				   <div class="row">
				        <div class="col-md-4">
						    <div class="shield-card neon-border-success">
             			        <div class="shield-card__header">
            			            <h3 class="shield-card__title">السجلات الأخيرة</h3>
									<a href="all-logs.php" class="btn btn-flat btn-primary btn-sm float-sm-right"><i class="fas fa-list"></i> عرض الكل</a>
             			        </div>
            			        <div class="shield-card__body">
<?php
$query = $mysqli->query("SELECT * FROM `psec_logs` ORDER BY id DESC LIMIT 2");
$count = mysqli_num_rows($query);
if ($count > 0) {
    while ($row = $query->fetch_assoc()) {
        echo '
							<div class="p-3 mb-3 neon-border-info" style="border-radius: 8px;">
							<p class="navbar-dark text-center neon-text-info" style="font-size: 1.1em; font-weight: bold; margin-bottom: 15px;"><div class="neon-avatar"><i class="fas fa-user"></i></div> ' . $row['ip'] . '</p>

							<div class="media">
                            <div class="media-body text-center">

                                    <p>
';
        if ($row['type'] == 'SQLi') {
            echo '<button class="btn btn-sm btn-primary btn-flat" style="box-shadow: 0 0 10px rgba(0,184,230,0.4);"><i class="fas fa-code"></i> <b>' . $row['type'] . '</b></button>';
        } elseif ($row['type'] == 'Bad Bot' || $row['type'] == 'Fake Bot' || $row['type'] == 'Missing User-Agent header' || $row['type'] == 'Missing header Accept' || $row['type'] == 'Invalid IP Address header') {
            echo '<button class="btn btn-sm btn-danger btn-flat" style="box-shadow: 0 0 10px rgba(239,68,68,0.4);"><i class="fas fa-robot"></i> <b>' . $row['type'] . '</b></button>';
        } elseif ($row['type'] == 'Proxy') {
            echo '<button class="btn btn-sm btn-success btn-flat" style="box-shadow: 0 0 10px rgba(34,197,94,0.4);"><i class="fas fa-globe"></i> <b>' . $row['type'] . '</b></button>';
        } elseif ($row['type'] == 'Spammer') {
            echo '<button class="btn btn-sm btn-warning btn-flat" style="box-shadow: 0 0 10px rgba(245,158,11,0.4);"><i class="fas fa-keyboard"></i> <b>' . $row['type'] . '</b></button>';
        } else {
            echo '<button class="btn btn-sm btn-success btn-flat"><i class="fas fa-user-secret"></i> <b>Other</b></button>';
        }
        echo '
		                    </p>
							<p class="text-muted"><i class="fas fa-calendar"></i> ' . $row['date'] . ' at ' . $row['time'] . '</p>

                            </div>
							<p class="ml-3 d-flex flex-column justify-content-center">
										<a href="log-details.php?id=' . $row['id'] . '" class="btn btn-sm btn-flat btn-block btn-primary" title="تفاصيل"><i class="fas fa-tasks"></i> تفاصيل</a>
                            			<a href="all-logs.php?delete-id=' . $row['id'] . '" class="btn btn-sm btn-flat btn-block btn-danger" title="مسح"><i class="fas fa-trash"></i> مسح</a>
                                    </p>
                            </div>
							</div>
';
    }
} else {
    echo '<div class="callout callout-info"><p>لا توجد الأخيرة<b>سجلات</b></p></div>';
}
?>
            			        </div>
            			    </div>
						</div>

						<div class="col-md-4">
						    <div class="shield-card neon-border-success">
             			        <div class="shield-card__header">
            			            <h3 class="shield-card__title">عمليات حظر IP الأخيرة</h3>
									<a href="bans-ip.php" class="btn btn-flat btn-primary btn-sm float-sm-right"><i class="fas fa-list"></i> عرض الكل</a>
             			        </div>
            			        <div class="shield-card__body">
<?php
$query = $mysqli->query("SELECT * FROM `psec_bans` ORDER BY id DESC LIMIT 2");
$count = mysqli_num_rows($query);
if ($count > 0) {
    while ($row = $query->fetch_assoc()) {
        $isAutoBlocked = ($row['autoban'] == 1);
        $blockBorder = $isAutoBlocked ? 'neon-border-success' : 'neon-border-danger';
        $blockIcon = $isAutoBlocked ? 'neon-text-info' : 'neon-text-danger';
        $switchCls = $isAutoBlocked ? 'neon-switch-success' : 'neon-switch-danger';
        $switchText = $isAutoBlocked ? 'Yes <i class="fas fa-toggle-on"></i>' : 'No <i class="fas fa-toggle-off"></i>';

        echo '
							<div class="p-3 mb-3 ' . $blockBorder . '" style="border-radius: 8px;">
							<p class="navbar-dark text-center ' . $blockIcon . '" style="font-size: 1.1em; font-weight: bold; margin-bottom: 15px;"><div class="neon-avatar"><i class="fas fa-user"></i></div> ' . $row['ip'] . '</p>

							<div class="media">
                            <div class="media-body text-center">
									<p>' . $row['reason'] . ' <i class="fas fa-file-alt"></i></p>
									<p class="text-muted">' . $row['date'] . ' at ' . $row['time'] . ' <i class="fas fa-calendar"></i></p>

                                    <p class="marg_bottom">
                                        <div class="' . $switchCls . '">Auto-Blocked: <b>' . $switchText . '</b></div>
                                    </p>
                            </div>
							<p class="ml-3 d-flex flex-column justify-content-center">
										<a href="bans-ip.php?edit-id=' . $row['id'] . '" class="btn btn-sm btn-flat btn-block btn-primary" title="تعديل"><i class="fas fa-edit"></i> تعديل</a>
                            			<a href="bans-ip.php?delete-id=' . $row['id'] . '" class="btn btn-sm btn-flat btn-block btn-success" title="إلغاء الحظر"><i class="fas fa-ban"></i> إلغاء الحظر</a>
                                    </p>
                            </div>
							</div>
';
    }
} else {
    echo '<div class="callout callout-info"><p>لا توجد الأخيرة <b>حظر عنوان IPs</b></p></div>';
}
?>
            			        </div>
            			    </div>
						</div>

				        <div class="col-md-4">
						    <div class="shield-card neon-border-success">
             			        <div class="shield-card__header">
            			            <h3 class="shield-card__title">إحصائيات</h3>
             			        </div>
            			        <div class="shield-card__body">
<table class="shield-table">
                 <thead class="<?php echo $thead; ?>">
				    <tr class="active">
                      <th><i class="fas fa-list"></i> سجلات التهديدات</th>
                      <th>قيمة</th>
                    </tr>
				</thead>
				<tbody>
<?php
$query = $mysqli->query("SELECT id FROM `psec_logs`");
$count = mysqli_num_rows($query);
?>
                    <tr>
                      <td>المجموع</td>
                      <td><?php
echo $count;
?></td>
                    </tr>
<?php
$date2  = date("d F Y");
$query2 = $mysqli->query("SELECT id FROM `psec_logs` WHERE `date`='$date2'");
$count2 = mysqli_num_rows($query2);
?>
                    <tr>
                      <td>اليوم</td>
                      <td><?php
echo $count2;
?></td>
                    </tr>
<?php
$date3  = date("F Y");
$query3 = $mysqli->query("SELECT id FROM `psec_logs` WHERE `date` LIKE '% $date3'");
$count3 = mysqli_num_rows($query3);
?>
					<tr>
                      <td>هذا الشهر</td>
                      <td><?php
echo $count3;
?></td>
                    </tr>
<?php
$date4  = date("Y");
$query4 = $mysqli->query("SELECT id FROM `psec_logs` WHERE `date` LIKE '% $date4'");
$count4 = mysqli_num_rows($query4);
?>
					<tr>
                      <td>هذا العام</td>
                      <td><?php
echo $count4;
?></td>
                    </tr>
				</tbody>
				<thead class="<?php echo $thead; ?>">
					<tr class="active">
                      <th><i class="fas fa-ban"></i> حظر عنوان IP</th>
                      <th>قيمة</th>
                    </tr>
				</thead>
				<tbody>
<?php
$query5 = $mysqli->query("SELECT id FROM `psec_bans`");
$count5 = mysqli_num_rows($query5);
?>
                    <tr>
                      <td>المجموع</td>
                      <td><?php
echo $count5;
?></td>
                    </tr>
<?php
$date6  = date("d F Y");
$query6 = $mysqli->query("SELECT id FROM `psec_bans` WHERE `date`='$date6'");
$count6 = mysqli_num_rows($query6);
?>
                    <tr>
                      <td>اليوم</td>
                      <td><?php
echo $count6;
?></td>
                    </tr>
<?php
$date7  = date("F Y");
$query7 = $mysqli->query("SELECT id FROM `psec_bans` WHERE `date` LIKE '% $date7'");
$count7 = mysqli_num_rows($query7);
?>
					<tr>
                      <td>هذا الشهر</td>
                      <td><?php
echo $count7;
?></td>
                    </tr>
<?php
$date8  = date("Y");
$query8 = $mysqli->query("SELECT id FROM `psec_bans` WHERE `date` LIKE '% $date8'");
$count8 = mysqli_num_rows($query8);
?>
					<tr>
                      <td>هذا العام</td>
                      <td><?php
echo $count8;
?></td>
                    </tr>
				   </tbody>
                  </table>
            			        </div>
            			    </div>
						</div>
				    </div>

                    <div class="shield-card">
						<div class="shield-card__header">
								<h3 class="shield-card__title">التهديدات حسب البلد</h3>
						</div>
						<div class="shield-card__body">
					        <div class="col-md-12">

								<table id="dt-basic" class="shield-table" width="100%">
									<thead class="<?php echo $thead; ?>">
										<tr>
								          <th><i class="fas fa-globe"></i> دولة</th>
						                  <th><i class="fas fa-bug"></i> التهديدات</th>
										</tr>
									</thead>
									<tbody>
<?php
$countries = array(
    "Afghanistan",
    "Albania",
    "Algeria",
    "Andorra",
    "Angola",
    "Antigua and Barbuda",
    "Argentina",
    "Armenia",
    "Australia",
    "Austria",
    "Azerbaijan",
    "Bahamas",
    "Bahrain",
    "Bangladesh",
    "Barbados",
    "Belarus",
    "Belgium",
    "Belize",
    "Benin",
    "Bhutan",
    "Bolivia",
    "Bosnia and Herzegovina",
    "Botswana",
    "Brazil",
    "Brunei",
    "Bulgaria",
    "Burkina Faso",
    "Burundi",
    "Cambodia",
    "Cameroon",
    "Canada",
    "Cape Verde",
    "Central African Republic",
    "Chad",
    "Chile",
    "China",
    "Colombi",
    "Comoros",
    "Congo (Brazzaville)",
    "Congo",
    "Costa Rica",
    "Cote d\'Ivoire",
    "Croatia",
    "Cuba",
    "Cyprus",
    "Czech Republic",
    "Denmark",
    "Djibouti",
    "Dominica",
    "Dominican Republic",
    "East Timor (Timor Timur)",
    "Ecuador",
    "Egypt",
    "El Salvador",
    "Equatorial Guinea",
    "Eritrea",
    "Estonia",
    "Ethiopia",
    "Fiji",
    "Finland",
    "France",
    "Gabon",
    "Gambia, The",
    "Georgia",
    "Germany",
    "Ghana",
    "Greece",
    "Grenada",
    "Guatemala",
    "Guinea",
    "Guinea-Bissau",
    "Guyana",
    "Haiti",
    "Honduras",
    "Hungary",
    "Iceland",
    "India",
    "Indonesia",
    "Iran",
    "Iraq",
    "Ireland",
    "Israel",
    "Italy",
    "Jamaica",
    "Japan",
    "Jordan",
    "Kazakhstan",
    "Kenya",
    "Kiribati",
    "Korea, North",
    "Korea, South",
    "Kuwait",
    "Kyrgyzstan",
    "Laos",
    "Latvia",
    "Lebanon",
    "Lesotho",
    "Liberia",
    "Libya",
    "Liechtenstein",
    "Lithuania",
    "Luxembourg",
    "Macedonia",
    "Madagascar",
    "Malawi",
    "Malaysia",
    "Maldives",
    "Mali",
    "Malta",
    "Marshall Islands",
    "Mauritania",
    "Mauritius",
    "Mexico",
    "Micronesia",
    "Moldova",
    "Monaco",
    "Mongolia",
    "Morocco",
    "Mozambique",
    "Myanmar",
    "Namibia",
    "Nauru",
    "Nepal",
    "Netherlands",
    "New Zealand",
    "Nicaragua",
    "Niger",
    "Nigeria",
    "Norway",
    "Oman",
    "Pakistan",
    "Palau",
    "Panama",
    "Papua New Guinea",
    "Paraguay",
    "Peru",
    "Philippines",
    "Poland",
    "Portugal",
    "Qatar",
    "Romania",
    "Russia",
    "Rwanda",
    "Saint Kitts and Nevis",
    "Saint Lucia",
    "Saint Vincent",
    "Samoa",
    "San Marino",
    "Sao Tome and Principe",
    "Saudi Arabia",
    "Senegal",
    "Serbia and Montenegro",
    "Seychelles",
    "Sierra Leone",
    "Singapore",
    "Slovakia",
    "Slovenia",
    "Solomon Islands",
    "Somalia",
    "South Africa",
    "Spain",
    "Sri Lanka",
    "Sudan",
    "Suriname",
    "Swaziland",
    "Sweden",
    "Switzerland",
    "Syria",
    "Taiwan",
    "Tajikistan",
    "Tanzania",
    "Thailand",
    "Togo",
    "Tonga",
    "Trinidad and Tobago",
    "Tunisia",
    "Turkey",
    "Turkmenistan",
    "Tuvalu",
    "Uganda",
    "Ukraine",
    "United Arab Emirates",
    "United Kingdom",
    "United States",
    "Uruguay",
    "Uzbekistan",
    "Vanuatu",
    "Vatican City",
    "Venezuela",
    "Vietnam",
    "Yemen",
    "Zambia",
    "Zimbabwe"
);

foreach ($countries as $country) {
    $log_result = $mysqli->query("SELECT * FROM `psec_logs` WHERE `country` LIKE '%$country%'");
    $log_rows   = mysqli_num_rows($log_result);
    $lgrow      = mysqli_fetch_assoc($log_result);

    if ($log_rows > 0) {
        echo '<tr>';
        echo '<td><img src="assets/plugins/flags/blank.png" class="flag flag-' . strtolower($lgrow['country_code']) . '"/>&nbsp; ' . $country . '</td>';
        echo '<td>' . $log_rows . '</td>';
        echo '</tr>';
    }
}
?>
</tbody>
</table>

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
