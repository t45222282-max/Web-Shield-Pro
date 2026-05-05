<?php
require "core.php";
head();

if (isset($_POST['add-word'])) {
    $word       = $_POST['word'];
	
    $queryvalid = $mysqli->query("SELECT * FROM `psec_bad-words` WHERE `word`='$word' LIMIT 1");
    $validator  = mysqli_num_rows($queryvalid);
    if ($validator > "0") {
    } else {
        $query = $mysqli->query("INSERT INTO `psec_bad-words` (`word`) VALUES ('$word')");
    }
}

if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];
    
    $query = $mysqli->query("DELETE FROM `psec_bad-words` WHERE id='$id'");
}

if (isset($_POST['save'])) {
    $settings['badword_replace'] = $_POST['badword-replace'];
	
    file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
}
?>
<div class="content-wrapper">

<!--CONTAINER CONTENT-->
<!--===================================================-->
<div class="content-header">
	
	<div class="container-fluid">
	  <div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 "><i class="fas fa-filter"></i> وحدة الحماية</h1>
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
$queryfc = $mysqli->query("SELECT * FROM `psec_bad-words`");
$countfc = mysqli_num_rows($queryfc);
if ($countfc > 0) {
echo '
	  <div class="card card-solid card-success">
';
} else {
echo '
	  <div class="card card-solid card-primary">
';
}
?>
	<div class="card-header">
		<h3 class="card-title">كلمات سيئة - وحدة الحماية</h3>
	</div>
	<div class="card-body">
<?php
if ($countfc > 0) {
echo '
	<h1 class="pm_enabled"><i class="fas fa-check-circle"></i> مفعل</h1>
	<p>الكلمات السيئة تم <strong>تصفيتها</strong></p>
';
} else {
echo '
	<h1 class="pm_disabledblue"><i class="fas fa-times-circle"></i> غير مفعل</h1>
	<p>الكلمات السيئة لم تُصفى بعد <strong>بعد</strong></p>
';
}
?>
				</div>
			</div>
			
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">الكلمات السيئة</h3>
					<button data-target="#add" data-toggle="modal" class="btn btn-flat btn-primary btn-sm float-sm-right"><i class="fas fa-plus-circle"></i> إضافة كلمة سيئة</button>
				</div>
				<div class="card-body">
				
				<form action="" method="post" class="form-horizontal form-bordered">
				
					<div class="form-group">
						<label class="control-label"><i class="fas fa-pen-square"></i> كلمة استبدال</label>
						<input type="text" name="badword-replace" value="<?php
echo $settings['badword_replace'];
?>" class="form-control">
					</div>
				
					<button type="button submit" name="save" class="mb-xs mt-xs mr-xs btn btn-flat btn-success btn-sm btn-block"><i class="fas fa-save"></i>&nbsp;&nbsp;حفظ</button>
				</form>
				
				<hr /><br />
							
<form class="form-horizontal mb-lg" method="POST">
	<div class="modal fade" id="add" role="dialog" tabindex="-1" aria-labelledby="add" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title">إضافة كلمة سيئة</h6>
					<button data-dismiss="modal" class="close" type="button">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label">الكلمة السيئة:</label>
						<input type="text" class="form-control" name="word" required />
					</div>
				</div>
				<div class="modal-footer">
					<input class="btn btn-block btn-flat btn-primary" name="add-word" type="submit" value="إضافة">
				</div>
			</div>
		</div>
	</div>
</form>               
<table id="dt-basicbadwords" class="table table-bordered table-hover table-sm" width="100%">
							<thead class="<?php echo $thead; ?>">
								<tr>
									<th>الكلمة السيئة</th>
									<th>الإجراءات</th>
								</tr>
							</thead>
							<tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_bad-words`");
while ($rowd = $query->fetch_assoc()) {
echo '
								<tr>
									<td>' . $rowd['word'] . '</td>
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
			
		<div class="col-md-4">
			 <div class="card card-primary card-outline">
					<div class="card-header">
						<h3 class="card-title"><i class="fas fa-info-circle"></i> حول تصفية الكلمات السيئة</h3>
					</div>
					<div class="card-body">
						يمكن استخدام هذه الوحدة لحجب (إخفاء، استبدال) الكلمات السيئة، الروابط، والجمل.
						<br /><br />
						إذا لم يتم إضافة أي كلمات سيئة، فإن الوحدة تكون معطلة تلقائيًا.
						<br /><br />
						تعمل الوحدة بطريقتين:
						<ul>
						  <li>تصفية الكلمات السيئة في الوقت الفعلي قبل العرض (رندر الصفحة)</li>
						  <li>تصفية الكلمات السيئة بعد إرسال بيانات POST</li>
						</ul>
						<strong>كلمة الاستبدال</strong> - النص (الكلمة) التي ستظهر بدلاً من الكلمة السيئة
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
<!--نهاية حاوية المحتوى-->

</div>   
<?php
footer();
?>