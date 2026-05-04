<?php
require "core.php";
head();

// Purge logs older than 30 days
$datetod = strtotime(date('d F Y', strtotime('-30 days')));

if (isset($_GET['enable'])) {
	
    $settings['live_traffic'] = 1;
	file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
}

if (isset($_GET['disable'])) {
	
    $settings['live_traffic'] = 0;
	file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
	
	$files = glob('modules/cache/live-traffic/*'); // Get all cache file names
	foreach($files as $file){ // Iterate cache files
		if(is_file($file)) {
			unlink($file); // Delete cache file
		}
	}
}

$query2 = $mysqli->query("SELECT id, date FROM `psec_live-traffic` ORDER BY id ASC");
while ($row2 = $query2->fetch_assoc()) {
	if (strtotime($row2['date']) < $datetod) {
		$id     = $row2['id'];
		$query3 = $mysqli->query("DELETE FROM `psec_live-traffic` WHERE id = '$id'");
	}
}

if (isset($_GET['delete-all'])) {
    $query = $mysqli->query("TRUNCATE TABLE `psec_live-traffic`");
}

//Today Stats
@$date = @date('d F Y');
@$ctime = @date("H:i", strtotime('-30 seconds'));

$tsquery1 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `date`='$date' AND `time`>='$ctime'");
$tscount1 = $tsquery1->num_rows;
$tsquery2 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `date`='$date' AND `uniquev`=1");
$tscount2 = $tsquery2->num_rows;
$tsquery3 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `date`='$date'");
$tscount3 = $tsquery3->num_rows;
$tsquery4 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `date`='$date' AND `uniquev`=1 AND `bot`=1");
$tscount4 = $tsquery4->num_rows;

//Month Stats
@$mdate = @date('F Y');
$msquery1 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `date` LIKE '%$mdate' AND `uniquev`=1");
$mscount1 = $msquery1->num_rows;
$msquery2 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `date` LIKE '%$mdate'");
$mscount2 = $msquery2->num_rows;
$msquery3 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `date` LIKE '%$mdate' AND `uniquev`=1 AND `bot`=1");
$mscount3 = $msquery3->num_rows;
?>
<div class="content-wrapper">

<!-- حاوية المحتوى -->
<!-- =================================================== -->
<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>
    <header class="shield-page-header">
        <div class="shield-page-header__main">
            <h1 class="txt-h1">تحليلات الزيارات</h1>
            <p class="txt-body-sm txt-secondary">مراقبة الزوار المتصلين وإحصائيات الزيارات الشهرية واليومية.</p>
        </div>
        <div class="shield-page-header__actions">
            <a href="visit-analytics.php" class="btn-shield-secondary">
                <i data-lucide="refresh-cw" class="icon icon-sm"></i>
                تحديث
            </a>
            <?php if ($settings['live_traffic'] == 0): ?>
                <a href="?enable" class="btn-shield-primary">
                    <i data-lucide="play" class="icon icon-sm"></i>
                    تفعيل التتبع
                </a>
            <?php else: ?>
                <a href="?disable" class="btn-shield-secondary">
                    <i data-lucide="pause" class="icon icon-sm"></i>
                    تعطيل التتبع
                </a>
            <?php endif; ?>
        </div>
    </header>
<?php else: ?>
<div class="content-header">
    
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 "><i class="fas fa-chart-line"></i> تحليلات الزيارات</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> لوحة التحكم</a></li>
                    <li class="breadcrumb-item active">تحليلات الزيارات</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- محتوى الصفحة -->
<!-- =================================================== -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                
                <div class="shield-card">
                    <div class="shield-card">
                        <h3 class="shield-card">تحليلات الزيارات</h3>&nbsp;&nbsp;&nbsp;
                        <div class="float-sm-right">
                            <?php
                            if ($settings['live_traffic'] == 0) {
                                echo '<a href="?enable" class="btn btn-flat btn-primary btn-sm"><i class="fas fa-play"></i> تفعيل التتبع</a>';
                            } else {
                                echo '<a href="?disable" class="btn btn-flat btn-secondary btn-sm"><i class="fas fa-pause-circle"></i> تعطيل التتبع</a>';
                            }
                            ?>
                            <a href="visit-analytics.php" class="btn btn-flat btn-primary btn-sm"><i class="fas fa-sync-alt"></i> تحديث</a>
                            <a href="?delete-all" class="btn btn-flat btn-danger btn-sm"><i class="fas fa-trash"></i> حذف البيانات</a>
                        </div>
                    </div>
                    <div class="shield-card">
                    
<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>
                            <?php include 'includes/shield-kpi-analytics.php'; ?>
<?php else: ?>
                         <h4 class="shield-card">إحصائيات اليوم</h4><br />
                         
                         <div class="row">
            
                            <div class="col-sm-6 col-lg-3">
                                <div class="shield-kpi-card shield-kpi--info">
                                   <div class="shield-kpi__content">
                                       <h3><?php echo $tscount1; ?></h3>
                                       <p>الزوار المتصلين</p>
                                   </div>
                                   <div class="shield-kpi__icon">
                                       <i class="fas fa-users"></i>
                                   </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="shield-kpi-card shield-kpi--info">
                                   <div class="shield-kpi__content">
                                       <h3><?php echo $tscount2; ?></h3>
                                       <p>الزيارات الفريدة</p>
                                   </div>
                                   <div class="shield-kpi__icon">
                                       <i class="fas fa-chart-line"></i>
                                   </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="shield-kpi-card shield-kpi--info">
                                   <div class="shield-kpi__content">
                                       <h3><?php echo $tscount3; ?></h3>
                                       <p>إجمالي الزيارات</p>
                                   </div>
                                   <div class="shield-kpi__icon">
                                       <i class="fas fa-chart-bar"></i>
                                   </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="shield-kpi-card shield-kpi--info">
                                   <div class="shield-kpi__content">
                                       <h3><?php echo $tscount4; ?></h3>
                                       <p>زيارات الروبوتات</p>
                                   </div>
                                   <div class="shield-kpi__icon">
                                       <i class="fab fa-android"></i>
                                   </div>
                                </div>
                            </div>
                        </div>
                        
                        <br /><h4 class="shield-card">إحصائيات هذا الشهر</h4><br />
                    
                        <div class="row">
            
                            <div class="col-sm-6 col-lg-4">
                                <div class="shield-kpi-card shield-kpi--info">
                                   <div class="shield-kpi__content">
                                       <h3><?php echo $mscount1; ?></h3>
                                       <p>الزيارات الفريدة</p>
                                   </div>
                                   <div class="shield-kpi__icon">
                                       <i class="fas fa-chart-line"></i>
                                   </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="shield-kpi-card shield-kpi--info">
                                   <div class="shield-kpi__content">
                                       <h3><?php echo $mscount2; ?></h3>
                                       <p>إجمالي الزيارات</p>
                                   </div>
                                   <div class="shield-kpi__icon">
                                       <i class="fas fa-chart-bar"></i>
                                   </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="shield-kpi-card shield-kpi--info">
                                   <div class="shield-kpi__content">
                                       <h3><?php echo $mscount3; ?></h3>
                                       <p>زيارات الروبوتات</p>
                                   </div>
                                   <div class="shield-kpi__icon">
                                       <i class="fab fa-android"></i>
                                   </div>
                                </div>
                            </div>
                        </div>
<?php endif; ?>
                        
                        <br /><h4 class="shield-card">الزيارات لهذا الشهر</h4><br />
                        
                            <canvas id="visits-chart"></canvas>
                            
                        <br /><h4 class="shield-card">الإحصائيات العامة</h4><br />    
                            
                        <div class="row">
                             <div class="col-md-6">
                                  <center><h5><i class="fas fa-globe"></i> إحصائيات المتصفح</h5></center>
                                  <div id="canvas-holder" class="width100">
                                      <canvas id="browser-graph"></canvas>
                                  </div>
                             </div>
                             
                             <div class="col-md-6">
                                  <center><h5><i class="fas fa-desktop"></i> إحصائيات نظام التشغيل</h5></center>
                                  <div id="canvas-holder" class="width100">
                                      <canvas id="os-graph"></canvas>
                                  </div>
                             </div>
                          </div>
                          <div class="row">
                             <div class="col-md-6">
                                  <br /><center><h5><i class="fas fa-mobile-alt"></i> إحصائيات الأجهزة</h5></center>
                                  <div id="canvas-holder" class="width100">
                                      <canvas id="device-graph"></canvas>
                                  </div>
                             </div>
                        </div>
                        
                        <div class="col-md-12">
                        <hr />
                            <h5>الزيارات حسب البلد</h5><br />
                            
                        <table id="dt-basic" class="shield-table" width="100%">
                                    <thead>
                                        <tr>
                                          <th><i class="fas fa-globe"></i> البلد</th>
                                          <th><i class="fas fa-users"></i> الزوار</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$countries = array(
"أفغانستان",
"ألبانيا",
"الجزائر",
"أندورا",
"أنغولا",
"أنتيغوا وبربودا",
"الأرجنتين",
"أرمينيا",
"أستراليا",
"النمسا",
"أذربيجان",
"الباهاما",
"البحرين",
"بنغلاديش",
"بربادوس",
"بيلاروسيا",
"بلجيكا",
"بيليز",
"بنن",
"بوتان",
"بوليفيا",
"البوسنة والهرسك",
"بوتسوانا",
"البرازيل",
"بروناي",
"بلغاريا",
"بوركينا فاسو",
"بوروندي",
"كمبوديا",
"الكاميرون",
"كندا",
"الرأس الأخضر",
"جمهورية أفريقيا الوسطى",
"تشاد",
"شيلي",
"الصين",
"كولومبيا",
"جزر القمر",
"الكونغو (برازافيل)",
"الكونغو",
"كوستاريكا",
"كوت ديفوار",
"كرواتيا",
"كوبا",
"قبرص",
"جمهورية التشيك",
"الدنمارك",
"جيبوتي",
"دومينيكا",
"جمهورية الدومينيكان",
"تيمور الشرقية",
"الإكوادور",
"مصر",
"السلفادور",
"غينيا الاستوائية",
"إريتريا",
"إستونيا",
"إثيوبيا",
"فيجي",
"فنلندا",
"فرنسا",
"الغابون",
"غامبيا",
"جورجيا",
"ألمانيا",
"غانا",
"اليونان",
"غرينادا",
"غواتيمالا",
"غينيا",
"غينيا بيساو",
"غيانا",
"هايتي",
"هندوراس",
"هنغاريا",
"آيسلندا",
"الهند",
"إندونيسيا",
"إيران",
"العراق",
"أيرلندا",
"إسرائيل",
"إيطاليا",
"جامايكا",
"اليابان",
"الأردن",
"كازاخستان",
"كينيا",
"كيريباس",
"كوريا الشمالية",
"كوريا الجنوبية",
"الكويت",
"قرغيزستان",
"لاوس",
"لاتفيا",
"لبنان",
"ليسوتو",
"ليبيريا",
"ليبيا",
"ليختنشتاين",
"ليتوانيا",
"لوكسمبورغ",
"مقدونيا",
"مدغشقر",
"مالاوي",
"ماليزيا",
"جزر المالديف",
"مالي",
"مالطا",
"جزر مارشال",
"موريتانيا",
"موريشيوس",
"المكسيك",
"ميكرونيزيا",
"مولدوفا",
"موناكو",
"منغوليا",
"المغرب",
"موزمبيق",
"ميانمار",
"ناميبيا",
"ناورو",
"نيبال",
"هولندا",
"نيوزيلندا",
"نيكاراغوا",
"النيجر",
"نيجيريا",
"النرويج",
"عمان",
"باكستان",
"بالاو",
"بنما",
"بابوا غينيا الجديدة",
"باراغواي",
"بيرو",
"الفلبين",
"بولندا",
"البرتغال",
"قطر",
"رومانيا",
"روسيا",
"رواندا",
"سانت كيتس ونيفيس",
"سانت لوسيا",
"سانت فنسنت",
"ساموا",
"سان مارينو",
"ساو تومي وبرينسيبي",
"السعودية",
"السنغال",
"صربيا والجبل الأسود",
"سيشيل",
"سيراليون",
"سنغافورة",
"سلوفاكيا",
"سلوفينيا",
"جزر سليمان",
"الصومال",
"جنوب أفريقيا",
"إسبانيا",
"سريلانكا",
"السودان",
"سورينام",
"سوازيلاند",
"السويد",
"سويسرا",
"سوريا",
"تايوان",
"طاجيكستان",
"تنزانيا",
"تايلاند",
"توجو",
"تونغا",
"ترينيداد وتوباغو",
"تونس",
"تركيا",
"تركمانستان",
"توفالو",
"أوغندا",
"أوكرانيا",
"الإمارات العربية المتحدة",
"المملكة المتحدة",
"الولايات المتحدة",
"أوروغواي",
"أوزبكستان",
"فانواتو",
"الفاتيكان",
"فنزويلا",
"فيتنام",
"اليمن",
"زامبيا",
"زيمبابوي"
);

foreach ($countries as $country) {
    $log_result = $mysqli->query("SELECT country_code FROM `psec_live-traffic` WHERE `country` LIKE '%$country%'");
    $log_rows   = mysqli_num_rows($log_result);
    $lgrow      = mysqli_fetch_assoc($log_result);
    
    if ($log_rows > 0) {
        echo '<tr>';
        echo '<td><img src="assets/plugins/flags/blank.png" class="flag flag-' . strtolower($lgrow['country_code']) . '"/>&nbsp; ' . $country . '</td>';
        echo '<td>' . $log_rows . '</td>';
        echo '</tr>';
    }
}
?>
</tbody>
</table>

                        </div>
					
                        </div>
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