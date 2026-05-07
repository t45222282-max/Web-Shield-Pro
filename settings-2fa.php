<?php
require "core.php";
require "modules/TwoFactorAuth.php";
head();

$tfa = new TwoFactorAuth();
$error = "";
$success = "";

// Handle Enable/Disable requests
if (isset($_POST['enable_2fa'])) {
    $code = $_POST['auth_code'];
    $secret = $_POST['temp_secret'];
    
    if ($tfa->verifyCode($secret, $code)) {
        $settings['2fa_enabled'] = 1;
        $settings['2fa_secret'] = $secret;
        file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
        $success = "تم تفعيل المصادقة الثنائية بنجاح!";
    } else {
        $error = "رمز التحقق غير صحيح، يرجى المحاولة مرة أخرى.";
    }
}

if (isset($_POST['disable_2fa'])) {
    $settings['2fa_enabled'] = 0;
    file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
    $success = "تم تعطيل المصادقة الثنائية.";
}

$is_enabled = isset($settings['2fa_enabled']) && $settings['2fa_enabled'] == 1;
$temp_secret = $tfa->createSecret();
$qr_code_url = $tfa->getQRCodeGoogleUrl('Web Shield Pro (' . $settings['username'] . ')', $temp_secret, 'ShieldUI');
?>

<div class="content-wrapper">
    <header class="shield-page-header">
        <div class="shield-page-header__main">
            <h1 class="txt-h1"><i class="fas fa-key"></i> المصادقة الثنائية (2FA)</h1>
            <p class="txt-body-sm txt-secondary">قم بتأمين حسابك بطبقة حماية إضافية باستخدام تطبيق Google Authenticator.</p>
        </div>
    </header>

    <div class="content">
        <div class="container-fluid">
            <div class="shield-grid shield-grid--1" style="max-width: 700px; margin: 0 auto;">
                
                <?php if ($success): ?>
                    <div class="alert alert-success neon-border-success mb-4">
                        <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger neon-border-danger mb-4">
                        <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <div class="shield-card">
                    <div class="shield-card__header">
                        <span class="shield-card__title">حالة الحماية الحالية</span>
                        <?php if ($is_enabled): ?>
                            <span class="badge badge-success"><i class="fas fa-shield-alt"></i> مفعلة</span>
                        <?php else: ?>
                            <span class="badge badge-secondary"><i class="fas fa-unlock"></i> غير مفعلة</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="shield-card__body text-center py-5">
                        <?php if (!$is_enabled): ?>
                            <div class="mb-4">
                                <i class="fas fa-shield-virus fa-4x neon-text-info mb-3"></i>
                                <h3 class="txt-h3">تفعيل الحماية المزدوجة</h3>
                                <p class="txt-secondary">يرجى مسح الرمز أدناه باستخدام تطبيق **Google Authenticator** أو **Authy**.</p>
                            </div>

                            <div class="qr-container mb-4" style="background: white; padding: 15px; display: inline-block; border-radius: 12px; box-shadow: 0 0 20px rgba(0,210,255,0.2);">
                                <img src="<?php echo $qr_code_url; ?>" alt="QR Code" style="display: block;">
                            </div>

                            <div class="mb-4">
                                <p class="txt-body-sm">أو أدخل الرمز يدوياً: <code class="neon-text-info" style="font-size: 1.2em; letter-spacing: 2px;"><?php echo $temp_secret; ?></code></p>
                            </div>

                            <form method="post" class="mt-4">
                                <input type="hidden" name="temp_secret" value="<?php echo $temp_secret; ?>">
                                <div class="form-group mb-4" style="max-width: 300px; margin-left: auto; margin-right: auto;">
                                    <label class="txt-body-sm mb-2">أدخل رمز التحقق (6 أرقام):</label>
                                    <input type="text" name="auth_code" class="shield-input text-center" placeholder="000000" maxlength="6" pattern="\d{6}" required style="font-size: 1.5em; letter-spacing: 5px;">
                                </div>
                                <button type="submit" name="enable_2fa" class="btn-shield-primary btn-block">
                                    <i class="fas fa-check-circle"></i> تأكيد وتفعيل الحماية
                                </button>
                            </form>

                        <?php else: ?>
                            <div class="py-4">
                                <i class="fas fa-user-shield fa-5x neon-text-success mb-4"></i>
                                <h2 class="txt-h2 mb-3">حسابك محمي بنجاح</h2>
                                <p class="txt-secondary mb-5">المصادقة الثنائية نشطة الآن. سيُطلب منك الرمز في كل مرة تقوم فيها بتسجيل الدخول.</p>
                                
                                <form method="post" onsubmit="return confirm('هل أنت متأكد من تعطيل المصادقة الثنائية؟ سيقلل هذا من أمان حسابك.');">
                                    <button type="submit" name="disable_2fa" class="btn btn-outline-danger btn-flat">
                                        <i class="fas fa-power-off"></i> تعطيل المصادقة الثنائية
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="shield-card mt-4">
                    <div class="shield-card__body">
                        <h4 class="txt-h4 mb-3"><i class="fas fa-info-circle neon-text-info"></i> لماذا يجب تفعيل 2FA؟</h4>
                        <ul class="txt-secondary txt-body-sm" style="line-height: 1.8;">
                            <li>حتى لو عرف المخترق كلمة مرورك، لن يستطيع الدخول بدون هاتفك.</li>
                            <li>حماية ضد هجمات التخمين (Brute Force).</li>
                            <li>تأمين لوحة التحكم الحساسة لدرع الويب.</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
footer();
?>
