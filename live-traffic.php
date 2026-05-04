<?php
require "core.php";
head();

// Purge logs older than 30 days
$datetod = strtotime(date('d F Y', strtotime('-30 days')));
$query2 = $mysqli->query("SELECT id, date, ip FROM `psec_live-traffic` ORDER BY id ASC");
while ($row2 = $query2->fetch_assoc()) {
	if (strtotime($row2['date']) < $datetod) {
		
		$id     = $row2['id'];
		$query3 = $mysqli->query("DELETE FROM `psec_live-traffic` WHERE id = '$id'");
		
		// Delete cache file
		if(is_file('modules/cache/live-traffic/' . $row2['ip'] . '.json')) {
			unlink('modules/cache/live-traffic/' . $row2['ip'] . '.json'); 
		}
	}
}

if (isset($_GET['enable'])) {
	
    $settings['live_traffic'] = 1;
	file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
}

if (isset($_GET['disable'])) {
	
    $settings['live_traffic'] = 0;
	file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
	
	$files = glob('modules/cache/live-traffic/*'); // Get all cache file names
	foreach($files as $file){ // Iterate cache files
		if(is_file($file)) {
			unlink($file); // Delete cache file
		}
	}
}

if (isset($_GET['delete-all'])) {
    $query = $mysqli->query("TRUNCATE TABLE `psec_live-traffic`");
}
?>
<div class="content-wrapper">

<!--حاوية المحتوى-->
<!--===================================================-->
<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>
    <header class="shield-page-header">
        <div class="shield-page-header__main">
            <h1 class="txt-h1">حركة المرور الحية</h1>
            <p class="txt-body-sm txt-secondary">مراقبة الزيارات الواردة في الوقت الفعلي. تُحذف السجلات الأقدم من 30 يومًا تلقائيًا.</p>
        </div>
        <div class="shield-page-header__actions">
<?php if ($settings['live_traffic'] == 0): ?>
            <a href="?enable" class="btn-shield-primary"><i data-lucide="play" class="icon icon-sm"></i> تمكين التتبع</a>
<?php else: ?>
            <a href="?disable" class="btn-shield-secondary"><i data-lucide="pause-circle" class="icon icon-sm"></i> تعطيل التتبع</a>
<?php endif; ?>
            <a href="live-traffic.php" class="btn-shield-secondary"><i data-lucide="refresh-cw" class="icon icon-sm"></i> تحديث</a>
            <a href="?delete-all" class="btn-shield-secondary" style="color:var(--color-critical);border-color:var(--color-critical);"><i data-lucide="trash" class="icon icon-sm"></i> حذف البيانات</a>
        </div>
    </header>
    <div class="content"><div class="container-fluid">
    <div class="shield-card">
        <div class="shield-card__header">
            <i data-lucide="activity" class="icon icon-sm text-brand"></i>
            <span class="shield-card__title">حركة المرور الحية</span>
        </div>
        <div class="shield-card__body p-0">
            <div class="shield-table-wrapper">
                <table class="shield-table" id="dt-basiclivetraff" width="100%">
                    <thead><tr>
                        <th>عنوان IP</th><th>الدولة</th><th>المتصفح</th><th>نظام التشغيل</th>
                        <th>النطاق</th><th>الصفحة</th><th>التاريخ</th><th>الإجراءات</th>
                    </tr></thead>
                    <tbody>
<?php
$query = $mysqli->query("SELECT id, bot, ip, country, country_code, browser, browser_code, os, os_code, domain, request_uri, date, time FROM `psec_live-traffic` ORDER BY id DESC");
while ($row = $query->fetch_assoc()) {
    $bot = $row['bot'] == 1 ? ' <span class="shield-badge shield-badge--info">روبوت</span>' : '';
    echo '<tr>
        <td data-label="عنوان IP">' . $row['ip'] . $bot . '</td>
        <td data-label="الدولة"><img src="assets/plugins/flags/blank.png" class="flag flag-' . strtolower($row['country_code']) . '" /> ' . $row['country'] . '</td>
        <td data-label="المتصفح"><img src="assets/img/icons/browser/' . $row['browser_code'] . '.png" /> ' . $row['browser'] . '</td>
        <td data-label="نظام التشغيل"><img src="assets/img/icons/os/' . $row['os_code'] . '.png" /> ' . $row['os'] . '</td>
        <td data-label="النطاق">' . $row['domain'] . '</td>
        <td data-label="الصفحة" style="font-family:var(--font-mono);font-size:0.85em;">' . $row['request_uri'] . '</td>
        <td data-label="التاريخ" data-sort="' . strtotime($row['date']) . '">' . $row['date'] . ' ' . $row['time'] . '</td>
        <td data-label="الإجراءات"><a href="visitor-details.php?id=' . $row['id'] . '" class="btn-shield-secondary btn-shield-sm"><i data-lucide="clipboard-list" class="icon icon-sm"></i></a></td>
    </tr>';
}
?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div></div>
<?php else: ?>
<div class="content-header">
	<div class="container-fluid">
	  <div class="row mb-2">
		<div class="col-sm-6">
		  <h1 class="m-0 "><i class="fas fa-globe"></i> حركة المرور الحية</h1>
		</div>
		<div class="col-sm-6">
		  <ol class="breadcrumb float-sm-right">
			<li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> لوحة التحكم</a></li>
			<li class="breadcrumb-item active">حركة المرور الحية</li>
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
		
				<div class="callout callout-info">
					سيتم حذف سجلات الزيارات التي مضى عليها أكثر من 30 يومًا تلقائيًا.
				</div>
					
				<div class="shield-card">
					<div class="shield-card">
						<h3 class="shield-card">حركة المرور الحية</h3>&nbsp;&nbsp;&nbsp;
						<div class="float-sm-right">
<?php
if ($settings['live_traffic'] == 0) {
echo '<a href="?enable" class="btn btn-flat btn-primary btn-sm"><i class="fas fa-play"></i> تمكين التتبع</a>';
} else {
echo '<a href="?disable" class="btn btn-flat btn-secondary btn-sm"><i class="fas fa-pause-circle"></i> تعطيل التتبع</a>';
}
?>
							<a href="live-traffic.php" class="btn btn-flat btn-primary btn-sm"><i class="fas fa-sync-alt"></i> تحديث</a>
							<a href="?delete-all" class="btn btn-flat btn-danger btn-sm"><i class="fas fa-trash"></i> حذف البيانات</a>
						</div>
					</div>
					<div class="shield-card">
			
						<table id="dt-basiclivetraff" class="shield-table" width="100%">
							<thead class="<?php echo $thead; ?>">
								<tr>
									<th>عنوان IP</th>
									<th>الدولة</th>
									<th>المتصفح</th>
									<th>نظام التشغيل</th>
									<th>النطاق</th>
									<th>الصفحة</th>
									<th>التاريخ</th>
									<th>الإجراءات</th>
								</tr>
							</thead>
							<tbody>
<?php
$query = $mysqli->query("SELECT id, bot, ip, country, country_code, browser, browser_code, os, os_code, domain, request_uri, date, time FROM `psec_live-traffic` ORDER BY id DESC");
while ($row = $query->fetch_assoc()) {
echo '
								<tr>
									<td>' . $row['ip'] . '
								';
if ($row['bot'] == 1) {
	echo '<span class="badge badge-primary">روبوت</span>';
}
echo '</td>
									<td><img src="assets/plugins/flags/blank.png" class="flag flag-' . strtolower($row['country_code']) . '" alt="' . $row['country'] . '" /> ' . $row['country'] . '</td>
									<td><img src="assets/img/icons/browser/' . $row['browser_code'] . '.png" /> ' . $row['browser'] . '</td>
									<td><img src="assets/img/icons/os/' . $row['os_code'] . '.png" /> ' . $row['os'] . '</td>
									<td>' . $row['domain'] . '</td>
									<td>' . $row['request_uri'] . '</td>
									<td data-sort="' . strtotime($row['date']) . ' + ' . $row['time'] . '">' . $row['date'] . 'at' . $row['time'] . '</td>
									<td><a href="visitor-details.php?id=' . $row['id'] . '" class="btn btn-sm btn-flat btn-primary" data-toggle="tooltip" title="تفاصيل الزائر"><i class="fas fa-tasks"></i></a></td>
								</tr>
';
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
	<!--نهاية محتوى الصفحة-->

</div>
<!--===================================================-->
<!--نهاية حاوية المحتوى-->
<?php endif; ?>
</div>
<?php
footer();
?>