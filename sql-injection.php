<?php
require "core.php";
head();

if (isset($_POST['save2'])) {

    if (isset($_POST['protection2'])) {
        $settings['sqli_protection2'] = 1;
    } else {
        $settings['sqli_protection2'] = 0;
    }
    
    if (isset($_POST['protection3'])) {
        $settings['sqli_protection3'] = 1;
    } else {
        $settings['sqli_protection3'] = 0;
    }
    
    if (isset($_POST['protection4'])) {
        $settings['sqli_protection4'] = 1;
    } else {
        $settings['sqli_protection4'] = 0;
    }
    
    if (isset($_POST['protection5'])) {
        $settings['sqli_protection5'] = 1;
    } else {
        $settings['sqli_protection5'] = 0;
    }
    
    if (isset($_POST['protection6'])) {
        $settings['sqli_protection6'] = 1;
    } else {
        $settings['sqli_protection6'] = 0;
    }
    
    if (isset($_POST['protection7'])) {
        $settings['sqli_protection7'] = 1;
    } else {
        $settings['sqli_protection7'] = 0;
    }
	
	if (isset($_POST['protection8'])) {
        $settings['sqli_protection8'] = 1;
    } else {
        $settings['sqli_protection8'] = 0;
    }
    
    file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
}

if (isset($_POST['save'])) {
    
    if (isset($_POST['protection'])) {
        $settings['sqli_protection'] = 1;
    } else {
        $settings['sqli_protection'] = 0;
    }
    
    if (isset($_POST['logging'])) {
        $settings['sqli_logging'] = 1;
    } else {
        $settings['sqli_logging'] = 0;
    }
    
    if (isset($_POST['autoban'])) {
        $settings['sqli_autoban'] = 1;
    } else {
        $settings['sqli_autoban'] = 0;
    }
    
    if (isset($_POST['mail'])) {
        $settings['sqli_mail'] = 1;
    } else {
        $settings['sqli_mail'] = 0;
    }
    
    $settings['sqli_redirect'] = $_POST['redirect'];
    
    file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
}
?>
<div class="content-wrapper">

<!--CONTENT CONTAINER-->
<!--===================================================-->
<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>
    <header class="shield-page-header">
        <div class="shield-page-header__main">
            <h1 class="txt-h1">وحدة الحماية: حقن SQL</h1>
            <p class="txt-body-sm txt-secondary">إدارة إعدادات الحماية ضد محاولات حقن قواعد البيانات والتهديدات المرتبطة.</p>
        </div>
    </header>

    <div class="shield-grid shield-grid--3" style="margin-bottom: var(--space-6);">
        <!-- Main Column (2/3) -->
        <div style="grid-column: span 2;">
            <?php if ($settings['sqli_protection'] == 1): ?>
                <div class="shield-card" style="border-inline-start: 4px solid var(--color-success); margin-bottom: var(--space-6);">
                    <div class="shield-card__body" style="display: flex; align-items: center; gap: var(--space-4);">
                        <i data-lucide="shield-check" class="icon icon-lg text-success"></i>
                        <div>
                            <h2 class="txt-h3 text-success">مفعل</h2>
                            <p class="txt-body-md txt-secondary">الموقع محمي من <strong>هجمات حقن SQL (SQLi)</strong></p>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="shield-card" style="border-inline-start: 4px solid var(--color-critical); margin-bottom: var(--space-6);">
                    <div class="shield-card__body" style="display: flex; align-items: center; gap: var(--space-4);">
                        <i data-lucide="shield-alert" class="icon icon-lg text-critical"></i>
                        <div>
                            <h2 class="txt-h3 text-critical">غير مفعل</h2>
                            <p class="txt-body-md txt-secondary">الموقع غير محمي من <strong>هجمات حقن SQL (SQLi)</strong></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="shield-card" style="margin-bottom: var(--space-6);">
                    <div class="shield-card__header">
                        <i data-lucide="shield-plus" class="icon icon-sm text-brand"></i>
                        <span class="shield-card__title">خيارات الحماية الإضافية</span>
                    </div>
                    <div class="shield-card__body">
                        <div class="shield-grid shield-grid--3" style="margin-bottom: var(--space-4);">
                            <div class="shield-card" style="background: var(--bg-surface-2); padding: var(--space-4); text-align: center;">
                                <h5 class="txt-h5">حماية XSS</h5>
                                <hr style="border-color: var(--border-subtle); margin: var(--space-2) 0;"/>
                                <p class="txt-body-sm txt-secondary" style="min-height: 40px;">تطهير الطلبات المصابة</p>
                                <input type="checkbox" name="protection2" class="psec-switch" <?php echo ($settings['sqli_protection2'] == 1) ? 'checked="checked"' : ''; ?> />
                            </div>
                            <div class="shield-card" style="background: var(--bg-surface-2); padding: var(--space-4); text-align: center;">
                                <h5 class="txt-h5">حماية Clickjacking</h5>
                                <hr style="border-color: var(--border-subtle); margin: var(--space-2) 0;"/>
                                <p class="txt-body-sm txt-secondary" style="min-height: 40px;">كشف ومنع محاولات النقر</p>
                                <input type="checkbox" name="protection3" class="psec-switch" <?php echo ($settings['sqli_protection3'] == 1) ? 'checked="checked"' : ''; ?> />
                            </div>
                            <div class="shield-card" style="background: var(--bg-surface-2); padding: var(--space-4); text-align: center;">
                                <h5 class="txt-h5">إخفاء معلومات PHP</h5>
                                <hr style="border-color: var(--border-subtle); margin: var(--space-2) 0;"/>
                                <p class="txt-body-sm txt-secondary" style="min-height: 40px;">إخفاء إصدار PHP</p>
                                <input type="checkbox" name="protection6" class="psec-switch" <?php echo ($settings['sqli_protection6'] == 1) ? 'checked="checked"' : ''; ?> />
                            </div>
                        </div>
                        <div class="shield-grid shield-grid--2" style="margin-bottom: var(--space-4);">
                            <div class="shield-card" style="background: var(--bg-surface-2); padding: var(--space-4); text-align: center;">
                                <h5 class="txt-h5">حماية هجمات MIME</h5>
                                <hr style="border-color: var(--border-subtle); margin: var(--space-2) 0;"/>
                                <p class="txt-body-sm txt-secondary" style="min-height: 40px;">منع الهجمات القائمة على عدم تطابق الأنماط</p>
                                <input type="checkbox" name="protection4" class="psec-switch" <?php echo ($settings['sqli_protection4'] == 1) ? 'checked="checked"' : ''; ?> />
                            </div>
                            <div class="shield-card" style="background: var(--bg-surface-2); padding: var(--space-4); text-align: center;">
                                <h5 class="txt-h5">اتصال آمن</h5>
                                <hr style="border-color: var(--border-subtle); margin: var(--space-2) 0;"/>
                                <p class="txt-body-sm txt-secondary" style="min-height: 40px;">فرض استخدام الاتصال الآمن (HTTPS)</p>
                                <input type="checkbox" name="protection5" class="psec-switch" <?php echo ($settings['sqli_protection5'] == 1) ? 'checked="checked"' : ''; ?> />
                            </div>
                        </div>

                        <div style="background: var(--color-info); color: var(--bg-base); padding: var(--space-3); border-radius: var(--radius-md); margin-bottom: var(--space-4); display: flex; gap: var(--space-2); align-items: center;">
                            <i data-lucide="info" class="icon icon-sm"></i>
                            <p class="txt-body-sm">لا تقم بتمكين الخيارات أدناه إذا كان موقعك يستخدم CMS لتجنب الأخطاء البرمجية.</p>
                        </div>

                        <div class="shield-grid shield-grid--2" style="margin-bottom: var(--space-4);">
                            <div class="shield-card" style="background: var(--bg-surface-2); padding: var(--space-4); text-align: center;">
                                <h5 class="txt-h5">تصفية البيانات</h5>
                                <hr style="border-color: var(--border-subtle); margin: var(--space-2) 0;"/>
                                <p class="txt-body-sm txt-secondary" style="min-height: 40px;">تنظيف بسيط للمتغيرات باستخدام فلاتر PHP.</p>
                                <input type="checkbox" name="protection7" class="psec-switch" <?php echo ($settings['sqli_protection7'] == 1) ? 'checked="checked"' : ''; ?> />
                            </div>
                            <div class="shield-card" style="background: var(--bg-surface-2); padding: var(--space-4); text-align: center;">
                                <h5 class="txt-h5">تنظيف الطلبات</h5>
                                <hr style="border-color: var(--border-subtle); margin: var(--space-2) 0;"/>
                                <p class="txt-body-sm txt-secondary" style="min-height: 40px;">تنظيف متقدم للمتغيرات باستخدام فلاتر مخصصة.</p>
                                <input type="checkbox" name="protection8" class="psec-switch" <?php echo ($settings['sqli_protection8'] == 1) ? 'checked="checked"' : ''; ?> />
                            </div>
                        </div>

                        <div style="text-align: center;">
                            <button class="btn-shield-primary" name="save2" type="submit">
                                <i data-lucide="save" class="icon icon-sm"></i> حفظ التغييرات الإضافية
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
                    <span class="shield-card__title">ما هو حقن SQL؟</span>
                </div>
                <div class="shield-card__body">
                    <p class="txt-body-sm txt-secondary" style="line-height: 1.6;"><strong>SQL Injection</strong> هي تقنية يمكن من خلالها للمستخدمين الخبيثين حقن أوامر SQL في استعلام SQL عبر مدخلات الصفحة على الويب. يمكن للأوامر المحقونة أن تغير الاستعلام وتعرض أمان التطبيق للخطر.</p>
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
                                    <p class="txt-body-md" style="font-weight: 500; margin: 0;">الحماية</p>
                                    <p class="txt-body-sm txt-secondary" style="margin: 0;">تفعيل وحدة الحماية الأساسية</p>
                                </div>
                                <input type="checkbox" name="protection" class="psec-switch" <?php echo ($settings['sqli_protection'] == 1) ? 'checked="checked"' : ''; ?> />
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-subtle); padding-bottom: var(--space-3);">
                                <div>
                                    <p class="txt-body-md" style="font-weight: 500; margin: 0;">التسجيل (Logging)</p>
                                    <p class="txt-body-sm txt-secondary" style="margin: 0;">تسجيل التهديدات في سجلات النظام</p>
                                </div>
                                <input type="checkbox" name="logging" class="psec-switch" <?php echo ($settings['sqli_logging'] == 1) ? 'checked="checked"' : ''; ?> />
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-subtle); padding-bottom: var(--space-3);">
                                <div>
                                    <p class="txt-body-md" style="font-weight: 500; margin: 0;">الحظر التلقائي</p>
                                    <p class="txt-body-sm txt-secondary" style="margin: 0;">حظر عنوان IP مباشرة عند الاكتشاف</p>
                                </div>
                                <input type="checkbox" name="autoban" class="psec-switch" <?php echo ($settings['sqli_autoban'] == 1) ? 'checked="checked"' : ''; ?> />
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-subtle); padding-bottom: var(--space-3);">
                                <div>
                                    <p class="txt-body-md" style="font-weight: 500; margin: 0;">إشعارات البريد</p>
                                    <p class="txt-body-sm txt-secondary" style="margin: 0;">إرسال تنبيه بالبريد الإلكتروني</p>
                                </div>
                                <input type="checkbox" name="mail" class="psec-switch" <?php echo ($settings['sqli_mail'] == 1) ? 'checked="checked"' : ''; ?> />
                            </div>

                            <div>
                                <p class="txt-body-md" style="font-weight: 500; margin-bottom: var(--space-2);">رابط التوجيه (Redirect)</p>
                                <input name="redirect" class="form-control" type="text" value="<?php echo htmlspecialchars($settings['sqli_redirect']); ?>" required style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm);">
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

<!--Page content-->
<!--===================================================-->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <?php
                if ($settings['sqli_protection'] == 1) {
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
                    <h3 class="shield-card">SQL Injection - وحدة الحماية</h3>
                </div>
                <div class="shield-card">
                <?php
                if ($settings['sqli_protection'] == 1) {
                    echo '
                        <h1 class="pm_enabled"><i class="fas fa-check-circle"></i> مفعل</h1>
                        <p>الموقع محمي من <strong>هجمات حقن SQL (SQLi)</strong></p>
                    ';
                } else {
                    echo '
                        <h1 class="pm_disabled"><i class="fas fa-times-circle"></i> غير مفعل</h1>
                        <p>الموقع غير محمي من <strong>هجمات حقن SQL (SQLi)</strong></p>
                    ';
                }
                ?>
                </div>
            </div>

            <form class="form-horizontal form-bordered" action="" method="post">

                <div class="shield-card">
                    <div class="shield-card">
                        <h3 class="shield-card"><i class="fas fa-shield-alt"></i> خيارات الحماية الإضافية</h3>
                    </div>
                    <div class="shield-card">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="shield-card">
                                    <center>
                                        <h5>حماية XSS</h5><hr />
                                        تطهير الطلبات المصابة
                                        <br /><br /><br />
                                        <input type="checkbox" name="protection2" class="psec-switch" <?php
                                        if ($settings['sqli_protection2'] == 1) {
                                            echo 'checked="checked"';
                                        }
                                        ?> />
                                    </center>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="shield-card">
                                    <center>
                                        <h5>حماية من Clickjacking</h5><hr />
                                        كشف ومنع محاولات clickjacking
                                        <br /><br />
                                        <input type="checkbox" name="protection3" class="psec-switch" <?php
                                        if ($settings['sqli_protection3'] == 1) {
                                            echo 'checked="checked"';
                                        }
                                        ?> />
                                    </center>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="shield-card">
                                    <center>
                                        <h5>إخفاء معلومات PHP</h5><hr />
                                        إخفاء إصدار PHP عن الطلبات البعيدة
                                        <br /><br />
                                        <input type="checkbox" name="protection6" class="psec-switch" <?php
                                        if ($settings['sqli_protection6'] == 1) {
                                            echo 'checked="checked"';
                                        }
                                        ?> />
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="shield-card">
                                    <center>
                                        <h5>حماية من هجمات MIME Mismatch</h5><hr />
                                        منع الهجمات القائمة على عدم تطابق MIME
                                        <br /><br />
                                        <input type="checkbox" name="protection4" class="psec-switch" <?php
                                        if ($settings['sqli_protection4'] == 1) {
                                            echo 'checked="checked"';
                                        }
                                        ?> />
                                    </center>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="shield-card">
                                    <center>
                                        <h5>اتصال آمن</h5><hr />
                                        فرض استخدام الاتصال الآمن (HTTPS)
                                        <br /><br /><br />
                                        <input type="checkbox" name="protection5" class="psec-switch" <?php
                                        if ($settings['sqli_protection5'] == 1) {
                                            echo 'checked="checked"';
                                        }
                                        ?> />
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-12">
                                <div class="callout callout-info">
                                    <i class="far fa-arrow-alt-circle-down"></i> 
                                    لا تقم بتمكين الخيارات أدناه إذا كان موقعك يستخدم CMS (أو إطار عمل) لتجنب الأخطاء البرمجية لأن هذه الميزات مدمجة بالفعل في هذه الأنظمة.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="shield-card">
                                    <center>
                                        <h5>تصفية البيانات</h5><hr />
                                        تنظيف بسيط للمتغيرات $_POST و $_GET باستخدام فلتر PHP FILTER_SANITIZE_SPECIAL_CHARS.
                                        <br /><br />
                                        <input type="checkbox" name="protection7" class="psec-switch" <?php
                                        if ($settings['sqli_protection7'] == 1) {
                                            echo 'checked="checked"';
                                        }
                                        ?> />
                                    </center>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="shield-card">
                                    <center>
                                        <h5>تنظيف الطلبات</h5><hr />
                                        تنظيف متقدم للمتغيرات $_POST و $_GET و $_REQUEST و $_COOKIE و $_SESSION باستخدام فلاتر مخصصة.
                                        <br /><br />
                                        <input type="checkbox" name="protection8" class="psec-switch" <?php
                                        if ($settings['sqli_protection8'] == 1) {
                                            echo 'checked="checked"';
                                        }
                                        ?> />
                                    </center>
                                </div>
                            </div>
                        </div>
                        <center><button class="btn btn-flat btn-md btn-block btn-primary" name="save2" type="submit"><i class="fas fa-save"></i> حفظ</button></center>
                    </div>
                </div>

            </form>
        </div>

        <div class="col-md-4">
            <div class="shield-card">
                <div class="shield-card">
                    <h3 class="shield-card"><i class="fas fa-info-circle"></i> ما هو SQL Injection</h3>
                </div>
                <div class="shield-card">
                    <strong>SQL Injection</strong> هي تقنية يمكن من خلالها للمستخدمين الخبيثين حقن أوامر SQL في استعلام SQL عبر مدخلات الصفحة على الويب. يمكن للأوامر المحقونة أن تغير الاستعلام وتعرض أمان التطبيق للخطر.
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
                                <p>الحماية</p>
                                <input type="checkbox" name="protection" class="psec-switch" <?php
                                if ($settings['sqli_protection'] == 1) {
                                    echo 'checked="checked"';
                                }
                                ?> /><br />
                                <span class="text-muted">إذا كانت هذه الوحدة مفعلة، سيتم الحماية من جميع التهديدات من هذا النوع</span>
                            </li>
                            <li class="list-group-item">
                                <p>التسجيل</p>
                                <input type="checkbox" name="logging" class="psec-switch" <?php
                                if ($settings['sqli_logging'] == 1) {
                                    echo 'checked="checked"';
                                }
                                ?> /><br />
                                <span class="text-muted">تسجيل التهديدات المكتشفة</span>
                            </li>
                            <li class="list-group-item">
                                <p>الحظر التلقائي</p>
                                <input type="checkbox" name="autoban" class="psec-switch" <?php
                                if ($settings['sqli_autoban'] == 1) {
                                    echo 'checked="checked"';
                                }
                                ?> /><br />
                                <span class="text-muted">حظر التهديدات المكتشفة تلقائيًا</span>
                            </li>
                            <li class="list-group-item">
                                <p>إشعارات البريد الإلكتروني</p>
                                <input type="checkbox" name="mail" class="psec-switch" <?php
                                if ($settings['sqli_mail'] == 1) {
                                    echo 'checked="checked"';
                                }
                                ?> /><br />
                                <span class="text-muted">ستتلقى إشعارًا عبر البريد الإلكتروني عند اكتشاف تهديد من هذا النوع</span>
                            </li>
                            <li class="list-group-item">
											<p>التوجية </p>
											<input name="redirect" class="form-control" type="text" value="<?php
echo $settings['sqli_redirect'];
?>" required>
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
</div>
<?php endif; ?>
<!--===================================================-->
<!--End page content-->

</div>
<!--===================================================-->
<!--END CONTENT CONTAINER-->
</div>
<?php
footer();
?>
