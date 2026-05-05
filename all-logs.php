<?php
require "core.php";
head();

if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];

    $query = $mysqli->query("DELETE FROM `psec_logs` WHERE id='$id'");
}

if (isset($_GET['delete-all'])) {
    $query = $mysqli->query("TRUNCATE TABLE `psec_logs`");
}
?>   
<div class="content-wrapper">

<!--CONTENT CONTAINER-->
<!--===================================================-->
<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>
<header class="shield-page-header">
    <div class="shield-page-header__main">
        <h1 class="txt-h1">جميع السجلات</h1>
        <p class="txt-body-sm txt-secondary">عرض وتتبع جميع الأحداث الأمنية في النظام.</p>
    </div>
    <div class="shield-page-header__actions">
        <a href="?delete-all" class="btn-shield-critical" style="box-shadow: 0 0 15px rgba(255,0,85,0.2); border: 1px solid rgba(255,0,85,0.4); transition: all 0.3s ease;">
            <i data-lucide="trash-2" class="neon-icon-pink" style="width:20px;height:20px; filter: hue-rotate(300deg);"></i>
            حذف الكل
        </a>
    </div>
</header>

<?php
// إحصائيات السجلات
$query_total = $mysqli->query("SELECT id FROM `psec_logs`");
$count_total = mysqli_num_rows($query_total);

$query_sqli = $mysqli->query("SELECT id FROM `psec_logs` WHERE `type`='SQLi'");
$count_sqli = mysqli_num_rows($query_sqli);

$query_bot = $mysqli->query("SELECT id FROM `psec_logs` WHERE `type`='Bad Bot' or `type`='Fake Bot' or type='Missing User-Agent header' or type='Missing header Accept' or type='Invalid IP Address header'");
$count_bot = mysqli_num_rows($query_bot);

$query_proxy = $mysqli->query("SELECT id FROM `psec_logs` WHERE `type`='Proxy'");
$count_proxy = mysqli_num_rows($query_proxy);
?>
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; direction: rtl;">
    <div class="neon-host-card neon-border-info" style="padding: 25px 15px; text-align: center; transition: transform 0.3s ease;">
        <i data-lucide="list" class="neon-icon-info neon-icon-animated micro-anim-dashboard" style="width: 50px; height: 50px; margin: 0 auto 15px;"></i>
        <div class="neon-host-title" style="font-size: 1.1em; margin-bottom: 10px;">إجمالي السجلات</div>
        <div class="neon-host-val" style="font-size: 1.4em; font-weight: bold; font-family: monospace;"><?php echo $count_total; ?></div>
    </div>
    <div class="neon-host-card neon-border-purple" style="padding: 25px 15px; text-align: center; transition: transform 0.3s ease;">
        <i data-lucide="code" class="neon-icon-purple neon-icon-animated micro-anim-terminal" style="width: 50px; height: 50px; margin: 0 auto 15px;"></i>
        <div class="neon-host-title" style="font-size: 1.1em; margin-bottom: 10px;">هجمات SQLi</div>
        <div class="neon-host-val" style="font-size: 1.4em; font-weight: bold; font-family: monospace;"><?php echo $count_sqli; ?></div>
    </div>
    <div class="neon-host-card neon-border-pink" style="padding: 25px 15px; text-align: center; transition: transform 0.3s ease;">
        <i data-lucide="bot" class="neon-icon-pink neon-icon-animated micro-anim-cpu" style="width: 50px; height: 50px; margin: 0 auto 15px;"></i>
        <div class="neon-host-title" style="font-size: 1.1em; margin-bottom: 10px;">البوتات السيئة</div>
        <div class="neon-host-val" style="font-size: 1.4em; font-weight: bold; font-family: monospace;"><?php echo $count_bot; ?></div>
    </div>
    <div class="neon-host-card neon-border-info" style="padding: 25px 15px; text-align: center; transition: transform 0.3s ease;">
        <i data-lucide="globe" class="neon-icon-info neon-icon-animated micro-anim-globe" style="width: 50px; height: 50px; margin: 0 auto 15px;"></i>
        <div class="neon-host-title" style="font-size: 1.1em; margin-bottom: 10px;">الوكلاء (Proxy)</div>
        <div class="neon-host-val" style="font-size: 1.4em; font-weight: bold; font-family: monospace;"><?php echo $count_proxy; ?></div>
    </div>
</div>

<div class="neon-panel-cyan">
<div class="shield-card__header" style="padding: 20px 20px 0;"><i data-lucide="history" class="neon-icon-info" style="width: 24px; height: 24px;"></i><span class="shield-card__title" style="font-size: 1.2em; margin-right: 10px;">تفاصيل السجلات</span></div>
<div class="shield-table-wrapper">
    <table id="dt-basiclogs" class="shield-table" width="100%">
    <thead>
        <tr>
          <th>عنوان IP</th>
          <th>النوع</th>
          <th>التاريخ</th>
          <th>المتصفح</th>
          <th>نظام التشغيل</th>
          <th>الدولة</th>
          <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $sql = $mysqli->query("SELECT id, ip, date, time, browser, browser_code, os, os_code, country, country_code, type FROM `psec_logs` ORDER by id DESC");
    while ($row = mysqli_fetch_assoc($sql)) {
    echo '
        <tr>
          <td data-label="عنوان IP">' . $row['ip'] . '</td>
          <td data-label="النوع">';
    if ($row['type'] == 'SQLi') {
        echo '
            <div style="display: flex; align-items: center; gap: 8px;"><i data-lucide="code" class="neon-icon-purple" style="width:20px;height:20px;"></i> <span style="font-weight:bold; color:var(--text-primary);">' . $row['type'] . '</span></div>
            ';
    } else if ($row['type'] == 'Proxy') {
        echo '
            <div style="display: flex; align-items: center; gap: 8px;"><i data-lucide="globe" class="neon-icon-info" style="width:20px;height:20px;"></i> <span style="font-weight:bold; color:var(--text-primary);">' . $row['type'] . '</span></div> 
            ';
    } else if ($row['type'] == 'Spammer') {
        echo '
            <div style="display: flex; align-items: center; gap: 8px;"><i data-lucide="mail-warning" class="neon-icon-pink" style="width:20px;height:20px;"></i> <span style="font-weight:bold; color:var(--text-primary);">' . $row['type'] . '</span></div>
            ';
    } else {
        echo '
            <div style="display: flex; align-items: center; gap: 8px;"><i data-lucide="bot-off" class="neon-icon-pink" style="width:20px;height:20px; filter: hue-rotate(300deg);"></i> <span style="font-weight:bold; color:var(--text-primary);">' . $row['type'] . '</span></div>
            ';
    }
    echo '
          </td>
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
		  <h1 class="m-0 "><i class="fas fa-align-justify"></i> جميع السجلات</h1>
		</div>
		<div class="col-sm-6">
		  <ol class="breadcrumb float-sm-right">
			<li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> لوحة التحكم</a></li>
			<li class="breadcrumb-item active">جميع السجلات</li>
		  </ol>
		</div>
	  </div>
	</div>
</div>

<!--Page content-->
<!--===================================================-->
<div class="content">
<div class="container-fluid">

	<div class="row">
	<div class="col-md-12">
		
		<div class="shield-card">
			<div class="shield-card">
				<h3 class="shield-card">جميع السجلات</h3>&nbsp;&nbsp;&nbsp;
				<a href="?delete-all" class="btn btn-flat btn-sm btn-danger float-sm-right" data-toggle="tooltip" title="حذف جميع السجلات"><i class="fas fa-trash"></i> حذف الكل</a>
			</div>
			<div class="shield-card">

<table id="dt-basiclogs" class="shield-table" width="100%">
<thead class="<?php echo $thead; ?>">
	<tr>
	  <th>عنوان IP</th>
	  <th>النوع</th>
	  <th>التاريخ</th>
	  <th>المتصفح</th>
	  <th>نظام التشغيل</th>
	  <th>الدولة</th>
	  <th>الإجراءات</th>
	</tr>
</thead>
<tbody>
<?php
$sql = $mysqli->query("SELECT id, ip, date, time, browser, browser_code, os, os_code, country, country_code, type FROM `psec_logs` ORDER by id DESC");
while ($row = mysqli_fetch_assoc($sql)) {
echo '
	<tr>
	  <td>' . $row['ip'] . '</td>
	  <td>';
if ($row['type'] == 'SQLi') {
	echo '
		<i class="fas fa-code"></i> ' . $row['type'] . '
		';
} else if ($row['type'] == 'Proxy') {
	echo '
		<i class="fas fa-globe"></i> ' . $row['type'] . ' 
		';
} else if ($row['type'] == 'Spammer') {
	echo '
		<i class="fas fa-keyboard"></i> ' . $row['type'] . '
		';
} else {
	echo '
		<i class="fas fa-user-secret"></i> ' . $row['type'] . '
		';
}
echo '
	  </td>
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
</div>
<?php endif; ?>
	
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