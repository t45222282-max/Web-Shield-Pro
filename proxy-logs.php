<?php
require "core.php";
head();

if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];
	
    $query = $mysqli->query("DELETE FROM `psec_logs` WHERE id='$id'");
}

if (isset($_GET['delete-all'])) {
    $query = $mysqli->query("DELETE FROM `psec_logs` WHERE type='Proxy'");
}
?>
<div class="content-wrapper">

<!-- حاوية المحتوى -->
<!--===================================================-->
<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>
    <header class="shield-page-header">
        <div class="shield-page-header__main">
            <h1 class="txt-h1">سجلات الوكيل</h1>
            <p class="txt-body-sm txt-secondary">مراقبة محاولات الوصول عبر وكلاء (Proxies).</p>
        </div>
        <div class="shield-page-header__actions">
            <a href="?delete-all" class="btn-shield-critical" style="box-shadow: 0 0 15px rgba(255,0,85,0.2); border: 1px solid rgba(255,0,85,0.4); transition: all 0.3s ease;">
                <i data-lucide="trash-2" class="neon-icon-pink" style="width:20px;height:20px; filter: hue-rotate(300deg);"></i>
                حذف الكل
            </a>
        </div>
    </header>

    <div class="neon-panel-cyan">
    <div class="shield-card__header" style="padding: 20px 20px 0;"><i data-lucide="history" class="neon-icon-info" style="width: 24px; height: 24px;"></i><span class="shield-card__title" style="font-size: 1.2em; margin-right: 10px;">تفاصيل السجلات</span></div>
    <div class="shield-table-wrapper">
        <table id="dt-basiclogs" class="shield-table" width="100%">
            <thead>
                <tr>
                  <th>عنوان الـ IP</th>
                  <th>التاريخ</th>
                  <th>المتصفح</th>
                  <th>نظام التشغيل</th>
                  <th>الدولة</th>
                  <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
        <?php
        $sql = $mysqli->query("SELECT id, ip, date, time, browser, browser_code, os, os_code, country, country_code, type FROM `psec_logs` WHERE type='Proxy' ORDER by id DESC");
        while ($row = mysqli_fetch_assoc($sql)) {
            echo '
                <tr>
                  <td data-label="عنوان الـ IP">' . $row['ip'] . '</td>
                  <td data-label="التاريخ" data-sort="' . strtotime($row['date']) . ' + ' . $row['time'] . '">' . $row['date'] . ' at ' . $row['time'] . '</td>
                  <td data-label="المتصفح"><img src="assets/img/icons/browser/' . $row['browser_code'] . '.png" style="vertical-align: middle; margin-left: 5px;" /> ' . $row['browser'] . '</td>
                  <td data-label="نظام التشغيل"><img src="assets/img/icons/os/' . $row['os_code'] . '.png" style="vertical-align: middle; margin-left: 5px;" /> ' . $row['os'] . '</td>
                  <td data-label="الدولة"><img src="assets/plugins/flags/blank.png" class="flag flag-' . strtolower($row['country_code']) . '" alt="' . $row['country'] . '" style="vertical-align: middle; margin-left: 5px;" /> ' . $row['country'] . '</td>
                  <td data-label="الإجراءات">
                    <a href="log-details.php?id=' . $row['id'] . '" class="btn-shield-secondary btn-shield-sm" style="box-shadow: 0 0 10px rgba(0,210,255,0.2); border: 1px solid rgba(0,210,255,0.3); transition: all 0.3s ease;" title="تفاصيل السجل"><i data-lucide="file-text" class="neon-icon-info" style="width:16px;height:16px;"></i></a>
                    <a href="?delete-id=' . $row['id'] . '" class="btn-shield-critical btn-shield-sm" style="box-shadow: 0 0 10px rgba(255,0,85,0.2); border: 1px solid rgba(255,0,85,0.3); transition: all 0.3s ease;" title="حذف السجل"><i data-lucide="trash" class="neon-icon-pink" style="width:16px;height:16px; filter: hue-rotate(300deg);"></i></a>
                  </td>
                </tr>
        ';
        }
        ?>
            </tbody>
        </table>
    </div>
    </div>
<?php else: ?>
<div class="content-header">
	
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 "><i class="fas fa-align-justify"></i> سجلات البروكسي</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> لوحة الإدارة</a></li>
					<li class="breadcrumb-item active">سجلات البروكسي</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<!-- محتوى الصفحة -->
<!--===================================================-->
<div class="content">
<div class="container-fluid">

	<div class="row">
	<div class="col-md-12">
		
		<div class="shield-card">
			<div class="shield-card">
				<h3 class="shield-card">سجلات البروكسي</h3>&nbsp;&nbsp;&nbsp;
				<a href="?delete-all" class="btn btn-flat btn-danger btn-sm float-sm-right" data-toggle="tooltip" title="حذف جميع سجلات البروكسي"><i class="fas fa-trash"></i> حذف الكل</a>
			</div>
			<div class="shield-card">

<table id="dt-basicbans" class="shield-table" width="100%">
								<thead class="<?php echo $thead; ?>">
									<tr>
									  <th>عنوان الـ IP</th>
									  <th>التاريخ</th>
									  <th>المتصفح</th>
									  <th>نظام التشغيل</th>
									  <th>الدولة</th>
									  <th>الإجراءات</th>
									</tr>
								</thead>
								<tbody>
<?php
$sql = $mysqli->query("SELECT id, ip, date, time, browser, browser_code, os, os_code, country, country_code, type FROM `psec_logs` WHERE type='Proxy' ORDER by id DESC");
while ($row = mysqli_fetch_assoc($sql)) {
echo '
									<tr>
									  <td>' . $row['ip'] . '</td>
									  <td data-sort="' . strtotime($row['date']) . ' + ' . $row['time'] . '">' . $row['date'] . ' at ' . $row['time'] . '</td>
									  <td><img src="assets/img/icons/browser/' . $row['browser_code'] . '.png" /> ' . $row['browser'] . '</td>
									  <td><img src="assets/img/icons/os/' . $row['os_code'] . '.png" /> ' . $row['os'] . '</td>
									  <td><img src="assets/plugins/flags/blank.png" class="flag flag-' . strtolower($row['country_code']) . '" alt="' . $row['country'] . '" /> ' . $row['country'] . '</td>
									  <td>
										<a href="log-details.php?id=' . $row['id'] . '" class="btn btn-flat btn-primary btn-sm" data-toggle="tooltip" title="تفاصيل السجل"><i class="fas fa-tasks"></i></a>
										<a href="?delete-id=' . $row['id'] . '" class="btn btn-flat btn-danger btn-sm" data-toggle="tooltip" title="حذف السجل"><i class="fas fa-trash"></i></a>
									  </td>
									</tr>
';
}
?>
								</tbody>
								</table>
						
				</div>
			 </div>
<?php endif; ?>
		</div>
		
	</div>
		
</div>
</div>
<!--===================================================-->
<!-- نهاية محتوى الصفحة -->

</div>
<!--===================================================-->
<!-- نهاية حاوية المحتوى -->
</div>  
<?php
footer();
?>