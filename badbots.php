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
<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>
    <header class="shield-page-header">
        <div class="shield-page-header__main">
            <h1 class="txt-h1">وحدة الحماية: البوتات الضارة</h1>
            <p class="txt-body-sm txt-secondary">إدارة إعدادات الحماية ضد الروبوتات الخبيثة والزوار الوهميين والمجهولين.</p>
        </div>
    </header>

    <div class="shield-grid shield-grid--3" style="margin-bottom: var(--space-6);">
        <!-- Main Column (2/3) -->
        <div style="grid-column: span 2;">
            <?php if ($settings['badbot_protection'] == 1 OR $settings['badbot_protection2'] == 1 OR $settings['badbot_protection3'] == 1): ?>
                <div class="shield-card" style="border-inline-start: 4px solid var(--color-success); margin-bottom: var(--space-6);">
                    <div class="shield-card__body" style="display: flex; align-items: center; gap: var(--space-4);">
                        <i data-lucide="shield-check" class="icon icon-lg text-success"></i>
                        <div>
                            <h2 class="txt-h3 text-success">مفعل</h2>
                            <p class="txt-body-md txt-secondary">تم حماية الموقع من <strong>البوتات الضارة</strong></p>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="shield-card" style="border-inline-start: 4px solid var(--color-critical); margin-bottom: var(--space-6);">
                    <div class="shield-card__body" style="display: flex; align-items: center; gap: var(--space-4);">
                        <i data-lucide="shield-alert" class="icon icon-lg text-critical"></i>
                        <div>
                            <h2 class="txt-h3 text-critical">غير مفعل</h2>
                            <p class="txt-body-md txt-secondary">الموقع غير محمي من <strong>البوتات الضارة</strong></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="shield-card" style="margin-bottom: var(--space-6);">
                    <div class="shield-card__header">
                        <i data-lucide="shield-plus" class="icon icon-sm text-brand"></i>
                        <span class="shield-card__title">خيارات الحماية التلقائية</span>
                    </div>
                    <div class="shield-card__body">
                        <div class="shield-grid shield-grid--3" style="margin-bottom: var(--space-4);">
                            <div class="shield-card" style="background: var(--bg-surface-2); padding: var(--space-4); text-align: center;">
                                <h5 class="txt-h5">البوتات الضارة</h5>
                                <hr style="border-color: var(--border-subtle); margin: var(--space-2) 0;"/>
                                <p class="txt-body-sm txt-secondary" style="min-height: 40px;">يكتشف <b>البوتات الضارة</b> ويمنع وصولها إلى الموقع</p>
                                <input type="checkbox" name="protection" class="psec-switch" <?php echo ($settings['badbot_protection'] == 1) ? 'checked="checked"' : ''; ?> />
                            </div>
                            <div class="shield-card" style="background: var(--bg-surface-2); padding: var(--space-4); text-align: center;">
                                <h5 class="txt-h5">البوتات الوهمية</h5>
                                <hr style="border-color: var(--border-subtle); margin: var(--space-2) 0;"/>
                                <p class="txt-body-sm txt-secondary" style="min-height: 40px;">يكتشف <b>البوتات الوهمية</b> ويمنع وصولها إلى الموقع</p>
                                <input type="checkbox" name="protection2" class="psec-switch" <?php echo ($settings['badbot_protection2'] == 1) ? 'checked="checked"' : ''; ?> />
                            </div>
                            <div class="shield-card" style="background: var(--bg-surface-2); padding: var(--space-4); text-align: center;">
                                <h5 class="txt-h5">البوتات المجهولة</h5>
                                <hr style="border-color: var(--border-subtle); margin: var(--space-2) 0;"/>
                                <p class="txt-body-sm txt-secondary" style="min-height: 40px;">يكتشف <b>البوتات المجهولة</b> ويمنع وصولها إلى الموقع</p>
                                <input type="checkbox" name="protection3" class="psec-switch" <?php echo ($settings['badbot_protection3'] == 1) ? 'checked="checked"' : ''; ?> />
                            </div>
                        </div>
                        <div style="text-align: center;">
                            <button class="btn-shield-primary" name="save2" type="submit">
                                <i data-lucide="save" class="icon icon-sm"></i> حفظ خيارات الحماية
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sidebar Column (1/3) -->
        <div>
            <div class="shield-card" style="margin-bottom: var(--space-6);">
                <div class="shield-card__header">
                    <i data-lucide="info" class="icon icon-sm text-brand"></i>
                    <span class="shield-card__title">ما هي البوتات الضارة؟</span>
                </div>
                <div class="shield-card__body">
                    <p class="txt-body-sm txt-secondary" style="line-height: 1.6;"><strong>البوتات الضارة</strong>، <strong>البوتات الوهمية</strong> و <strong>البوتات المجهولة</strong> هي بوتات تستهلك عرض النطاق الترددي، تبطئ خادمك، تسرق المحتوى الخاص بك وتبحث عن ثغرات لتهديد خادمك.</p>
                </div>
            </div>

            <div class="shield-card" style="margin-bottom: var(--space-6);">
                <div class="shield-card__header">
                    <i data-lucide="settings-2" class="icon icon-sm text-brand"></i>
                    <span class="shield-card__title">إعدادات الوحدة</span>
                </div>
                <div class="shield-card__body">
                    <form action="" method="post">
                        <div style="display: flex; flex-direction: column; gap: var(--space-4);">
                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-subtle); padding-bottom: var(--space-3);">
                                <div>
                                    <p class="txt-body-md" style="font-weight: 500; margin: 0;">السجل (Logging)</p>
                                    <p class="txt-body-sm txt-secondary" style="margin: 0;">تسجيل التهديدات في سجلات النظام</p>
                                </div>
                                <input type="checkbox" name="logging" class="psec-switch" <?php echo ($settings['badbot_logging'] == 1) ? 'checked="checked"' : ''; ?> />
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-subtle); padding-bottom: var(--space-3);">
                                <div>
                                    <p class="txt-body-md" style="font-weight: 500; margin: 0;">الحظر التلقائي</p>
                                    <p class="txt-body-sm txt-secondary" style="margin: 0;">حظر التهديدات تلقائيًا فور اكتشافها</p>
                                </div>
                                <input type="checkbox" name="autoban" class="psec-switch" <?php echo ($settings['badbot_autoban'] == 1) ? 'checked="checked"' : ''; ?> />
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <p class="txt-body-md" style="font-weight: 500; margin: 0;">إشعارات البريد</p>
                                    <p class="txt-body-sm txt-secondary" style="margin: 0;">إرسال تنبيه عند اكتشاف التهديد</p>
                                </div>
                                <input type="checkbox" name="mail" class="psec-switch" <?php echo ($settings['badbot_mail'] == 1) ? 'checked="checked"' : ''; ?> />
                            </div>

                            <button class="btn-shield-primary" name="save" type="submit" style="width: 100%; justify-content: center; margin-top: var(--space-2);">
                                <i data-lucide="save" class="icon icon-sm"></i> حفظ إعدادات الوحدة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
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
          <div class="shield-card">
';
} else {
echo '
          <div class="shield-card">
';
}
?>
        <div class="shield-card">
            <h3 class="shield-card">البوتات الضارة - وحدة الحماية</h3>
        </div>
        <div class="shield-card">
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
            <div class="shield-card">
                <div class="shield-card">
                    <h3 class="shield-card"><i class="fas fa-shield-alt"></i> خيارات الحماية</h3>
                </div>
                <div class="shield-card">
                    <div class="row">
                            <div class="col-md-4">
                                <div class="shield-card">
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
                                <div class="shield-card">
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
                                <div class="shield-card">
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
         <div class="shield-card">
                <div class="shield-card">
                    <h3 class="shield-card"><i class="fas fa-info-circle"></i> ما هي البوتات الضارة</h3>
                </div>
                <div class="shield-card">
                    <strong>البوتات الضارة</strong>، <strong>البوتات الوهمية</strong> و <strong>البوتات المجهولة</strong> هي بوتات تستهلك عرض النطاق الترددي، تبطئ خادمك، تسرق المحتوى الخاص بك وتبحث عن ثغرات لتهديد خادمك.
                </div>
         </div>
         <div class="shield-card">
                <div class="shield-card">
                    <h3 class="shield-card"><i class="fas fa-cogs"></i> إعدادات الوحدة</h3>
                </div>
                <div class="shield-card">
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
                <div class="shield-card">
                    <button class="btn btn-flat btn-block btn-primary mar-top" name="save" type="submit"><i class="fas fa-save"></i> حفظ</button>
                </div>
</form>
            </div>
    </div>
    
    </div>
<?php endif; ?>
            
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
