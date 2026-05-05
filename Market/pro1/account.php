<?php
require "core.php";
head();

$sec_username = $_SESSION['sec-username'];
?>
<div class="content-wrapper">

<!--حاوية المحتوى-->
<!--===================================================-->
<div class="content-header">
  
  <div class="container-fluid">
	<div class="row mb-2">
	  <div class="col-sm-6">
		<h1 class="m-0 "><i class="fas fa-user"></i> الحساب</h1>
	  </div>
	  <div class="col-sm-6">
		<ol class="breadcrumb float-sm-right">
		  <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> لوحة التحكم</a></li>
		  <li class="breadcrumb-item active">الحساب</li>
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

	  <form class="form-horizontal" action="" method="post">
		<div class="card card-primary card-outline">
		  <div class="card-header">
			<h3 class="card-title">الحساب</h3>
		  </div>
		  <div class="card-body">
			<div class="form-group">
			  <label class="control-label"><i class="fas fa-user"></i> اسم المستخدم: </label>
			  <input type="text" name="username" class="form-control" value="<?php echo $settings['username']; ?>" required>
			</div>
			<hr />
			<div class="form-group">
			  <label class="control-label"><i class="fas fa-key"></i> كلمة المرور الجديدة: </label>
			  <input type="text" name="password" class="form-control">
			</div>
			<i>املأ هذا الحقل فقط إذا كنت ترغب في تغيير كلمة المرور.</i>
		  </div>
		  <div class="card-footer row">
			<div class="col-md-8">
			  <button class="btn btn-block btn-flat btn-success" name="edit" type="submit"><i class="fas fa-save"></i> حفظ</button>
			</div>
			<div class="col-md-4">
			  <button type="reset" class="btn btn-block btn-flat btn-default"><i class="fas fa-undo"></i> إعادة تعيين</button>
			</div>
		  </div>
		</div>
	  </form>
	  <?php
	  if (isset($_POST['edit'])) {
		  $username = addslashes($_POST['username']);
		  $password = $_POST['password'];

		  $settings['username'] = $username;
		  $_SESSION['sec-username'] = $username;
		  
		  if ($password != null) {
			  $password = hash('sha256', $_POST['password']);
			  
			  $settings['password'] = $password;
		  }
		  
		  file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
		  echo '<meta http-equiv="refresh" content="0;url=account.php">';
	  }
	  ?>
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