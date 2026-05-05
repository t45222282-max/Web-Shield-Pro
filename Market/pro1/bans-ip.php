<?php
require "core.php";
head();

if (isset($_GET['delete-all'])) {
    $query = $mysqli->query("TRUNCATE TABLE `psec_bans`");
}

if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];

    $query = $mysqli->query("DELETE FROM `psec_bans` WHERE id='$id'");
}
?>
<div class="content-wrapper">

<!-- حاوية المحتوى -->
<!--===================================================-->
<div class="content-header">
	
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 "><i class="fas fa-user"></i> حظر عناوين الـ IP</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> لوحة الإدارة</a></li>
					<li class="breadcrumb-item active">حظر عناوين الـ IP</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<!-- محتوى الصفحة -->
<!--===================================================-->
<div class="content">
<div class="container-fluid">

<?php
if (isset($_POST['ban-ip'])) {

$ip       = addslashes(htmlspecialchars($_POST['ip']));
$date     = date("d F Y");
$time     = date("H:i");
$reason   = addslashes(htmlspecialchars($_POST['reason']));
$redirect = $_POST['redirect'];
$url      = addslashes(htmlspecialchars($_POST['url']));

if (!filter_var($ip, FILTER_VALIDATE_IP)) {
	echo '<br />
	<div class="callout callout-danger">
			<p><i class="fas fa-exclamation-triangle"></i> عنوان الـ <strong>IP</strong> المدخل غير صالح.</p>
	</div>';
} else if ($redirect == 1 and $url == NULL) {
	echo '<br />
	<div class="callout callout-danger">
			<p><i class="fas fa-exclamation-triangle"></i> من فضلك أدخل رابط التوجيه للمستخدم المحظور.</p>
	</div>';
} else {
	$queryvalid = $mysqli->query("SELECT * FROM `psec_bans` WHERE ip='$ip' LIMIT 1");
	$validator  = mysqli_num_rows($queryvalid);
	if ($validator > "0") {
		echo '<br />
	<div class="callout callout-info">
			<p><i class="fas fa-info-circle"></i> عنوان الـ <strong>IP</strong> هذا محظور بالفعل.</p>
	</div>';
	} else {
		$query = $mysqli->query("INSERT INTO `psec_bans` (`ip`, `date`, `time`, `reason`, `redirect`, `url`) VALUES ('$ip', '$date', '$time', '$reason', '$redirect', '$url')");
	}
}
}
?>
			
		<div class="row">
			
	<div class="col-md-9">
<?php
if (isset($_GET['edit-id'])) {
$id = (int) $_GET["edit-id"];

$result = $mysqli->query("SELECT * FROM `psec_bans` WHERE id = '$id'");
$row    = mysqli_fetch_assoc($result);

if (empty($id) || mysqli_num_rows($result) == 0) {
	echo '<meta http-equiv="refresh" content="0; url=bans-ip.php">';
	exit();
}

if (isset($_POST['edit-ban'])) {
	$ip       = $_POST['ip'];
	$redirect = $_POST['redirect'];
	$url      = $_POST['url'];
	$reason   = $_POST['reason'];
	
	if (!filter_var($ip, FILTER_VALIDATE_IP)) {
		echo '<br />
		<div class="callout callout-danger">
				<p><i class="fas fa-exclamation-triangle"></i> عنوان الـ <strong>IP</strong> المدخل غير صالح.</p>
		</div>';
	} else if ($redirect == 1 and $url == NULL) {
		echo '<br />
		<div class="callout callout-danger">
				<p><i class="fas fa-exclamation-triangle"></i> من فضلك أدخل رابط التوجيه للمستخدم المحظور.</p>
		</div>';
	} else {
		$update = $mysqli->query("UPDATE `psec_bans` SET ip='$ip', redirect='$redirect', url='$url', reason='$reason' WHERE id='$id'");
	}
}
?>         
<form class="form-horizontal" action="" method="post">
				<div class="card card-primary card-outline">
					<div class="card-header">
						<h3 class="card-title">تعديل - حظر عنوان الـ IP</h3>
					</div>
					<div class="card-body">
									<div class="form-group">
										<label class="control-label">عنوان الـ IP: </label>
										<input name="ip" class="form-control" type="text" value="<?php
echo $row['ip'];
?>" required>
									</div>
									<div class="form-group">
										<label class="control-label">السبب: </label>
										<input name="reason" class="form-control" type="text" value="<?php
echo $row['reason'];
?>">
									</div>
									<div class="form-group">
										<label class="control-label">إعادة التوجيه إلى الصفحة / الموقع: </label>
<select name="redirect" class="form-control" required>
	<option value="0" <?php
if ($row['redirect'] == 0) {
	echo 'selected';
}
?>>لا</option>
	<option value="1" <?php
if ($row['redirect'] == 1) {
	echo 'selected';
}
?>>نعم</option>
</select>
									</div>
									<div class="form-group">
										<label class="control-label">رابط إعادة التوجيه: </label>
										<input name="url" class="form-control" type="url" value="<?php
echo $row['url'];
?>">
									</div>
									<div class="form-group">
										<label class="control-label">تاريخ الحظر: </label>
										<input name="date" class="form-control" type="text" value="<?php
echo $row['date'] . ' at ' . $row['time'];
?>" readonly>
									</div>
									<div class="form-group">
										<label class="control-label">محظور تلقائيًا: </label>
										<input name="autoban" class="form-control" type="text" value="<?php
if ($row['autoban'] == 1) {
	echo 'نعم';
} else {
	echo 'لا';
}
?>" readonly>
									</div>
					</div>
					<div class="card-footer row">
						<div class="col-md-8">
							<button class="btn btn-flat btn-success btn-block" name="edit-ban" type="submit">حفظ</button>
						</div>
						<div class="col-md-4">
							<button type="reset" class="btn btn-flat btn-default btn-block">إعادة تعيين</button>
						</div>
					</div>
				 </div>
			</form>
<?php
}
?>
				<div class="card card-primary card-outline">
					<div class="card-header">
						<h3 class="card-title">حظر عناوين الـ IP</h3>
						<a href="?delete-all" class="btn btn-flat btn-danger btn-sm float-sm-right" data-toggle="tooltip" title="حذف جميع حظر عناوين الـ IP"><i class="fas fa-trash"></i> حذف الكل</a>
					</div>
					<div class="card-body">
					
<table id="dt-basicbans" class="table table-bordered table-hover table-sm" width="100%">
								<thead class="<?php echo $thead; ?>">
									<tr>
									  <th><i class="fas fa-user"></i> عنوان الـ IP</th>
									  <th><i class="fas fa-calendar"></i> تاريخ الحظر</th>
									  <th><i class="fas fa-share"></i> إعادة التوجيه</th>
									  <th><i class="fas fa-magic"></i> محظور تلقائيًا</th>
									  <th><i class="fas fa-cog"></i> الإجراءات</th>
									</tr>
								</thead>
								<tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_bans`");
while ($row = $query->fetch_assoc()) {
echo '
									<tr>
										<td>' . $row['ip'] . '</td>
										<td data-sort="' . strtotime($row['date']) . '">' . $row['date'] . '</td>
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
										<a href="?edit-id=' . $row['id'] . '" class="btn btn-flat btn-primary btn-sm"><i class="fas fa-edit"></i> تعديل</a>
										<a href="?delete-id=' . $row['id'] . '" class="btn btn-flat btn-success btn-sm"><i class="fas fa-trash"></i> رفع الحظر</a>
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

			<div class="col-md-3">
				 <div class="card card-primary card-outline">
					<div class="card-header">
						<h3 class="card-title">حظر عنوان الـ IP</h3>
					</div>
					<div class="card-body">
					<form class="form-horizontal" action="" method="post">
									<div class="form-group">
										<label class="control-label">عنوان الـ IP: </label>
										<input name="ip" class="form-control" type="text" value="" required>
									</div>
									<div class="form-group">
										<label class="control-label">السبب: </label>
										<input name="reason" class="form-control" type="text" value="">
									</div>
									<div class="form-group">
										<label class="control-label">إعادة التوجيه إلى الصفحة / الموقع: </label>
<select name="redirect" class="form-control" required>
	<option value="0" selected>لا</option>
	<option value="1">نعم</option>
</select>
									</div>
									<div class="form-group">
										<label class="control-label">رابط إعادة التوجيه: </label>
										<input name="url" class="form-control" type="url" value="">
									</div>
					</div>
					<div class="card-footer">
						<button class="btn btn-block btn-flat btn-danger" name="ban-ip" type="submit">حظر</button>
					</div>
				 </div>
			</div>
</form>
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