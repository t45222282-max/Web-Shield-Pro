<?php
/**
 * login-2fa.php
 * Two-Factor Authentication Verification Page
 */
require "config.php";
require "modules/TwoFactorAuth.php";

if(!isset($_SESSION)) {
    session_start();
}

// Check if we are in 2FA pending state
if (!isset($_SESSION['sec-2fa-pending'])) {
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit;
}

$error = 0;
$tfa = new TwoFactorAuth();

if (isset($_POST['verify_2fa'])) {
    $code = $_POST['auth_code'];
    $username = $_SESSION['sec-2fa-pending'];
    
    if ($tfa->verifyCode($settings['2fa_secret'], $code)) {
        // Success! Finalize login
        $_SESSION['sec-username'] = $username;
        unset($_SESSION['sec-2fa-pending']);
        echo '<meta http-equiv="refresh" content="0;url=dashboard.php">';
        exit;
    } else {
        $error = 1;
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr" data-ui-engine="shield" data-theme="<?php echo htmlspecialchars($settings['ui_theme'] ?? 'dark'); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>المصادقة الثنائية - درع الويب</title>
        <link rel="stylesheet" href="assets/css/shield/shield.css">
        <link rel="stylesheet" href="assets/css/shield/pages/_login.css">
        <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    </head>
    <body class="shield-login-page">
        <div class="shield-login-bg"></div>
        <div class="shield-login-wrapper">
            <div class="shield-login-card">
                <div class="shield-login-logo">
                    <div class="shield-login-logo__icon" style="color: var(--brand-info);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                    <h1 class="shield-login-logo__title">المصادقة الثنائية</h1>
                    <p class="shield-login-logo__subtitle">يرجى إدخال الرمز من تطبيق Authenticator</p>
                </div>

                <form method="post" class="shield-login-form">
                    <?php if ($error == 1): ?>
                        <div class="shield-login-error">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            رمز التحقق غير صحيح.
                        </div>
                    <?php endif; ?>

                    <div class="shield-login-form__group text-center">
                        <label class="shield-login-form__label">رمز التحقق</label>
                        <input type="text" name="auth_code" class="shield-input text-center <?php echo ($error == 1) ? 'shield-input--error' : ''; ?>" placeholder="000000" maxlength="6" pattern="\d{6}" required autofocus style="font-size: 2em; letter-spacing: 8px; height: 70px;">
                    </div>

                    <button type="submit" name="verify_2fa" class="btn-shield-primary shield-login-submit">
                        تحقق ودخول
                    </button>
                    
                    <a href="logout.php" class="txt-body-xs txt-secondary text-center d-block mt-3" style="text-decoration: none;">إلغاء وتسجيل الخروج</a>
                </form>
            </div>
            <p class="shield-login-footer">Secured by Web Shield Engine</p>
        </div>
    </body>
</html>
