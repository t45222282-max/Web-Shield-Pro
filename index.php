<?php
$configfile = 'config.php';
if (!file_exists($configfile)) {
    echo '<meta http-equiv="refresh" content="0; url=install" />';
    exit();
}

include "config.php";

if(!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['sec-username'])) {
    $uname = $_SESSION['sec-username'];
    if ($uname == $settings['username']) {
        echo '<meta http-equiv="refresh" content="0; url=dashboard.php" />';
        exit;
    }
}

$_GET  = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

$error = 0;
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Antonov_WEB">
        <meta name="robots" content="noindex, nofollow">
        <title>درع الويب</title>

        <!-- CSS -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.7.1/css/all.css">
        <link rel="stylesheet" href="dist/css/adminlte.min.css">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="dist/css/customm.css">

        <?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/shield/shield.css">
        <link rel="stylesheet" href="assets/css/shield/pages/_login.css">
        <script>
          document.documentElement.setAttribute('data-ui-engine', 'shield');
          document.documentElement.setAttribute('data-theme', '<?php echo htmlspecialchars($settings['ui_theme'] ?? 'dark'); ?>');
          document.documentElement.classList.add('shield-login-page');
        </script>
        <?php endif; ?>
        <!-- Favicon -->
        <link rel="shortcut icon" href="assets/img/favicon.png">
    </head>

    <body class="login-page <?php if ($settings['dark_mode'] == 1) echo 'dark-mode'; ?>">

<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>

<!-- Shield Login Page -->
<div class="shield-login-bg"></div>
<div class="shield-login-wrapper">
    <div class="shield-login-card">

        <!-- Logo -->
        <div class="shield-login-logo">
            <div class="shield-login-logo__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/><path d="m9 12 2 2 4-4"/></svg>
            </div>
            <h1 class="shield-login-logo__title">درع الويب</h1>
            <p class="shield-login-logo__subtitle">تسجيل دخول مركز التحكم</p>
        </div>

        <form action="" method="post" class="shield-login-form">

<?php
if (isset($_POST['signin'])) {
    $ip = addslashes(htmlentities($_SERVER['REMOTE_ADDR']));
    if ($ip == "::1") { $ip = "127.0.0.1"; }
    @$date = @date("d F Y");
    @$time = @date("H:i");
    $username = mysqli_real_escape_string($mysqli, $_POST['username']);
    $password = hash('sha256', $_POST['password']);
    if ($username == $settings['username'] && $password == $settings['password']) {
        $checklh = $mysqli->query("SELECT id FROM `psec_logins` WHERE `username`='$username' AND ip='$ip' AND date='$date' AND time='$time' AND successful='1'");
        if (mysqli_num_rows($checklh) == 0) {
            $log = $mysqli->query("INSERT INTO `psec_logins` (username, ip, date, time, successful) VALUES ('$username', '$ip', '$date', '$time', '1')"  );
        }
        if (isset($settings['2fa_enabled']) && $settings['2fa_enabled'] == 1) {
            $_SESSION['sec-2fa-pending'] = $username;
            echo '<meta http-equiv="refresh" content="0;url=login-2fa.php">';
        } else {
            $_SESSION['sec-username'] = $username;
            echo '<meta http-equiv="refresh" content="0;url=dashboard.php">';
        }
    } else {
        $checklh = $mysqli->query("SELECT id FROM `psec_logins` WHERE `username`='$username' AND ip='$ip' AND date='$date' AND time='$time' AND successful='0'");
        if (mysqli_num_rows($checklh) == 0) {
            $log = $mysqli->query("INSERT INTO `psec_logins` (username, ip, date, time, successful) VALUES ('$username', '$ip', '$date', '$time', '0')" );
        }
        echo '<div class="shield-login-error"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> اسم المستخدم أو كلمة المرور غير صحيحة.</div>';
        $error = 1;
    }
}
?>

            <!-- Username -->
            <div class="shield-login-form__group">
                <label class="shield-login-form__label" for="login-username">اسم المستخدم</label>
                <div class="input-shield input-shield--with-icon">
                    <svg class="input-shield__icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <input type="text" id="login-username" name="username" class="shield-input <?php echo ($error == 1) ? 'shield-input--error' : ''; ?>" placeholder="أدخل اسم المستخدم" required <?php echo ($error == 1) ? 'autofocus' : ''; ?>>
                </div>
            </div>

            <!-- Password -->
            <div class="shield-login-form__group">
                <label class="shield-login-form__label" for="login-password">كلمة المرور</label>
                <div class="input-shield input-shield--with-icon">
                    <svg class="input-shield__icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <input type="password" id="login-password" name="password" class="shield-input" placeholder="أدخل كلمة المرور" required>
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" name="signin" class="btn-shield-primary shield-login-submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                دخول
            </button>

        </form>

    </div>
    <p class="shield-login-footer">v<?php global $psec_version; echo $psec_version ?? '1.0'; ?> · Secured by Web Shield Engine</p>
</div>
<script src="https://unpkg.com/lucide@latest"></script>
<script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>

<?php else: ?>
    <body class="login-page <?php
if ($settings['dark_mode'] == 1) {
    echo 'dark-mode';
}
?>">
        <div class="login-box">
            <form action="" method="post">
                <div class="shield-card">
                    <div class="shield-card">
                        <h1><i class="fas fa-shield-alt"></i><b>درع الويب</b></h1>
                    </div>
                    <div class="shield-card">
                        <div class="shield-card">
<?php
if (isset($_POST['signin'])) {
    $ip = addslashes(htmlentities($_SERVER['REMOTE_ADDR']));
    if ($ip == "::1") {
        $ip = "127.0.0.1";
    }
    @$date = @date("d F Y");
    @$time = @date("H:i");
    
    $username = mysqli_real_escape_string($mysqli, $_POST['username']);
    $password = hash('sha256', $_POST['password']);

    if ($username == $settings['username'] && $password == $settings['password']) {
        $checklh = $mysqli->query("SELECT id FROM `psec_logins` WHERE `username`='$username' AND ip='$ip' AND date='$date' AND time='$time' AND successful='1'");
        if (mysqli_num_rows($checklh) == 0) {
            $log = $mysqli->query("INSERT INTO `psec_logins` (username, ip, date, time, successful) VALUES ('$username', '$ip', '$date', '$time', '1')");
        }
        
        if (isset($settings['2fa_enabled']) && $settings['2fa_enabled'] == 1) {
            $_SESSION['sec-2fa-pending'] = $username;
            echo '<meta http-equiv="refresh" content="0;url=login-2fa.php">';
        } else {
            $_SESSION['sec-username'] = $username;
            echo '<meta http-equiv="refresh" content="0;url=dashboard.php">';
        }
    } else {
        $checklh = $mysqli->query("SELECT id FROM `psec_logins` WHERE `username`='$username' AND ip='$ip' AND date='$date' AND time='$time' AND successful='0'");
        if (mysqli_num_rows($checklh) == 0) {
            $log = $mysqli->query("INSERT INTO `psec_logins` (username, ip, date, time, successful) VALUES ('$username', '$ip', '$date', '$time', '0')");
        }
        
        echo '
        <div class="alert alert-danger">
              <i class="fas fa-exclamation-circle"></i> The entered <strong>Username</strong> or <strong>Password</strong> is incorrect.
        </div>';
        $error = 1;
    }
}
?> 
                            <div class="form-group has-feedback <?php
if ($error == 1) {
    echo 'has-danger';
}
?>">
                                <div class="input-group mb-3">
                                    <input type="username" name="username" class="form-control <?php
if ($error == 1) {
    echo 'is-invalid';
}
?>" placeholder="Username" <?php
if ($error == 1) {
    echo 'autofocus';
}
?> required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="input-group mb-3">
                                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" name="signin" class="btn btn-md btn-primary btn-block btn-flat"><i class="fas fa-check"></i> تسجيل الدخول </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form> 
            </div>
        </body>
<?php endif; ?>
</body>
</html>
