<?php
require "core.php";
head();

if (isset($_POST['add-database'])) {
    $database   = $_POST['database'];
	
    $queryvalid = $mysqli->query("SELECT * FROM `psec_dnsbl-databases` WHERE `database`='$database' LIMIT 1");
    $validator  = mysqli_num_rows($queryvalid);
    if ($validator > "0") {
    } else {
        $query = $mysqli->query("INSERT INTO `psec_dnsbl-databases` (`database`) VALUES ('$database')");
    }
}

if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];

    $query = $mysqli->query("DELETE FROM `psec_dnsbl-databases` WHERE id='$id'");
}

if (isset($_POST['save'])) {

    if (isset($_POST['protection'])) {
        $settings['spam_protection'] = 1;
    } else {
        $settings['spam_protection'] = 0;
    }
    
    if (isset($_POST['logging'])) {
        $settings['spam_logging'] = 1;
    } else {
        $settings['spam_logging'] = 0;
    }
    
    if (isset($_POST['mail'])) {
        $settings['spam_mail'] = 1;
    } else {
        $settings['spam_mail'] = 0;
    }
    
    $settings['spam_redirect'] = $_POST['redirect'];
    
    file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
}
?>
<<div class="content-wrapper">

<!--حاوية المحتوى-->
<!--===================================================-->
<div class="content-header">
	
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 "><i class="fas fa-code"></i> وحدة الحماية</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> لوحة التحكم</a></li>
					<li class="breadcrumb-item active">وحدة الحماية</li>
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
			<div class="col-md-8">

<?php
$querysp = $mysqli->query("SELECT * FROM `psec_dnsbl-databases`");
if ($settings['spam_protection'] == 1 && mysqli_num_rows($querysp) > 0) {
echo '
		<div class="card card-solid card-success">
';
} else {
echo '
		<div class="card card-solid card-danger">
';
}
?>
				<div class="card-header">
					<h3 class="card-title">وحدة حماية من السبام</h3>
				</div>
				<div class="card-body">
<?php
if ($settings['spam_protection'] == 1 && mysqli_num_rows($querysp) > 0) {
echo '
	<h1 class="pm_enabled"><i class="fas fa-check-circle"></i> مفعّلة</h1>
	<p>الموقع محمي من <strong>المرسلين العشوائيين (سبام)</strong></p>
';
} else {
echo '
	<h1 class="pm_disabled"><i class="fas fa-times-circle"></i> غير مفعّلة</h1>
	<p>الموقع غير محمي من <strong>المرسلين العشوائيين (سبام)</strong></p>
';
}
?>
				</div>
			</div>
			
			<div class="card card-primary card-outline">
				<div class="card-header">
					<h3 class="card-title"><i class="fas fa-server"></i> قواعد بيانات السبام (DNSBL)</h3>
					<button data-target="#add" data-toggle="modal" class="btn btn-flat btn-primary btn-sm float-sm-right"><i class="fas fa-plus-circle"></i> إضافة قاعدة بيانات سبام (DNSBL)</button>
				</div>
				<div class="card-body">

<form class="form-horizontal mb-lg" method="POST">
<div class="modal fade" id="add" role="dialog" tabindex="-1" aria-labelledby="add" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title">إضافة قاعدة بيانات سبام (DNSBL)</h6>
				<button data-dismiss="modal" class="close" type="button">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label class="control-label"><i class="fas fa-database"></i> قاعدة بيانات سبام (DNSBL):</label>
					<input type="text" class="form-control" name="database" required />
				</div>
			</div>
			<div class="modal-footer">
				<input class="btn btn-block btn-flat btn-primary" name="add-database" type="submit" value="إضافة">
			</div>
		</div>
	</div>
</div>
</form>

<?php
if (mysqli_num_rows($querysp) > 2) {
echo '
	<div class="callout callout-warning">
		لا يُنصح باستخدام أكثر من <b>قاعدتي بيانات</b> للسبام لأن الأداء والدقة قد يتأثران سلباً.
	</div>';
}
?>

<div class="table-responsive">                
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th><i class="fas fa-database"></i> قاعدة بيانات DNSBL</th>
			<th><i class="fas fa-cog"></i> الإجراءات</th>
		</tr>
	</thead>
	<tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_dnsbl-databases`");
while ($rowd = $query->fetch_assoc()) {
echo '
		<tr>
			<td>' . $rowd['database'] . '</td>
			<td>
			<a href="?delete-id=' . $rowd['id'] . '" class="btn btn-flat btn-danger btn-sm btn-block"><i class="fas fa-trash"></i> حذف</a>
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
			
		</div>
			
		<div class="col-md-4">
			<div class="card card-primary card-outline">
				<div class="card-header">
					<h3 class="card-title"><i class="fas fa-info-circle"></i> ما هو السبام و DNSBL؟</h3>
				</div>
				<div class="card-body">
					<strong>الرسائل الإلكترونية العشوائية (سبام)</strong> هي استخدام أنظمة الرسائل الإلكترونية لإرسال رسائل غير مرغوب فيها، خاصةً الإعلانات، أو إرسال رسائل متكررة في نفس الموقع.
					<br /><br />
					<strong>قائمة الحظر المستندة إلى DNS (DNSBL)</strong> أو <strong>قائمة الحظر الفوري (RBL)</strong> هي قائمة لعناوين IP تُستخدم غالبًا لنشر عناوين لأجهزة كمبيوتر أو شبكات مرتبطة بإرسال السبام.
					<br /><br />
					جميع <strong>قوائم الحظر</strong> يمكن العثور عليها هنا: <strong><a href="https://www.dnsbl.info/dnsbl-list.php" target="_blank">https://www.dnsbl.info/dnsbl-list.php</a></strong>
				</div>
			</div>
			<div class="card card-primary card-outline">
				<div class="card-header">
					<h3 class="card-title"><i class="fas fa-cogs"></i> إعدادات الوحدة</h3>
				</div>
				<div class="card-body">
					<ul class="list-group">
<form class="form-horizontal form-bordered" action="" method="post">
						<li class="list-group-item">
							<p>الحماية</p>
							<input type="checkbox" name="protection" class="psec-switch" <?php
if ($settings['spam_protection'] == 1) {
echo 'checked="checked"';
}
?> /><br />
							<span class="text-muted">عند تفعيل وحدة الحماية هذه، سيتم حظر جميع التهديدات من هذا النوع</span>
						</li>
						<li class="list-group-item">
							<p>التسجيل</p>
							<input type="checkbox" name="logging" class="psec-switch" <?php
if ($settings['spam_logging'] == 1) {
echo 'checked="checked"';
}
?> /><br />
							<span class="text-muted">تسجيل التهديدات المكتشفة</span>
						</li>
						<li class="list-group-item">
							<p>الإشعارات بالبريد</p>
							<input type="checkbox" name="mail" class="psec-switch" <?php
if ($settings['spam_mail'] == 1) {
echo 'checked="checked"';
}
?> /><br />
							<span class="text-muted">تلقي إشعار عبر البريد عند اكتشاف تهديد من هذا النوع</span>
						</li>
						
					</ul>
				</div>
				<div class="card-footer">
					<button class="btn btn-flat btn-block btn-primary mar-top" name="save" type="submit"><i class="fas fa-save"></i> حفظ</button>
				</div>
</form>
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
</div>
<?php
footer();
?>
