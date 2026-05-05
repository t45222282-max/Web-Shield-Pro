<?php
require "core.php";
head();

if (isset($_POST['save'])) {
    
    $settings['email'] = $_POST['email'];
    
    if (isset($_POST['project_security'])) {
        $settings['project_security'] = 1;
    } else {
        $settings['project_security'] = 0;
    }
    
    if (isset($_POST['mail_notifications'])) {
        $settings['mail_notifications'] = 1;
    } else {
        $settings['mail_notifications'] = 0;
    }
    
    if (isset($_POST['test_integration'])) {
        $settings['test_integration'] = 1;
    } else {
        $settings['test_integration'] = 0;
    }
	
	if (isset($_POST['dark_mode'])) {
        $settings['dark_mode'] = 1;
    } else {
        $settings['dark_mode'] = 0;
    }
    
	file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
	echo '<meta http-equiv="refresh" content="0; url=settings.php">';
}
?>
<div class="content-wrapper">

  <!--حاوية المحتوى-->
  <!--===================================================-->
  <div class="content-header">
    
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 "><i class="fas fa-cogs"></i> الإعدادات</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> لوحة التحكم</a></li>
            <li class="breadcrumb-item active">الإعدادات</li>
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
        <form class="form-horizontal" method="post">
          <div class="col-md-12 card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-cog"></i> الإعدادات</h3>
            </div>
            <div class="card-body mx-auto">
              <div class="form-group row">
                <label class="control-label" for="inputDefault">عنوان البريد الإلكتروني:</label>
                                                
                <div class="input-group col-sm-10">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                  </div>
                  <input type="email" class="form-control" name="email" value="<?php echo $settings['email']; ?>" required>
                </div>
                <p><br />يتم استخدام عنوان البريد الإلكتروني لتلقي <b>إشعارات البريد الإلكتروني</b> ولزر <b>التواصل (صفحات التحذير)</b>.</p>
              </div><hr />
              <div class="form-group">
                <label class="control-label">مشروع الأمان</label><br />
                <input type="checkbox" name="project_security" class="psec-switch" <?php if ($settings['project_security'] == 1) { echo 'checked'; } ?> />
                <br /> باستخدام هذا الخيار يمكنك <strong>تمكين</strong> أو <strong>تعطيل</strong> السكربت بالكامل.<br />
              </div><hr /><br />
              <div class="form-group">
                <label class="control-label">إشعارات البريد الإلكتروني</label><br />
                <input type="checkbox" name="mail_notifications" class="psec-switch" <?php if ($settings['mail_notifications'] == 1) { echo 'checked'; } ?> />
                </br> إذا كان هذا الخيار <strong>مفعلًا</strong> ستتلقى إشعارات على عنوان بريدك الإلكتروني.<br />
              </div><hr /><br />
              <div class="form-group">
                <label class="control-label">اختبار التكامل</label><br />
                <input type="checkbox" name="test_integration" class="psec-switch" <?php if ($settings['test_integration'] == 1) { echo 'checked'; } ?> />
                </br> تحقق مما إذا كان موقعك مدمجًا بشكل صحيح مع مشروع الأمان.<br />
                ستظهر رسالة على موقعك إذا كان هذا الخيار <strong>مفعلًا</strong> وإذا كان <strong>التكامل صحيحًا</strong>.<br />
              </div><hr /><br />
             
            </div>
            <div class="card-footer">
              <button class="btn btn-block btn-flat btn-primary" name="save" type="submit"><i class="fas fa-save"></i> حفظ</button>
            </div>
          </div>
        </form>
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