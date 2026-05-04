<?php
require "core.php";
head();

$sec_username = $_SESSION['sec-username'];
?>
<div class="content-wrapper">

<!--حاوية المحتوى-->
<!--===================================================-->
<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>
    <header class="shield-page-header">
        <div class="shield-page-header__main">
            <h1 class="txt-h1">إعدادات الحساب</h1>
            <p class="txt-body-sm txt-secondary">تعديل بيانات تسجيل الدخول.</p>
        </div>
    </header>
    <div class="content"><div class="container-fluid">
    <form method="post" action="">
    <div class="shield-card" style="max-width:600px;">
        <div class="shield-card__header">
            <i data-lucide="user" class="icon icon-sm text-brand"></i>
            <span class="shield-card__title">بيانات الحساب</span>
        </div>
        <div class="shield-card__body">
            <div style="margin-bottom:var(--space-4);">
                <label class="txt-body-sm font-medium" style="display:block;margin-bottom:var(--space-2);"><i data-lucide="user" class="icon icon-xs"></i> اسم المستخدم</label>
                <input type="text" name="username" value="<?php echo $settings['username']; ?>" required style="width:100%;border:1px solid var(--border-default);background:var(--bg-surface-3);color:var(--text-primary);padding:var(--space-2);border-radius:var(--radius-sm);">
            </div>
            <hr style="border-top:1px solid var(--border-subtle);margin:var(--space-4) 0;" />
            <div style="margin-bottom:var(--space-2);">
                <label class="txt-body-sm font-medium" style="display:block;margin-bottom:var(--space-2);"><i data-lucide="key" class="icon icon-xs"></i> كلمة المرور الجديدة</label>
                <input type="text" name="password" placeholder="اتركه فارغًا إذا لم ترد تغييره" style="width:100%;border:1px solid var(--border-default);background:var(--bg-surface-3);color:var(--text-primary);padding:var(--space-2);border-radius:var(--radius-sm);">
            </div>
            <p class="txt-body-sm txt-secondary">املأ هذا الحقل فقط إذا كنت ترغب في تغيير كلمة المرور.</p>
        </div>
        <div class="shield-card__footer" style="padding:var(--space-4);border-top:1px solid var(--border-subtle);background:var(--bg-surface-2);display:flex;gap:var(--space-2);">
            <button class="btn-shield-primary" name="edit" type="submit" style="flex:1;justify-content:center;"><i data-lucide="save" class="icon icon-sm"></i> حفظ</button>
            <button type="reset" class="btn-shield-secondary"><i data-lucide="rotate-ccw" class="icon icon-sm"></i> إعادة تعيين</button>
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
    </div></div>
<?php else: ?>
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
		<div class="shield-card">
		  <div class="shield-card">
			<h3 class="shield-card">الحساب</h3>
		  </div>
		  <div class="shield-card">
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
		  <div class="shield-card">
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

<?php endif; ?>
</div>
<?php
footer();
?>