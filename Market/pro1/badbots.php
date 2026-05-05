<?php
require "core.php";
head();

if (isset($_POST['save2'])) {

    if (isset($_POST['protection'])) {
        $settings['badbot_protection'] = 1;
    } else {
        $settings['badbot_protection'] = 0;
    }
    
    if (isset($_POST['protection2'])) {
        $settings['badbot_protection2'] = 1;
    } else {
        $settings['badbot_protection2'] = 0;
    }
    
    if (isset($_POST['protection3'])) {
        $settings['badbot_protection3'] = 1;
    } else {
        $settings['badbot_protection3'] = 0;
    }

	file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
}

if (isset($_POST['save'])) {

    if (isset($_POST['logging'])) {
        $settings['badbot_logging'] = 1;
    } else {
        $settings['badbot_logging'] = 0;
    }
    
    if (isset($_POST['autoban'])) {
        $settings['badbot_autoban'] = 1;
    } else {
        $settings['badbot_autoban'] = 0;
    }
    
    if (isset($_POST['mail'])) {
        $settings['badbot_mail'] = 1;
    } else {
        $settings['badbot_mail'] = 0;
    }

    file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
}
?>
<div class="content-wrapper">

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
if ($settings['badbot_protection'] == 1 OR $settings['badbot_protection2'] == 1 OR $settings['badbot_protection3'] == 1) {
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
            <h3 class="card-title">البوتات الضارة - وحدة الحماية</h3>
        </div>
        <div class="card-body">
<?php
if ($settings['badbot_protection'] == 1 OR $settings['badbot_protection2'] == 1 OR $settings['badbot_protection3'] == 1) {
echo '
    <h1 class="pm_enabled"><i class="fas fa-check-circle"></i> مفعل</h1>
    <p>تم حماية الموقع من <strong>البوتات الضارة</strong></p>
';
} else {
echo '
    <h1 class="pm_disabled"><i class="fas fa-times-circle"></i> غير مفعل</h1>
    <p>الموقع غير محمي من <strong>البوتات الضارة</strong></p>
';
}
?>
                </div>
            </div>
            
<form class="form-horizontal form-bordered" action="" method="post">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-shield-alt"></i> خيارات الحماية</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                            <div class="col-md-4">
                                <div class="card card-body bg-light">
                                <center>
                                <h5>البوتات الضارة</h5><hr />
                                يكتشف <b>البوتات الضارة</b> ويمنع وصولها إلى الموقع
                                <br /><br />
                                
                                    <input type="checkbox" name="protection" class="psec-switch" <?php
if ($settings['badbot_protection'] == 1) {
echo 'checked="checked"';
}
?> />
                                </center>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-body bg-light">
                                <center>
                                <h5>البوتات الوهمية</h5><hr />
                                يكتشف <b>البوتات الوهمية</b> ويمنع وصولها إلى الموقع
                                <br /><br />
                                
                                    <input type="checkbox" name="protection2" class="psec-switch" <?php
if ($settings['badbot_protection2'] == 1) {
echo 'checked="checked"';
}
?> />
                                </center>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-body bg-light">
                                <center>
                                <h5>البوتات المجهولة</h5><hr />
                                يكتشف <b>البوتات المجهولة</b> ويمنع وصولها إلى الموقع<br />
                                <br /><br />
                                
                                    <input type="checkbox" name="protection3" class="psec-switch" <?php
if ($settings['badbot_protection3'] == 1) {
echo 'checked="checked"';
}
?> />
                                </center>
                                </div>
                            </div>
                        </div>
                            <center><button class="btn btn-flat btn-md btn-block btn-primary mar-top" name="save2" type="submit"><i class="fas fa-save"></i> حفظ</button></center>
                </div>
            </div>
        
        </form>
        
    </div>
            
    <div class="col-md-4">
         <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle"></i> ما هي البوتات الضارة</h3>
                </div>
                <div class="card-body">
                    <strong>البوتات الضارة</strong>، <strong>البوتات الوهمية</strong> و <strong>البوتات المجهولة</strong> هي بوتات تستهلك عرض النطاق الترددي، تبطئ خادمك، تسرق المحتوى الخاص بك وتبحث عن ثغرات لتهديد خادمك.
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
                            <p>السجل</p>
                                <input type="checkbox" name="logging" class="psec-switch" <?php
if ($settings['badbot_logging'] == 1) {
echo 'checked="checked"';
}
?> /><br />
                            <span class="text-muted">يسجل التهديدات المكتشفة</span>
                        </li>
                        <li class="list-group-item">
                            <p>الحظر التلقائي</p>
                                <input type="checkbox" name="autoban" class="psec-switch" <?php
if ($settings['badbot_autoban'] == 1) {
echo 'checked="checked"';
}
?> /><br />
                            <span class="text-muted">يحظر التهديدات المكتشفة تلقائيًا</span>
                        </li>
                        <li class="list-group-item">
                            <p>الإشعارات عبر البريد الإلكتروني</p>
                                <input type="checkbox" name="mail" class="psec-switch" <?php
if ($settings['badbot_mail'] == 1) {
echo 'checked="checked"';
}
?> /><br />
                            <span class="text-muted">تستقبل إشعار بالبريد الإلكتروني عند اكتشاف تهديد من هذا النوع</span>
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
