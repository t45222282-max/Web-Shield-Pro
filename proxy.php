<?php
require "core.php";
head();

if (isset($_GET['api'])) {
    
    $apid = (int) $_GET['api'];
    
    if ($apid == 0 || $apid == 1 || $apid == 2 || $apid == 3) {
        
        $settings['proxy_protection'] = $apid;

		file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');

		$files = glob('modules/cache/proxy/*'); // Get all cache file names
		foreach($files as $file){ // Iterate cache files
			if(is_file($file)) {
				unlink($file); // Delete cache file
			}
		}
    }
}

if (isset($_POST['save2'])) {

    $apiks = 'proxy_api' . $settings['proxy_protection'];
    
    if (isset($_POST['protection2'])) {
        $settings['proxy_protection2'] = 1;
    } else {
        $settings['proxy_protection2'] = 0;
    }
    
    if ($settings['proxy_protection'] > 0) {
		
		$api_key = $_POST['apikey'];
		
		$settings[$apiks] = $api_key;
		
		$files = glob('modules/cache/proxy/*'); // Get all cache file names
		foreach($files as $file){ // Iterate cache files
			if(is_file($file)) {
				unlink($file); // Delete cache file
			}
		}
	}
	
	file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
}

if (isset($_POST['save'])) {

    if (isset($_POST['logging'])) {
        $settings['proxy_logging'] = 1;
    } else {
        $settings['proxy_logging'] = 0;
    }
    
    if (isset($_POST['mail'])) {
        $settings['proxy_mail'] = 1;
    } else {
        $settings['proxy_mail'] = 0;
    }
    
    $settings['proxy_redirect'] = $_POST['redirect'];
    
    file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
}
?>
<div class="content-wrapper">

<!--CONTENT CONTAINER-->
<!--===================================================-->
<!--CONTENT CONTAINER-->
<!--===================================================-->
<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>
    <header class="shield-page-header">
        <div class="shield-page-header__main">
            <h1 class="txt-h1">وحدة الحماية: البروكسي و VPN</h1>
            <p class="txt-body-sm txt-secondary">إدارة وتكوين إعدادات الكشف عن استخدام الزوار للبروكسيات وشبكات VPN.</p>
        </div>
    </header>

    <div class="shield-grid shield-grid--3" style="margin-bottom: var(--space-6);">
        <!-- Main Column (2/3) -->
        <div style="grid-column: span 2;">
            <?php if ($settings['proxy_protection'] > 0 OR $settings['proxy_protection2'] == 1): ?>
                <div class="shield-card" style="border-inline-start: 4px solid var(--color-success); margin-bottom: var(--space-6);">
                    <div class="shield-card__body" style="display: flex; align-items: center; gap: var(--space-4);">
                        <i data-lucide="shield-check" class="icon icon-lg text-success"></i>
                        <div>
                            <h2 class="txt-h3 text-success">مفعل</h2>
                            <p class="txt-body-md txt-secondary">الموقع محمي من <strong>البروكسيات</strong></p>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="shield-card" style="border-inline-start: 4px solid var(--color-critical); margin-bottom: var(--space-6);">
                    <div class="shield-card__body" style="display: flex; align-items: center; gap: var(--space-4);">
                        <i data-lucide="shield-alert" class="icon icon-lg text-critical"></i>
                        <div>
                            <h2 class="txt-h3 text-critical">غير مفعل</h2>
                            <p class="txt-body-md txt-secondary">الموقع غير محمي من <strong>البروكسيات</strong></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="shield-card" style="margin-bottom: var(--space-6);">
                    <div class="shield-card__header">
                        <i data-lucide="shield-plus" class="icon icon-sm text-brand"></i>
                        <span class="shield-card__title">طرق كشف البروكسي</span>
                    </div>
                    <div class="shield-card__body">
                        
                        <!-- Method 1 -->
                        <div class="shield-card" style="background: var(--bg-surface-2); padding: var(--space-4); margin-bottom: var(--space-4);">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-3);">
                                <h5 class="txt-h5">طريقة الكشف رقم #1 (API)</h5>
                                <div class="dropdown">
                                    <button class="btn-shield-<?php echo ($settings['proxy_protection'] == 0) ? 'critical' : 'success'; ?> btn-shield-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php
                                        if ($settings['proxy_protection'] == 1) { echo 'IPHub'; }
                                        else if ($settings['proxy_protection'] == 2) { echo 'ProxyCheck'; }
                                        else if ($settings['proxy_protection'] == 3) { echo 'IPHunter'; }
                                        else { echo 'معطل'; }
                                        ?>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item <?php echo ($settings['proxy_protection'] == 0) ? 'active' : ''; ?>" href="?api=0">معطل</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item <?php echo ($settings['proxy_protection'] == 1) ? 'active' : ''; ?>" href="?api=1">IPHub</a>
                                        <a class="dropdown-item <?php echo ($settings['proxy_protection'] == 2) ? 'active' : ''; ?>" href="?api=2">ProxyCheck</a>
                                        <a class="dropdown-item <?php echo ($settings['proxy_protection'] == 3) ? 'active' : ''; ?>" href="?api=3">IPHunter</a>
                                    </div>
                                </div>
                            </div>
                            <hr style="border-color: var(--border-subtle); margin-bottom: var(--space-3);" />
                            <p class="txt-body-sm txt-secondary" style="margin-bottom: var(--space-4);">يتصل بواجهة API ويكشف ما إذا كان الزائر يستخدم بروكسي، VPN أو TOR.</p>
                            
                            <?php
                            if ($settings['proxy_protection'] > 0 && $settings['proxy_protection'] < 4) {
                                $apik = 'proxy_api' . $settings['proxy_protection'];
                                $key  = $settings[$apik];
                                $proxy_check = 0;

                                if ($settings['proxy_protection'] == 1) {
                                    $ch  = curl_init();
                                    $url = "http://v2.api.iphub.info/ip/8.8.8.8";
                                    curl_setopt_array($ch, [
                                        CURLOPT_URL => $url,
                                        CURLOPT_CONNECTTIMEOUT => 30,
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_HTTPHEADER => [ "X-Key: {$key}" ]
                                    ]);
                                    $response = curl_exec($ch);
                                    $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
                                    curl_close($ch);
                                    if ($httpCode >= 200 && $httpCode < 300) { $proxy_check = 1; }
                                    else if ($httpCode == 429) { $proxy_check = 429; }
                                } else if ($settings['proxy_protection'] == 2) {
                                    $key = $settings['proxy_api2'];
                                    $ch  = curl_init('http://proxycheck.io/v2/8.8.8.8?key=' . $key . '');
                                    $curl_options = [ CURLOPT_CONNECTTIMEOUT => 30, CURLOPT_RETURNTRANSFER => true ];
                                    curl_setopt_array($ch, $curl_options);
                                    $response = curl_exec($ch);
                                    curl_close($ch);
                                    $jsonc = json_decode($response);
                                    if (isset($jsonc->status) && $jsonc->status == "ok") { $proxy_check = 1; }
                                } else if ($settings['proxy_protection'] == 3) {
                                    $headers = ['X-Key: '.$key.''];
                                    $ch = curl_init("https://www.iphunter.info:8082/v1/ip/8.8.8.8");
                                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                    $response = curl_exec($ch);
                                    $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
                                    curl_close($ch);
                                    if ($httpCode >= 200 && $httpCode < 300) { $proxy_check = 1; }
                                    else if ($httpCode == 429) { $proxy_check = 429; }
                                }

                                if ($proxy_check == 0) {
                                    echo '<div style="background: var(--color-warning); color: var(--bg-base); padding: var(--space-3); border-radius: var(--radius-md); margin-bottom: var(--space-4);"><i data-lucide="alert-triangle" class="icon icon-sm"></i> مفتاح API غير صالح أو الخدمة غير متاحة</div>';
                                } else if ($proxy_check == 429) {
                                    echo '<div style="background: var(--color-warning); color: var(--bg-base); padding: var(--space-3); border-radius: var(--radius-md); margin-bottom: var(--space-4);"><i data-lucide="alert-triangle" class="icon icon-sm"></i> تم تجاوز الحد المسموح من الطلبات</div>';
                                }

                                if ($settings[$apik] == NULL OR $proxy_check == 0) {
                                    if ($settings['proxy_protection'] == 1) { $apik_url = 'https://iphub.info/pricing'; }
                                    else if ($settings['proxy_protection'] == 2) { $apik_url = 'https://proxycheck.io/pricing'; }
                                    else if ($settings['proxy_protection'] == 3) { $apik_url = 'https://www.iphunter.info/prices'; }
                            ?>
                                    <a href="<?php echo $apik_url; ?>" class="btn-shield-secondary btn-shield-sm" target="_blank" style="margin-bottom: var(--space-3);"><i data-lucide="key" class="icon icon-sm"></i> الحصول على مفتاح API</a>
                            <?php
                                }
                            }
                            ?>
                            <div style="margin-top: var(--space-3);">
                                <label class="txt-body-sm" style="font-weight: 500; display: block; margin-bottom: var(--space-2);">مفتاح API</label>
                                <input name="apikey" type="text" style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm);" <?php echo ($settings['proxy_protection'] > 0) ? 'value="' . $settings[$apik] . '"' : 'disabled'; ?>>
                            </div>
                        </div>

                        <!-- Method 2 -->
                        <div class="shield-card" style="background: var(--bg-surface-2); padding: var(--space-4); margin-bottom: var(--space-4);">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <h5 class="txt-h5" style="margin-bottom: var(--space-2);">طريقة الكشف رقم #2 (HTTP Headers)</h5>
                                    <p class="txt-body-sm txt-secondary">يقوم بفحص رؤوس اتصال HTTP للزائر لاكتشاف وجود بروكسي</p>
                                </div>
                                <input type="checkbox" name="protection2" class="psec-switch" <?php echo ($settings['proxy_protection2'] == 1) ? 'checked="checked"' : ''; ?> />
                            </div>
                        </div>

                        <div style="text-align: center;">
                            <button class="btn-shield-primary" name="save2" type="submit">
                                <i data-lucide="save" class="icon icon-sm"></i> حفظ الإعدادات
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
                    <span class="shield-card__title">ما هو البروكسي؟</span>
                </div>
                <div class="shield-card__body">
                    <p class="txt-body-sm txt-secondary" style="line-height: 1.6;"><strong>بروكسي</strong> أو <strong>خادم بروكسي</strong> هو جهاز كمبيوتر آخر يعمل كوسيط تُعالج من خلاله طلبات الإنترنت. عند الاتصال به، يرسل جهازك الطلب إلى خادم البروكسي، الذي بدوره يُعالج الطلب ويعيد إليك ما طلبته.</p>
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
                                    <p class="txt-body-md" style="font-weight: 500; margin: 0;">تسجيل الأحداث (Logging)</p>
                                    <p class="txt-body-sm txt-secondary" style="margin: 0;">تسجيل التهديدات في سجلات النظام</p>
                                </div>
                                <input type="checkbox" name="logging" class="psec-switch" <?php echo ($settings['proxy_logging'] == 1) ? 'checked="checked"' : ''; ?> />
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <p class="txt-body-md" style="font-weight: 500; margin: 0;">إشعارات البريد</p>
                                    <p class="txt-body-sm txt-secondary" style="margin: 0;">تلقي تنبيه عند اكتشاف تهديد</p>
                                </div>
                                <input type="checkbox" name="mail" class="psec-switch" <?php echo ($settings['proxy_mail'] == 1) ? 'checked="checked"' : ''; ?> />
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
if ($settings['proxy_protection'] > 0 OR $settings['proxy_protection2'] == 1) {
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
        <h3 class="shield-card">بروكسي - وحدة الحماية</h3>
    </div>
    <div class="shield-card">
<?php
if ($settings['proxy_protection'] > 0 OR $settings['proxy_protection2'] == 1) {
echo '
    <h1 class="pm_enabled"><i class="fas fa-check-circle"></i> مفعّلة</h1>
    <p>الموقع محمي من <strong>البروكسيات</strong></p>
';
} else {
echo '
    <h1 class="pm_disabled"><i class="fas fa-times-circle"></i> غير مفعّلة</h1>
    <p>الموقع غير محمي من <strong>البروكسيات</strong></p>
';
}
?>
    </div>
</div>

    <div class="shield-card">
        <div class="shield-card">
            <h3 class="shield-card"><i class="fas fa-shield-alt"></i> طرق كشف البروكسي</h3>
        </div>
        <div class="shield-card">
        <form class="form-horizontal form-bordered" action="" method="post">
            <div class="row">
                <div class="col-md-12">
                    <div class="shield-card">
                    <div class="row">
                    <div class="col-md-6">
                    <h5>طريقة الكشف رقم #1</h5>
                    </div>
                    <div class="col-md-6">
                    <div class="dropdown">
                      <button class="btn btn-<?php
if ($settings['proxy_protection'] == 0) {
echo 'danger';
} else {
echo 'success';
}
?> dropdown-toggle float-right" class="width100" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<?php
if ($settings['proxy_protection'] == 1) {
echo 'IPHub';
} else if ($settings['proxy_protection'] == 2) {
echo 'ProxyCheck';
} else if ($settings['proxy_protection'] == 3) {
echo 'IPHunter';
} else {
echo 'API كشف البروكسي';
}
?>
                      </button>
                      <div class="dropdown-menu" class="width100">
                        <a class="dropdown-item <?php
if ($settings['proxy_protection'] == 0) {
echo 'active';
}
?>" href="?api=0">معطل</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item <?php
if ($settings['proxy_protection'] == 1) {
echo 'active';
}
?>" href="?api=1">IPHub</a>
                        <a class="dropdown-item <?php
if ($settings['proxy_protection'] == 2) {
echo 'active';
}
?>" href="?api=2">ProxyCheck</a>
                        <a class="dropdown-item <?php
if ($settings['proxy_protection'] == 3) {
echo 'active';
}
?>" href="?api=3">IPHunter</a>
                      </div>
                    </div>
                    </div>
                    </div>
                    <hr />
                    يتصل بواجهة API ويكشف ما إذا كان الزائر يستخدم بروكسي، VPN أو TOR
                    <br /><br />
<?php
if ($settings['proxy_protection'] > 0 && $settings['proxy_protection'] < 4) {

$apik = 'proxy_api' . $settings['proxy_protection'];
$key  = $settings[$apik];

$proxy_check = 0;

if ($settings['proxy_protection'] == 1) {
    //Invalid API Key ==> Offline
    $ch  = curl_init();
    $url = "http://v2.api.iphub.info/ip/8.8.8.8";
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_CONNECTTIMEOUT => 30,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [ "X-Key: {$key}" ]
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);
    
    if ($httpCode >= 200 && $httpCode < 300) {
        $proxy_check = 1;
    } else if ($httpCode == 429) {
        $proxy_check = 429;
    }
    
} else if ($settings['proxy_protection'] == 2) {
    
    $key = $settings['proxy_api2'];
        
    $ch           = curl_init('http://proxycheck.io/v2/8.8.8.8?key=' . $key . '');
    $curl_options = array(
        CURLOPT_CONNECTTIMEOUT => 30,
        CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $curl_options);
    $response = curl_exec($ch);
    curl_close($ch);

    $jsonc = json_decode($response);
    
    if (isset($jsonc->status) && $jsonc->status == "ok") {
        $proxy_check = 1;
    }
    
} else if ($settings['proxy_protection'] == 3) {
    $headers = [
        'X-Key: '.$key.'',
    ];
    $ch = curl_init("https://www.iphunter.info:8082/v1/ip/8.8.8.8");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);
    
    if ($httpCode >= 200 && $httpCode < 300) {
        $proxy_check = 1;
    } else if ($httpCode == 429) {
        $proxy_check = 429;
    }
}

if ($proxy_check == 0) {
    echo '<div class="callout callout-warning" role="callout">مفتاح API غير صالح أو الخدمة غير متاحة</div>';
} else if ($proxy_check == 429) {
    echo '<div class="callout callout-warning" role="callout">تم تجاوز الحد المسموح من الطلبات</div>';
}

if ($settings[$apik] == NULL OR $proxy_check == 0) {
    if ($settings['proxy_protection'] == 1) {
        $apik_url = 'https://iphub.info/pricing';
    } else if ($settings['proxy_protection'] == 2) {
        $apik_url = 'https://proxycheck.io/pricing';
    } else if ($settings['proxy_protection'] == 3) {
        $apik_url = 'https://www.iphunter.info/prices';
    }
?>
                    <a href="<?php echo $apik_url; ?>" class="btn btn-info btn-block text-white" target="_blank"><i class="fas fa-key"></i> الحصول على مفتاح API</a><br />
<?php
}
}
?>
                    <p>مفتاح API</p>
                    <input name="apikey" class="form-control" type="text" <?php
if ($settings['proxy_protection'] > 0) {
echo 'value="' . $settings[$apik] . '"';
} else {
echo 'disabled';
}
?>>
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-md-12">
                <div class="shield-card">
                    <div class="row">
                        <div class="col-md-10">
                            <h5>طريقة الكشف رقم #2</h5>
                        </div>
                        <div class="col-md-2">
                            <input type="checkbox" name="protection2" class="psec-switch" <?php
if ($settings['proxy_protection2'] == 1) {
echo 'checked="checked"';
}
?> />
                        </div>
                    </div><hr />
                    يقوم بفحص رؤوس اتصال HTTP للزائر لاكتشاف وجود بروكسي
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
        <h3 class="shield-card"><i class="fas fa-info-circle"></i> ما هو البروكسي؟</h3>
    </div>
    <div class="shield-card">
        <strong>بروكسي</strong> أو <strong>خادم بروكسي</strong> هو جهاز كمبيوتر آخر يعمل كوسيط تُعالج من خلاله طلبات الإنترنت. عند الاتصال به، يرسل جهازك الطلب إلى خادم البروكسي، الذي بدوره يُعالج الطلب ويعيد إليك ما طلبته.
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
                <p>تسجيل الأحداث</p>
                    <input type="checkbox" name="logging" class="psec-switch" <?php
if ($settings['proxy_logging'] == 1) {
echo 'checked="checked"';
}
?> /><br />
                <span class="text-muted">تسجيل التهديدات المكتشفة</span>
            </li>
            <li class="list-group-item">
                <p>إشعارات البريد الإلكتروني</p>
                    <input type="checkbox" name="mail" class="psec-switch" <?php
if ($settings['proxy_mail'] == 1) {
echo 'checked="checked"';
}
?> /><br />
                <span class="text-muted">تلقي إشعارات عبر البريد عند اكتشاف تهديد من هذا النوع</span>
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
