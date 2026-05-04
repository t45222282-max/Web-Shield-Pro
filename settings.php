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
<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>
    <header class="shield-page-header">
        <div class="shield-page-header__main">
            <h1 class="txt-h1">الإعدادات</h1>
            <p class="txt-body-sm txt-secondary">إدارة التفضيلات العامة وخيارات الإشعارات.</p>
        </div>
    </header>

    <div class="content">
        <div class="container-fluid">
            <div class="shield-grid shield-grid--1" style="max-width: 800px; margin: 0 auto;">
                <form method="post">
                    <div class="shield-card">
                        <div class="shield-card__header">
                            <i data-lucide="settings" class="icon icon-sm text-brand"></i>
                            <span class="shield-card__title">التفضيلات العامة</span>
                        </div>
                        <div class="shield-card__body">
                            <div style="display: flex; flex-direction: column; gap: var(--space-5);">
                                
                                <!-- Email Address -->
                                <div>
                                    <label class="txt-body-sm" style="font-weight: 500; display: block; margin-bottom: var(--space-2);">عنوان البريد الإلكتروني:</label>
                                    <div style="position: relative;">
                                        <div style="position: absolute; right: var(--space-3); top: 50%; transform: translateY(-50%); color: var(--text-secondary);">
                                            <i data-lucide="mail" class="icon icon-sm"></i>
                                        </div>
                                        <input type="email" name="email" value="<?php echo $settings['email']; ?>" required style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2) var(--space-8) var(--space-2) var(--space-3); border-radius: var(--radius-sm);">
                                    </div>
                                    <p class="txt-body-xs txt-secondary" style="margin-top: var(--space-2);">يتم استخدام عنوان البريد الإلكتروني لتلقي <strong>إشعارات البريد الإلكتروني</strong> ولزر <strong>التواصل (صفحات التحذير)</strong>.</p>
                                </div>
                                
                                <hr style="border-top: 1px solid var(--border-subtle); margin: 0;">
                                
                                <!-- Project Security Switch -->
                                <div>
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                        <div>
                                            <label class="txt-body-sm" style="font-weight: 500; display: block; margin-bottom: var(--space-1);">مشروع الأمان</label>
                                            <p class="txt-body-xs txt-secondary">باستخدام هذا الخيار يمكنك <strong>تمكين</strong> أو <strong>تعطيل</strong> السكربت بالكامل.</p>
                                        </div>
                                        <label class="shield-switch">
                                            <input type="checkbox" name="project_security" <?php if ($settings['project_security'] == 1) { echo 'checked'; } ?>>
                                            <span class="shield-switch__slider"></span>
                                        </label>
                                    </div>
                                </div>
                                
                                <hr style="border-top: 1px solid var(--border-subtle); margin: 0;">
                                
                                <!-- Email Notifications Switch -->
                                <div>
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                        <div>
                                            <label class="txt-body-sm" style="font-weight: 500; display: block; margin-bottom: var(--space-1);">إشعارات البريد الإلكتروني</label>
                                            <p class="txt-body-xs txt-secondary">إذا كان هذا الخيار <strong>مفعلًا</strong> ستتلقى إشعارات على عنوان بريدك الإلكتروني.</p>
                                        </div>
                                        <label class="shield-switch">
                                            <input type="checkbox" name="mail_notifications" <?php if ($settings['mail_notifications'] == 1) { echo 'checked'; } ?>>
                                            <span class="shield-switch__slider"></span>
                                        </label>
                                    </div>
                                </div>
                                
                                <hr style="border-top: 1px solid var(--border-subtle); margin: 0;">
                                
                                <!-- Test Integration Switch -->
                                <div>
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                        <div>
                                            <label class="txt-body-sm" style="font-weight: 500; display: block; margin-bottom: var(--space-1);">اختبار التكامل</label>
                                            <p class="txt-body-xs txt-secondary">تحقق مما إذا كان موقعك مدمجًا بشكل صحيح مع مشروع الأمان.<br>ستظهر رسالة على موقعك إذا كان هذا الخيار <strong>مفعلًا</strong> وإذا كان <strong>التكامل صحيحًا</strong>.</p>
                                        </div>
                                        <label class="shield-switch">
                                            <input type="checkbox" name="test_integration" <?php if ($settings['test_integration'] == 1) { echo 'checked'; } ?>>
                                            <span class="shield-switch__slider"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="shield-card__footer" style="padding: var(--space-4); border-top: 1px solid var(--border-subtle); background: var(--bg-surface-2);">
                            <button class="btn-shield-primary" name="save" type="submit" style="width: 100%; justify-content: center;">
                                <i data-lucide="save" class="icon icon-sm"></i> حفظ الإعدادات
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php else: ?>
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
            <div class="shield-card">
              <h3 class="shield-card"><i class="fas fa-cog"></i> الإعدادات</h3>
            </div>
            <div class="shield-card">
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
            <div class="shield-card">
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
<?php endif; ?>
<!--===================================================-->
<!--نهاية حاوية المحتوى-->

</div>
<?php
footer();
?>