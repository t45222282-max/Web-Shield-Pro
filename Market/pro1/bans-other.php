<?php
require "core.php";
head();

if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];

    $query = $mysqli->query("DELETE FROM `psec_bans-other` WHERE id='$id'");
}
?>
<div class="content-wrapper">

<!--CONTAINER المحتوى-->
<!--===================================================-->
<div class="content-header">
	
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 "><i class="fas fa-desktop"></i> حظر آخر</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> لوحة التحكم</a></li>
					<li class="breadcrumb-item active">حظر آخر</li>
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
if (isset($_POST['block'])) {

	$value = addslashes($_POST['value']);
	$type  = $_POST['type'];
	
	$queryvalid = $mysqli->query("SELECT * FROM `psec_bans-other` WHERE value='$value' and type='$type' LIMIT 1");
	$validator  = mysqli_num_rows($queryvalid);
	if ($validator > "0") {
		echo '<br />
		<div class="callout callout-info">
				<p><i class="fas fa-info-circle"></i> يوجد سجل مشابه في قاعدة البيانات بالفعل.</p>
		</div>';
	} else {
		$query = $mysqli->query("INSERT INTO `psec_bans-other` (value, type) VALUES('$value', '$type')");
	}
}
?>
				
<div class="row">
   
<div class="col-md-6">
				 <div class="card card-primary card-outline">
					<div class="card-header">
						<h3 class="card-title">حظر المتصفح، نظام التشغيل، مزود الإنترنت أو المحيل</h3>
					</div>
					<div class="card-body">
					<form class="form-horizontal" action="" method="post">
									<div class="form-group">
										<label class="control-label">المتصفح، نظام التشغيل، مزود الإنترنت أو المحيل: </label>
										<input name="value" class="form-control" type="text" required>
									</div>
									<div class="form-group">
										<label class="control-label">النوع: </label>
<select name="type" class="form-control" required>
	<option value="browser" selected>متصفح</option>
	<option value="os">نظام التشغيل</option>
	<option value="isp">مزود خدمة الإنترنت</option>
	<option value="referrer">المحيل</option>
</select>
									</div>
					</div>
					<div class="card-footer">
						<button class="btn btn-flat btn-block btn-danger" name="block" type="submit">حظر</button>
					</div>
				 </div>
			</div>
</form>
				
				<div class="col-md-6">
				 <div class="card">
					<div class="card-header">
						<h3 class="card-title">مزودو خدمة الإنترنت <strong>المحظورين</strong></h3>
					</div>
					<div class="card-body">
<table id="dt-basic3" class="table table-bordered table-hover table-sm" width="100%">
								<thead class="<?php echo $thead; ?>">
									<tr>
										<th><i class="fas fa-cloud"></i> مزود الإنترنت</th>
										<th><i class="fas fa-cog"></i> الإجراءات</th>
									</tr>
								</thead>
								<tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_bans-other` WHERE type='isp'");
while ($row = $query->fetch_assoc()) {
	echo '
									<tr>
										<td>' . $row['value'] . '</td>
										<td>
										<a href="?delete-id=' . $row['id'] . '" class="btn btn-flat btn-success btn-block btn-sm"><i class="fas fa-unlock"></i> رفع الحظر</a>
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
				
			<div class="row">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">المتصفحات <strong>المحظورة</strong></h3>
					</div>
					<div class="card-body">
<table id="dt-basicphpconf" class="table table-bordered table-hover table-sm" width="100%">
								<thead class="<?php echo $thead; ?>">
									<tr>
										<th><i class="fas fa-globe"></i> المتصفح</th>
										<th><i class="fas fa-cog"></i> الإجراءات</th>
									</tr>
								</thead>
								<tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_bans-other` WHERE type='browser'");
while ($row = $query->fetch_assoc()) {
	echo '
									<tr>
										<td>' . $row['value'] . '</td>
										<td>
										<a href="?delete-id=' . $row['id'] . '" class="btn btn-flat btn-success btn-block btn-sm"><i class="fas fa-unlock"></i> رفع الحظر</a>
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
				
			<div class="col-md-6">
				 <div class="card">
					<div class="card-header">
						<h3 class="card-title">أنظمة التشغيل <strong>المحظورة</strong></h3>
					</div>
					<div class="card-body">
<table id="dt-basic2" class="table table-bordered table-hover table-sm" width="100%">
								<thead class="<?php echo $thead; ?>">
									<tr>
										<th><i class="fas fa-desktop"></i> نظام التشغيل</th>
										<th><i class="fas fa-cog"></i> الإجراءات</th>
									</tr>
								</thead>
								<tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_bans-other` WHERE type='os'");
while ($row = $query->fetch_assoc()) {
	echo '
									<tr>
										<td>' . $row['value'] . '</td>
										<td>
										<a href="?delete-id=' . $row['id'] . '" class="btn btn-flat btn-success btn-block btn-sm"><i class="fas fa-unlock"></i> رفع الحظر</a>
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
			
			<div class="col-md-6">
				 <div class="card">
					<div class="card-header">
						<h3 class="card-title">المحيلون <strong>المحظورون</strong></h3>
					</div>
					<div class="card-body">
<table id="dt-basic4" class="table table-bordered table-hover table-sm" width="100%">
								<thead class="<?php echo $thead; ?>">
									<tr>
										<th><i class="fas fa-link"></i> المحيل</th>
										<th><i class="fas fa-cog"></i> الإجراءات</th>
									</tr>
								</thead>
								<tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_bans-other` WHERE type='referrer'");
while ($row = $query->fetch_assoc()) {
	echo '
									<tr>
										<td>' . $row['value'] . '</td>
										<td>
										<a href="?delete-id=' . $row['id'] . '" class="btn btn-flat btn-success btn-block btn-sm"><i class="fas fa-unlock"></i> رفع الحظر</a>
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
				
			</div>
			</div>
			<!--===================================================-->
			<!--نهاية محتوى الصفحة-->

		</div>
		<!--===================================================-->
		<!--نهاية محتوى الحاوية-->

</div>
<?php
footer();
?>