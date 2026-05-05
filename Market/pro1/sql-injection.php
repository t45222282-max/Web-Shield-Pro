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
                        <div class="card card-solid card-success">
                    ';
                } else {
                    echo '
                        <div class="card card-solid card-danger">
                    ';
                }
                ?>
                <div class="card-header">
                    <h3 class="card-title">SQL Injection - وحدة الحماية</h3>
                </div>
                <div class="card-body">
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

                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-shield-alt"></i> خيارات الحماية الإضافية</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card card-body bg-light">
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
                                <div class="card card-body bg-light">
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
                                <div class="card card-body bg-light">
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
                                <div class="card card-body bg-light">
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
                                <div class="card card-body bg-light">
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
                                <div class="card card-body">
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
                                <div class="card card-body">
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
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle"></i> ما هو SQL Injection</h3>
                </div>
                <div class="card-body">
                    <strong>SQL Injection</strong> هي تقنية يمكن من خلالها للمستخدمين الخبيثين حقن أوامر SQL في استعلام SQL عبر مدخلات الصفحة على الويب. يمكن للأوامر المحقونة أن تغير الاستعلام وتعرض أمان التطبيق للخطر.
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
                <div class="card-footer">
                    <button class="btn btn-flat btn-block btn-primary mar-top" name="save" type="submit"><i class="fas fa-save"></i> حفظ</button>
                </div>
                </form>
            </div>
        </div>

    </div>
</div>
<!--===================================================-->
<!--End page content-->

</div>
<!--===================================================-->
<!--END CONTENT CONTAINER-->
</div>
<?php
footer();
?>
