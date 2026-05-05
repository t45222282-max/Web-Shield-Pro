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


    <div class="sql-page-wrapper">
        <div class="shield-grid shield-grid--3">
            <!-- Main Column (2/3) -->
            <div style="grid-column: span 2;">
                
                <?php if ($settings['sqli_protection'] == 1): ?>
                    <div class="neon-host-card neon-border-success" style="padding: 25px; margin-bottom: var(--space-6); display: flex; align-items: center; gap: 20px;">
                        <i data-lucide="shield-check" class="neon-icon-success neon-icon-animated micro-anim-fingerprint" style="width: 56px; height: 56px;"></i>
                        <div style="text-align: right;">
                            <h2 class="txt-h3 text-success" style="text-shadow: 0 0 10px rgba(0,255,150,0.3);">الحماية مفعلة</h2>
                            <p class="txt-body-md txt-secondary">نظام الحماية من **هجمات SQL Injection** يعمل بنشاط.</p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="neon-host-card neon-border-danger" style="padding: 25px; margin-bottom: var(--space-6); display: flex; align-items: center; gap: 20px;">
                        <i data-lucide="shield-alert" class="neon-icon-pink neon-icon-animated micro-anim-cpu" style="width: 56px; height: 56px; filter: hue-rotate(300deg);"></i>
                        <div style="text-align: right;">
                            <h2 class="txt-h3 text-critical" style="text-shadow: 0 0 10px rgba(255,0,85,0.3);">الحماية معطلة</h2>
                            <p class="txt-body-md txt-secondary">الموقع حالياً **عرضة** لمحاولات اختراق قواعد البيانات.</p>
                        </div>
                    </div>
                <?php endif; ?>

                <form action="" method="post">
                    <div class="neon-panel-cyan" style="padding: 25px; margin-bottom: var(--space-6);">
                        <div class="shield-card__header" style="margin-bottom: 20px; border-bottom: 1px solid rgba(0,210,255,0.1); padding-bottom: 15px;">
                            <i data-lucide="settings" class="neon-icon-info" style="width: 24px; height: 24px;"></i>
                            <span class="shield-card__title" style="font-size: 1.2em; margin-right: 10px;">خيارات الحماية الإضافية</span>
                        </div>

                    <div class="interactive-grid">
                        <div class="interactive-card-wrapper glow-cyan">
                            <input type="checkbox" id="chk-php" name="protection6" value="1" <?php echo ($settings['sqli_protection6'] == 1) ? 'checked' : ''; ?>>
                            <label class="interactive-card" for="chk-php">
                                <div class="card-header">
                                    <i class="fas fa-ghost ghost-icon"></i>
                                    <h3 class="card-title">إخفاء معلومات PHP</h3>
                                    <i class="fas fa-ghost ghost-icon"></i>
                                </div>
                                <p class="card-subtitle">إخفاء إصدار PHP</p>
                                <div class="check-icon-wrapper">
                                    <i class="fas fa-check check-icon"></i>
                                </div>
                            </label>
                        </div>
                        
                        <div class="interactive-card-wrapper glow-purple">
                            <input type="checkbox" id="chk-click" name="protection3" value="1" <?php echo ($settings['sqli_protection3'] == 1) ? 'checked' : ''; ?>>
                            <label class="interactive-card" for="chk-click">
                                <div class="card-header">
                                    <h3 class="card-title">حماية Clickjacking</h3>
                                </div>
                                <p class="card-subtitle">كشف ومنع محاولات النقر</p>
                                <div class="check-icon-wrapper">
                                    <i class="fas fa-check check-icon"></i>
                                </div>
                            </label>
                        </div>
                        
                        <div class="interactive-card-wrapper glow-green">
                            <input type="checkbox" id="chk-xss" name="protection2" value="1" <?php echo ($settings['sqli_protection2'] == 1) ? 'checked' : ''; ?>>
                            <label class="interactive-card" for="chk-xss">
                                <div class="card-header">
                                    <h3 class="card-title">حماية XSS</h3>
                                </div>
                                <p class="card-subtitle">تطهير الطفرات المدخلة</p>
                                <div class="check-icon-wrapper">
                                    <i class="fas fa-check check-icon"></i>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="interactive-grid" style="grid-template-columns: repeat(2, 1fr);">
                        <div class="interactive-card-wrapper glow-purple">
                            <input type="checkbox" id="chk-https" name="protection5" value="1" <?php echo ($settings['sqli_protection5'] == 1) ? 'checked' : ''; ?>>
                            <label class="interactive-card" for="chk-https">
                                <div class="card-header">
                                    <h3 class="card-title">اتصال آمن</h3>
                                </div>
                                <p class="card-subtitle">فرض استخدام الاتصال الآمن (HTTPS)</p>
                                <div class="check-icon-wrapper">
                                    <i class="fas fa-check check-icon"></i>
                                </div>
                            </label>
                        </div>

                        <div class="interactive-card-wrapper glow-cyan">
                            <input type="checkbox" id="chk-mime" name="protection4" value="1" <?php echo ($settings['sqli_protection4'] == 1) ? 'checked' : ''; ?>>
                            <label class="interactive-card" for="chk-mime">
                                <div class="card-header">
                                    <h3 class="card-title">حماية هجمات MIME</h3>
                                </div>
                                <p class="card-subtitle">منع الهجمات القائمة على عدم تطابق الأنماط</p>
                                <div class="check-icon-wrapper">
                                    <i class="fas fa-check check-icon"></i>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="info-alert">
                        لا تقم بتمكين الخيارات أدناه إذا كان موقعك يستخدم CMS لتجنب الأعطال البرمجية.
                    </div>

                    <div class="interactive-grid" style="grid-template-columns: repeat(2, 1fr);">
                        <div class="interactive-card-wrapper glow-cyan">
                            <input type="checkbox" id="chk-filter" name="protection7" value="1" <?php echo ($settings['sqli_protection7'] == 1) ? 'checked' : ''; ?>>
                            <label class="interactive-card" for="chk-filter">
                                <div class="card-header">
                                    <h3 class="card-title">تصفية البيانات</h3>
                                </div>
                                <p class="card-subtitle">تنظيف بسيط للمتغيرات باستخدام فلاتر PHP.</p>
                                <div class="check-icon-wrapper">
                                    <i class="fas fa-check check-icon"></i>
                                </div>
                            </label>
                        </div>

                        <div class="interactive-card-wrapper glow-green">
                            <input type="checkbox" id="chk-sanitize" name="protection8" value="1" <?php echo ($settings['sqli_protection8'] == 1) ? 'checked' : ''; ?>>
                            <label class="interactive-card" for="chk-sanitize">
                                <div class="card-header">
                                    <h3 class="card-title">تنظيف الطلبات</h3>
                                </div>
                                <p class="card-subtitle">تنظيف متقدم للمتغيرات باستخدام فلاتر مخصصة.</p>
                                <div class="check-icon-wrapper">
                                    <i class="fas fa-check check-icon"></i>
                                </div>
                            </label>
                        </div>
                    </div>

                        <div style="text-align: center; margin-top: 25px;">
                            <button class="btn-shield-primary" name="save2" type="submit" style="box-shadow: 0 0 15px rgba(0,210,255,0.2); border: 1px solid rgba(0,210,255,0.4);">
                                <i data-lucide="save" class="neon-icon-info" style="width: 18px; height: 18px;"></i> حفظ الإعدادات
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Sidebar Column (1/3) -->
            <div>
                <div class="sidebar-card">
                    <div class="sidebar-card__title">
                        <i data-lucide="help-circle" class="text-brand"></i>
                        ما هو حقن SQL؟
                    </div>
                    <p style="color: #ccc; line-height: 1.6; font-size: 0.95rem; margin: 0;">
                        <strong>SQL Injection</strong> هي تقنية يمكن من خلالها للمستخدمين الخبيثين حقن أوامر SQL في استعلام SQL عبر مدخلات الصفحة على الويب. يمكن للأوامر المحقونة أن تغير الاستعلام وتعرض أمان التطبيق للخطر.
                    </p>
                </div>

                <div class="sidebar-card">
                    <div class="sidebar-card__title">
                        <i data-lucide="settings-2" class="text-brand"></i>
                        إعدادات الوحدة
                    </div>
                    <form action="" method="post">
                        <div style="display: flex; flex-direction: column; gap: var(--space-4);">
                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: var(--space-3);">
                                <div>
                                    <p style="font-weight: bold; margin: 0; color: #fff;">الحماية</p>
                                    <p style="margin: 0; font-size: 0.85rem; color: #aaa;">تفعيل وحدة الحماية الأساسية</p>
                                </div>
                                <label class="custom-checkbox-wrapper">
                                    <input type="checkbox" name="protection" value="1" <?php echo ($settings['sqli_protection'] == 1) ? 'checked' : ''; ?>>
                                    <div class="custom-checkbox-box"></div>
                                </label>
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: var(--space-3);">
                                <div>
                                    <p style="font-weight: bold; margin: 0; color: #fff;">التسجيل (Log&Log)</p>
                                    <p style="margin: 0; font-size: 0.85rem; color: #aaa;">تسجيل الهجمات في سجلات النظام</p>
                                </div>
                                <label class="custom-checkbox-wrapper">
                                    <input type="checkbox" name="logging" value="1" <?php echo ($settings['sqli_logging'] == 1) ? 'checked' : ''; ?>>
                                    <div class="custom-checkbox-box"></div>
                                </label>
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: var(--space-3);">
                                <div>
                                    <p style="font-weight: bold; margin: 0; color: #fff;">الحظر التلقائي</p>
                                    <p style="margin: 0; font-size: 0.85rem; color: #aaa;">حظر عنوان IP مباشرة عند الاكتشاف</p>
                                </div>
                                <label class="custom-checkbox-wrapper">
                                    <input type="checkbox" name="autoban" value="1" <?php echo ($settings['sqli_autoban'] == 1) ? 'checked' : ''; ?>>
                                    <div class="custom-checkbox-box"></div>
                                </label>
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: var(--space-3);">
                                <div>
                                    <p style="font-weight: bold; margin: 0; color: #fff;">إشعارات البريد</p>
                                    <p style="margin: 0; font-size: 0.85rem; color: #aaa;">إرسال البريد والبريد الإلكتروني</p>
                                </div>
                                <label class="custom-checkbox-wrapper">
                                    <input type="checkbox" name="mail" value="1" <?php echo ($settings['sqli_mail'] == 1) ? 'checked' : ''; ?>>
                                    <div class="custom-checkbox-box"></div>
                                </label>
                            </div>

                            <div>
                                <p style="font-weight: bold; margin-bottom: var(--space-2); color: #fff;">رابط التوجيه (Redirect)</p>
                                <input name="redirect" class="redirect-input" type="text" value="<?php echo htmlspecialchars($settings['sqli_redirect']); ?>" required>
                            </div>

                            <button class="btn-cyan-glow" name="save" type="submit">
                                حفظ إعدادات الوحدة
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
