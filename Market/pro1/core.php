<?php

$psec_version = "1.0";

$configfile = 'config.php';
if (!file_exists($configfile)) {
    echo '<meta http-equiv="refresh" content="0; url=install" />';
    exit();
}

require 'config.php';

if(!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['sec-username'])) {
    $uname = $_SESSION['sec-username'];
    if ($uname != $settings['username']) {
        echo '<meta http-equiv="refresh" content="0; url=index.php" />';
        exit;
    }
} else {
    echo '<meta http-equiv="refresh" content="0; url=index.php" />';
    exit;
}

if (basename($_SERVER['SCRIPT_NAME']) != 'warning-pages.php') {
    $_GET  = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
}

if($settings['dark_mode']){
    $thead = 'thead-dark';
} else {
    $thead = 'thead-light';
}

function get_banned($ip)
{
    include 'config.php';

    $query = $mysqli->query("SELECT * FROM `psec_bans` WHERE ip='$ip' LIMIT 1");
    $count = mysqli_num_rows($query);
    if ($count > 0) {
        return 1;
    } else {
        return 0;
    }
}

function get_bannedid($ip)
{
    include 'config.php';

    $query = $mysqli->query("SELECT * FROM `psec_bans` WHERE ip='$ip' LIMIT 1");
    $row   = mysqli_fetch_array($query);
    return $row['id'];
}

function head()
{
    include 'config.php';
?>
<!DOCTYPE html>
<html class="height_auto">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Antonov_WEB">
    <meta name="robots" content="noindex, nofollow">
    <link rel="shortcut icon" href="assets/img/favicon.png">
    <title>درع الويب</title>

    <!-- STYLESHEETS -->
    <!--=================================================-->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link href="assets/css/psec.css" rel="stylesheet">
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Bootstrap 4 RTL -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css">
    <!-- Custom style for RTL -->
    <link rel="stylesheet" href="dist/css/custom.css">
    <link rel="stylesheet" href="dist/css/custom-dashboard.css">

    
    <!-- Switchery -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    
    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/v/bs4/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-html5-3.2.0/r-3.0.3/datatables.min.css" rel="stylesheet">
    
    <!-- Flags -->
    <link href="assets/plugins/flags/flags.css" rel="stylesheet">
    
    <!-- Custom styles for footer and navbar -->
    <style>
        .main-footer {
            text-align: right; /* محاذاة إلى اليمين (اليسار في الواجهة العربية) */
            direction: rtl; /* التأكد من الاتجاه من اليمين إلى اليسار */
            padding: 10px 20px;
            background-color: #f8f9fa; /* لون خلفية AdminLTE الافتراضي */
            border-top: 1px solid #dee2e6; /* توافق مع AdminLTE */
            width: auto; /* السماح للتذييل باتباع عرض الحاوية الأم */
            max-width: 100%; /* منع التوسع خارج الحاوية */
            display: flex;
            align-items: center;
            justify-content: flex-end; /* محاذاة العناصر إلى اليمين */
            margin: 0; /* إزالة أي هوامش قد تتسبب في التوسع */
        }
        
        .wrapper {
            position: relative;
            overflow-x: hidden; /* منع التوسع الأفقي للحاوية الأم */
        }
        
        .scroll-btn {
            margin-left: 15px; /* مسافة بين زر التمرير والنص */
        }
        
        .main-footer strong {
            font-size: 14px;
            white-space: nowrap; /* منع التفاف النص */
        }
        
        .main-footer a {
            color: #007bff;
            text-decoration: none;
        }
        
        .main-footer a:hover {
            text-decoration: underline;
        }
        
        /* تطبيق نفس أسلوب التذييل على الشريط العلوي */
        .main-header .navbar {
            display: flex;
            align-items: center;
            direction: rtl;
        }
        
        .main-header .navbar-start {
            display: flex;
            align-items: center;
        }
        
        .main-header .navbar-end {
            display: flex;
            align-items: center;
            margin-left: auto; /* دفع الأيقونات إلى اليسار (اليمين في rtl) */
        }
    </style>

    <!-- SCRIPTS -->
    <!--=================================================-->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
    
<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'dashboard.php' || basename($_SERVER['SCRIPT_NAME']) == 'visit-analytics.php') {
        echo '
    <!--Chart.js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>';
    }
?>

<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'log-details.php' || basename($_SERVER['SCRIPT_NAME']) == 'ip-lookup.php') {
        echo '
    <!-- Map -->
    <script src="https://openlayers.org/api/OpenLayers.js"></script>';
    }
?>
</head>

<body class="sidebar-mini layout-fixed layout-navbar-fixed control-sidebar-slide-open <?php
if ($settings['dark_mode'] == 1) {
    echo 'dark-mode';
}
?> height_auto">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-dark">
        <div class="navbar-start">
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                </li>
            </ul>

            <form class="form-inline" action="ip-lookup.php" method="get">
                <div class="input-group input-group-sm">
                    <input type="text" name="ip" class="form-control form-control-navbar" placeholder="بحث IP" required />
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-navbar"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>

        <div class="navbar-end">
            <ul class="nav navbar-nav">
                <li class="nav-item d-none d-md-block">
                    <a href="<?php echo $settings['site_url']; ?>" class="nav-link" target="_blank" data-toggle="tooltip" title="زيارة الموقع" data-placement="bottom">
                        <i class="fas fa-desktop"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="settings.php" class="nav-link" data-toggle="tooltip" title="إعدادات" data-placement="bottom"><i class="fas fa-cogs"></i></a>
                </li>
            </ul>
        </div>
    </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <center><a href="dashboard.php" class="brand-link">
      <span class="brand-text font-weight-light"><i class="fab fa-get-pocket"></i> درع الويب</span>
    </a></center>

    <div class="sidebar">

      <div class="user-panel mt-3 d-flex align-content-center justify-content-center flex-wrap">
          <p class="margin_auto"><a href="account.php" class="btn btn-sm btn-secondary btn-flat"><i class="fas fa-user fa-fw"></i> حساب</a>
            <a href="logout.php" class="btn btn-sm btn-danger btn-flat"><i class="fas fa-sign-out-alt fa-fw"></i> تسجيل الخروج</a></p>
      </div>

      <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar nav-compact flex-column" data-widget="treeview" role="menu">
        <li class="nav-header">تنقل</li>

        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'dashboard.php') {
        echo 'active';
    }
?>">
           <a href="dashboard.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'dashboard.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-home"></i>  <p>لوحة التحكم</p>
           </a>
        </li>

        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'system-info.php') {
        echo 'active';
    }
?>">
           <a href="system-info.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'system-info.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-info-circle"></i>  <p>معلومات النظام</p>
           </a>
        </li>
          
        <li class="nav-item has-treeview <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'ip-whitelist.php' OR basename($_SERVER['SCRIPT_NAME']) == 'file-whitelist.php') {
        echo 'menu-open';
    }
?>">
           <a href="#" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'ip-whitelist.php' OR basename($_SERVER['SCRIPT_NAME']) == 'file-whitelist.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-flag"></i>  <p> القائمة البيضاء <i class="fas fa-angle-right right"></i>
           </p></a>
           <ul class="nav nav-treeview">
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'ip-whitelist.php') {
        echo 'active';
    }
?>"><a href="ip-whitelist.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'ip-whitelist.php') {
        echo 'active';
    }
?>"><i class="fas fa-user"></i>  <p> IP القائمة البيضاء </p></a></li>
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'file-whitelist.php') {
        echo 'active';
    }
?>"><a href="file-whitelist.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'file-whitelist.php') {
        echo 'active';
    }
?>"><i class="far fa-file-alt"></i>  <p>File القائمة البيضاء</p></a></li>
           </ul>
        </li>

        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'users.php') {
        echo 'active';
    }
?>">
           <a href="login-history.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'login-history.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-history"></i>  <p>سجل الدخول</p>
           </a>
        </li>

        <li class="nav-header">حماية</li>

        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'sql-injection.php') {
        echo 'active';
    }
?>">
           <a href="sql-injection.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'sql-injection.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-code"></i>  <p>حقن SQL
<?php
    if ($settings['sqli_protection'] == 1) {
        echo '<span class="right badge badge-success">ON</span>';
    } else {
        echo '<span class="right badge badge-danger">OFF</span>';
    }
?>
           </p></a>
        </li>

        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'badbots.php') {
        echo 'active';
    }
?>">
           <a href="badbots.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'badbots.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-user-secret"></i>  <p>الروبوتات السيئة
<?php
    if ($settings['badbot_protection'] == 1 OR $settings['badbot_protection2'] == 1 OR $settings['badbot_protection3'] == 1) {
        echo '<span class="right badge badge-success">ON</span>';
    } else {
        echo '<span class="right badge badge-danger">OFF</span>';
    }
?>
           </p></a>
        </li>

        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'proxy.php') {
        echo 'active';
    }
?>">
           <a href="proxy.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'proxy.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-globe"></i>  <p>الوكيل
<?php
    if ($settings['proxy_protection'] > 0 OR $settings['proxy_protection2'] == 1) {
        echo '<span class="right badge badge-success">ON</span>';
    } else {
        echo '<span class="right badge badge-danger">OFF</span>';
    }
?>
           </p></a>
        </li>

        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'spam.php') {
        echo 'active';
    }
?>">
           <a href="spam.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'spam.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-keyboard"></i>  <p>المزعجون
<?php
    $querysp = $mysqli->query("SELECT * FROM `psec_dnsbl-databases`");
    if ($settings['spam_protection'] == 1 && mysqli_num_rows($querysp) > 0) {
        echo '<span class="right badge badge-success">ON</span>';
    } else {
        echo '<span class="right badge badge-danger">OFF</span>';
    }
?>
           </p></a>
        </li>

<?php
    $lquery1 = $mysqli->query("SELECT * FROM `psec_logs`");
    $lcount1 = mysqli_num_rows($lquery1);
    $lquery2 = $mysqli->query("SELECT * FROM `psec_logs` WHERE `type`='SQLi'");
    $lcount2 = mysqli_num_rows($lquery2);
    $lquery3 = $mysqli->query("SELECT * FROM `psec_logs` WHERE `type`='Bad Bot' or `type`='Fake Bot' or type='Missing User-Agent header' or type='Missing header Accept' or type='Invalid IP Address header'");
    $lcount3 = mysqli_num_rows($lquery3);
    $lquery4 = $mysqli->query("SELECT * FROM `psec_logs` WHERE `type`='Proxy'");
    $lcount4 = mysqli_num_rows($lquery4);
    $lquery5 = $mysqli->query("SELECT * FROM `psec_logs` WHERE `type`='Spammer'");
    $lcount5 = mysqli_num_rows($lquery5);
?>
        <li class="nav-item has-treeview <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'all-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'sqli-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'badbot-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'proxy-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'spammer-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'log-details.php') {
        echo 'menu-open';
    }
?>">
           <a href="#" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'all-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'sqli-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'badbot-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'proxy-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'spammer-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'log-details.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-align-justify"></i>  <p>سجلات <i class="fas fa-angle-right right"></i>
           </p></a>
           <ul class="nav nav-treeview">
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'all-logs.php') {
        echo 'active';
    }
?>"><a href="all-logs.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'all-logs.php') {
        echo 'active';
    }
?>"><i class="fas fa-align-justify"></i>  <p>جميع السجلات <span class="badge right badge-primary"><?php
    echo $lcount1;
?></span></p></a></li>
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'sqli-logs.php') {
        echo 'active';
    }
?>"><a href="sqli-logs.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'sqli-logs.php') {
        echo 'active';
    }
?>"><i class="fas fa-code"></i>  <p>سجلات SQLi <span class="badge right badge-info"><?php
    echo $lcount2;
?></span></p></a></li>
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'badbot-logs.php') {
        echo 'active';
    }
?>"><a href="badbot-logs.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'badbot-logs.php') {
        echo 'active';
    }
?>"><i class="fas fa-robot"></i>  <p>سجلات الروبوتات السيئة <span class="badge right badge-danger"><?php
    echo $lcount3;
?></span></p></a></li>
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'proxy-logs.php') {
        echo 'active';
    }
?>"><a href="proxy-logs.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'proxy-logs.php') {
        echo 'active';
    }
?>"><i class="fas fa-globe"></i>  <p>سجلات الوكيل <span class="badge right badge-success"><?php
    echo $lcount4;
?></span></p></a></li>
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'spammer-logs.php') {
        echo 'active';
    }
?>"><a href="spammer-logs.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'spammer-logs.php') {
        echo 'active';
    }
?>"><i class="fas fa-keyboard"></i>  <p>سجلات المزعجون <span class="right badge badge-warning"><?php
    echo $lcount5;
?></span></p></a></li>
           </ul>
        </li>

<?php
    $bquery1 = $mysqli->query("SELECT * FROM `psec_bans`");
    $bcount1 = mysqli_num_rows($bquery1);

    $bquery2 = $mysqli->query("SELECT * FROM `psec_bans-country`");
    $bcount2 = mysqli_num_rows($bquery2);

    $bquery3 = $mysqli->query("SELECT * FROM `psec_bans-ranges`");
    $bcount3 = mysqli_num_rows($bquery3);

    $bquery4 = $mysqli->query("SELECT * FROM `psec_bans-other`");
    $bcount4 = mysqli_num_rows($bquery4);
?>
        <li class="nav-item has-treeview <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-ip.php' OR basename($_SERVER['SCRIPT_NAME']) == 'bans-iprange.php' OR basename($_SERVER['SCRIPT_NAME']) == 'bans-country.php' OR basename($_SERVER['SCRIPT_NAME']) == 'bans-other.php') {
        echo 'menu-open';
    }
?>">
           <a href="#" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-ip.php' OR basename($_SERVER['SCRIPT_NAME']) == 'bans-iprange.php' OR basename($_SERVER['SCRIPT_NAME']) == 'bans-country.php' OR basename($_SERVER['SCRIPT_NAME']) == 'bans-other.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-ban"></i>  <p>الحظر <i class="fas fa-angle-right right"></i>
           </p></a>
           <ul class="nav nav-treeview">
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-ip.php') {
        echo 'active';
    }
?>"><a href="bans-ip.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-ip.php') {
        echo 'active';
    }
?>"><i class="fas fa-user"></i>  <p>حظر عناوين IP <span class="badge right badge-secondary"><?php
    echo $bcount1;
?></span></p></a></li>
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-country.php') {
        echo 'active';
    }
?>"><a href="bans-country.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-country.php') {
        echo 'active';
    }
?>"><i class="fas fa-globe"></i>  <p>حظر الدول <span class="badge right badge-secondary"><?php
    echo $bcount2;
?></span></p></a></li>
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-iprange.php') {
        echo 'active';
    }
?>"><a href="bans-iprange.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-iprange.php') {
        echo 'active';
    }
?>"><i class="fas fa-grip-horizontal"></i>  <p> حظر نطاقات IP <span class="badge right badge-secondary"><?php
    echo $bcount3;
?></span></p></a></li>
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-other.php') {
        echo 'active';
    }
?>"><a href="bans-other.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-other.php') {
        echo 'active';
    }
?>"><i class="fas fa-desktop"></i>  <p>حظر أخرى <span class="badge right badge-secondary"><?php
    echo $bcount4;
?></span></p></a></li>
           </ul>
        </li>

        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bad-words.php') {
        echo 'active';
    }
?>">
           <a href="bad-words.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bad-words.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-filter"></i>  <p>كلمات سيئة
<?php
    $queryfc = $mysqli->query("SELECT * FROM `psec_bad-words` LIMIT 1");
    $countfc = mysqli_num_rows($queryfc);
    if ($countfc > 0) {
        echo '<span class="right badge badge-success">ON</span>';
    } else {
        echo '<span class="right badge badge-primary">OFF</span>';
    }
?>
           </p></a>
        </li>
        <li class="nav-header"> فحص الأمان </li>
          
          <li class="nav-item <?php
      if (basename($_SERVER['SCRIPT_NAME']) == 'phpfunctions-check.php') {
          echo 'active';
      }
  ?>">
             <a href="phpfunctions-check.php" class="nav-link <?php
      if (basename($_SERVER['SCRIPT_NAME']) == 'phpfunctions-check.php') {
          echo 'active';
      }
  ?>">
                <i class="fas fa-check"></i>  <p> الوظائف PHP </p>
             </a>
          </li>
          
          <li class="nav-item <?php
      if (basename($_SERVER['SCRIPT_NAME']) == 'phpconfig-check.php') {
          echo 'active';
      }
  ?>">
             <a href="phpconfig-check.php" class="nav-link <?php
      if (basename($_SERVER['SCRIPT_NAME']) == 'phpconfig-check.php') {
          echo 'active';
      }
  ?>">
                <i class="fab fa-php"></i>  <p> التكوين PHP </p>
             </a>
          </li>
        <li class="nav-header">التحليلات  
<?php
    if ($settings['live_traffic'] == 1) {
        echo '<span class="right badge badge-success">ON</span>';
    } else {
        echo '<span class="right badge badge-primary">OFF</span>';
    }
?></li>

        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'live-traffic.php') {
        echo 'active';
    }
?>">
           <a href="live-traffic.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'live-traffic.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-globe"></i>  <p>مراقبة الزيارات</p>
           </a>
        </li>

        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'live-traffic-lite.php') {
        echo 'active';
    }
?>">
           <a href="live-traffic-lite.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'live-traffic-lite.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-globe"></i>  <p>إحصائيات الزيارات</p>
           </a>
        </li>

        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'visit-analytics.php') {
        echo 'active';
    }
?>">
           <a href="visit-analytics.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'visit-analytics.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-chart-line"></i>  <p>الرصد والتحليل</p>
           </a>
        </li>
        </ul>

      </nav>
    </div>

  </aside>
<?php
}

function footer()
{
    include 'config.php';

    global $psec_version;
?>
<footer class="main-footer">
    <div class="scroll-btn"><div class="scroll-btn-arrow"></div></div>
    <strong>© <?php echo date("Y"); ?> <a target="_blank">درع الويب</a> v<?php echo $psec_version; ?></strong>
</footer>

</div>

    <!--JAVASCRIPT-->
    <!--=================================================-->

    <!--Bootstrap 4-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <!--AdminLTE-->
    <script src="dist/js/adminlte.js"></script>
    <script src="assets/js/psec.js"></script>

    <!--OverlayScrollbars-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.3/js/jquery.overlayScrollbars.min.js"></script>

    <!--Select2-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>

    <!--DataTables-->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.12/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.12/vfs_fonts.min.js"></script>

    <script src="https://cdn.datatables.net/v/bs4/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-html5-3.2.0/r-3.0.3/datatables.min.js"></script>

</body>
</html>
<?php
}
?>