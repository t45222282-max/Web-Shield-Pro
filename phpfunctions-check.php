<?php
require "core.php";
head();
$isShield = (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield');
$calloutClass = $isShield ? 'neon-host-card neon-border-info' : 'callout callout-default';
$badgeSuccess = $isShield ? 'shield-badge shield-badge--success' : 'badge badge-success';
$badgeDanger  = $isShield ? 'shield-badge shield-badge--critical' : 'badge badge-danger';
$badgeWarning = $isShield ? 'shield-badge shield-badge--warning' : 'badge badge-warning';
?>
<div class="content-wrapper">

			<!--حاوية المحتوى-->
			<!--===================================================-->
			<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>
    <header class="shield-page-header">
        <div class="shield-page-header__main">
            <h1 class="txt-h1">فحص التكوين والأمان</h1>
            <p class="txt-body-sm txt-secondary">مراجعة إعدادات الخادم لضمان أقصى درجات الأمان.</p>
        </div>
    </header>
<?php else: ?>
<div class="content-header">
				
				<div class="container-fluid">
				  <div class="row mb-2">
        		    <div class="col-sm-6">
        		      <h1 class="m-0 "><i class="fas fa-check"></i> فحص أمان دوال PHP</h1>
        		    </div>
        		    <div class="col-sm-6">
        		      <ol class="breadcrumb float-sm-right">
        		        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> لوحة الإدارة</a></li>
        		        <li class="breadcrumb-item active">فحص أمان دوال PHP</li>
        		      </ol>
        		    </div>
        		  </div>
    			</div>
            </div>
<?php endif; ?>

				<!--محتوى الصفحة-->
				<!--===================================================-->
				<div class="content">
				<div class="container-fluid">

                <div class="row">
				<div class="col-md-8">

							    <div class="shield-card">
								<div class="shield-card">
								<ul class="nav nav-tabs card-header-tabs">
									<li class="nav-item active">
										<a href="#f1" data-toggle="tab" class="nav-link active text-center">تنفيذ الأوامر</a>
									</li>
									<li class="nav-item">
										<a href="#f2" data-toggle="tab" class="nav-link text-center">تنفيذ كود PHP</a>
									</li>
									<li class="nav-item">
										<a href="#f3" data-toggle="tab" class="nav-link text-center">كشف المعلومات</a>
									</li>
									<li class="nav-item">
										<a href="#f4" data-toggle="tab" class="nav-link text-center">دوال نظام الملفات</a>
									</li>
									<li class="nav-item">
										<a href="#f5" data-toggle="tab" class="nav-link text-center">أخرى</a>
									</li>			
								</ul>
								</div>
								<div class="shield-card">
								<div class="tab-content">
									<div id="f1" class="tab-pane fade active show">
									    <div class="shield-card">تنفيذ الأوامر وإرجاع الناتج الكامل</div><br />
										    <div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> exec &nbsp;&nbsp;
<?php
if (function_exists('exec')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>
                                                <br /><br /><pre class="breadcrumb" class="font14">إرجاع آخر سطر من ناتج الأوامر</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> passthru &nbsp;&nbsp;
<?php
if (function_exists('passthru')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>
                                                <br /><br /><pre class="breadcrumb" class="font14">تمرير ناتج الأوامر مباشرة إلى المتصفح</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> system &nbsp;&nbsp;
<?php
if (function_exists('system')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>
                                                <br /><br /><pre class="breadcrumb" class="font14">تمرير ناتج الأوامر مباشرة إلى المتصفح وإرجاع آخر سطر</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> shell_exec &nbsp;&nbsp;
<?php
if (function_exists('shell_exec')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>
                                                <br /><br /><pre class="breadcrumb" class="font14">إرجاع ناتج الأوامر</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> popen &nbsp;&nbsp; 
<?php
if (function_exists('popen')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>
                                                <br /><br /><pre class="breadcrumb" class="font14">فتح أنبوب للقراءة أو الكتابة لعملية أمر</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> proc_open &nbsp;&nbsp; 
<?php
if (function_exists('proc_open')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>
                                                <br /><br /><pre class="breadcrumb" class="font14">مشابه لـ popen() ولكن مع درجة تحكم أكبر</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> pcntl_exec &nbsp;&nbsp; 
<?php
if (function_exists('pcntl_exec')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>
                                                <br /><br /><pre class="breadcrumb" class="font14">تنفيذ برنامج</pre></h6>
									    	</div>
									</div>
									
									<div id="f2" class="tab-pane fade">
										<div class="shield-card">بخلاف eval، هناك طرق أخرى لتنفيذ كود PHP: يمكن استخدام include/require لتنفيذ كود عن بُعد في شكل ثغرات تضمين الملفات المحلية والعن بُعد.</div><br />
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> assert &nbsp;&nbsp; 
<?php
if (function_exists('assert')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>
                                                 <br /><br /><pre class="breadcrumb" class="font14">مشابه لـ eval()</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> create_function &nbsp;&nbsp; 
<?php
if (function_exists('create_function')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">إنشاء دالة مجهولة (على طراز lambda)</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> allow_url_fopen &nbsp;&nbsp; 
<?php
if (function_exists('allow_url_fopen')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>
                                                <br /><br /><pre class="breadcrumb" class="font14">يتيح هذا الخيار استخدام مغلفات fopen التي تدعم URL، مما يتيح الوصول إلى كائنات URL كالملفات - ثغرة تضمين الملفات</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> allow_url_include &nbsp;&nbsp; 
<?php
if (function_exists('allow_url_include')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">يتيح هذا الخيار استخدام مغلفات fopen التي تدعم URL مع الدوال التالية: include، require - ثغرة تضمين الملفات</pre></h6>
									    	</div>
									</div>
									
									<div id="f3" class="tab-pane fade">
									    <div class="shield-card">معظم استدعاءات هذه الدوال ليست نقاط ضعف مباشرة، ولكن قد تكون ثغرة إذا كان أي من البيانات المُرجعة مرئيًا للمهاجم.</div><br />
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> expose_php &nbsp;&nbsp; 
<?php
if (function_exists('expose_php')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                  
                                                <br /><br /><pre class="breadcrumb" class="font14">يضيف إصدار PHP إلى رؤوس الاستجابة، مما قد يُستخدم في استغلال الأمان</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> display_errors &nbsp;&nbsp; 
<?php
if (function_exists('display_errors')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">يعرض أخطاء PHP للعميل، مما قد يُستخدم في استغلال الأمان</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> display_startup_errors &nbsp;&nbsp; 
<?php
if (function_exists('display_startup_errors')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">يعرض أخطاء تسلسل بدء PHP للعميل، مما قد يُستخدم في استغلال الأمان</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> posix_getlogin &nbsp;&nbsp; 
<?php
if (function_exists('posix_getlogin')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">إرجاع اسم تسجيل الدخول</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> posix_ttyname &nbsp;&nbsp; 
<?php
if (function_exists('posix_ttyname')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">تحديد اسم جهاز الطرفية</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> getenv &nbsp;&nbsp; 
<?php
if (function_exists('getenv')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">الحصول على قيمة متغير بيئي</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> get_current_user &nbsp;&nbsp; 
<?php
if (function_exists('get_current_user')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">الحصول على اسم مالك النص البرمجي الحالي لـ PHP</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> proc_get_status &nbsp;&nbsp; 
<?php
if (function_exists('proc_get_status')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">الحصول على معلومات حول عملية تم فتحها بواسطة proc_open()</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> get_cfg_var &nbsp;&nbsp; 
<?php
if (function_exists('get_cfg_var')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">الحصول على قيمة خيار تكوين PHP</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> getcwd &nbsp;&nbsp; 
<?php
if (function_exists('getcwd')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">الحصول على الدليل العامل الحالي</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> getmygid &nbsp;&nbsp; 
<?php
if (function_exists('getmygid')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">الحصول على GID لمالك النص البرمجي لـ PHP</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> getmyinode &nbsp;&nbsp; 
<?php
if (function_exists('getmyinode')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">الحصول على العقدة (inode) للنص البرمجي الحالي</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> getmypid &nbsp;&nbsp; 
<?php
if (function_exists('getmypid')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">الحصول على معرف العملية لـ PHP</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> getmyuid &nbsp;&nbsp; 
<?php
if (function_exists('getmyuid')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">الحصول على UID لمالك النص البرمجي لـ PHP</pre></h6>
									    	</div>
									</div>
									
									<div id="f4" class="tab-pane fade">
									    <div class="shield-card">وفقًا لـ RATS، جميع دوال نظام الملفات في PHP تُعتبر خطيرة. بعضها لا يبدو مفيدًا جدًا للمهاجم، بينما البعض الآخر أكثر فائدة مما قد تتوقع. على سبيل المثال، إذا كان allow_url_fopen مفعلاً، يمكن استخدام عنوان URL كمسار ملف، لذا يمكن استخدام استدعاء مثل copy($_GET['s'], $_GET['d']); لرفع نص برمجي PHP إلى أي مكان في النظام. كذلك، إذا كان الموقع عرضة لطلبات GET، يمكن استغلال أي من دوال نظام الملفات هذه لتوجيه هجوم إلى مضيف آخر عبر خادومك.</div><br />
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> chgrp &nbsp;&nbsp; 
<?php
if (function_exists('chgrp')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">تغيير مجموعة الملف</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> chmod &nbsp;&nbsp; 
<?php
if (function_exists('chmod')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">تغيير وضع الملف</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> chown &nbsp;&nbsp; 
<?php
if (function_exists('chown')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">تغيير مالك الملف</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> lchgrp &nbsp;&nbsp; 
<?php
if (function_exists('lchgrp')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">تغيير ملكية المجموعة للرابط الرمزي</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> lchown &nbsp;&nbsp; 
<?php
if (function_exists('lchown')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">تغيير ملكية المستخدم للرابط الرمزي</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> link &nbsp;&nbsp; 
<?php
if (function_exists('link')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">إنشاء رابط صلب</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> symlink &nbsp;&nbsp; 
<?php
if (function_exists('symlink')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">إنشاء رابط رمزي</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> tempnam &nbsp;&nbsp; 
<?php
if (function_exists('tempnam')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">إنشاء ملف باسم ملف فريد</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> touch &nbsp;&nbsp; 
<?php
if (function_exists('touch')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">ضبط وقت الوصول والتعديل للملف</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> ftp_get &nbsp;&nbsp; 
<?php
if (function_exists('ftp_get')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">تنزيل ملف من خادم FTP</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> ftp_nb_get &nbsp;&nbsp; 
<?php
if (function_exists('ftp_nb_get')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">القراءة من نظام الملفات</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> ftp_put &nbsp;&nbsp; 
<?php
if (function_exists('ftp_put')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">رفع ملف إلى خادم FTP</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> ftp_nb_put &nbsp;&nbsp; 
<?php
if (function_exists('ftp_nb_put')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">تخزين ملف على خادم FTP (غير متزامن)</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> filegroup &nbsp;&nbsp; 
<?php
if (function_exists('filegroup')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">الحصول على مجموعة الملف</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> fileinode &nbsp;&nbsp; 
<?php
if (function_exists('fileinode')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">الحصول على العقدة (inode) للملف</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> fileowner &nbsp;&nbsp; 
<?php
if (function_exists('fileowner')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">الحصول على مالك الملف</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> fileperms &nbsp;&nbsp; 
<?php
if (function_exists('fileperms')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">الحصول على أذونات الملف</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> linkinfo &nbsp;&nbsp; 
<?php
if (function_exists('linkinfo')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">الحصول على معلومات حول رابط</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> stat &nbsp;&nbsp; 
<?php
if (function_exists('stat')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">توفير معلومات حول ملف</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> fstat &nbsp;&nbsp; 
<?php
if (function_exists('fstat')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">توفير معلومات حول ملف</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> lstat &nbsp;&nbsp; 
<?php
if (function_exists('lstat')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">توفير معلومات حول ملف أو رابط رمزي</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> readlink &nbsp;&nbsp; 
<?php
if (function_exists('readlink')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">إرجاع هدف الرابط الرمزي</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> bzopen &nbsp;&nbsp; 
<?php
if (function_exists('bzopen')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">فتح ملف مضغوط بـ bzip2</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> gzopen &nbsp;&nbsp; 
<?php
if (function_exists('gzopen')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">فتح ملف gz</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> gzfile &nbsp;&nbsp; 
<?php
if (function_exists('gzfile')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">قراءة ملف gz كامل إلى مصفوفة</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> readgzfile &nbsp;&nbsp; 
<?php
if (function_exists('readgzfile')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">إخراج ملف gz</pre></h6>
									    	</div>
									</div>
									
									<div id="f5" class="tab-pane fade">
									     <br />
										    <div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> extract &nbsp;&nbsp; 
<?php
if (function_exists('extract')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">يفتح الباب لهجمات register_globals</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> putenv &nbsp;&nbsp; 
<?php
if (function_exists('putenv')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">ضبط قيمة متغير بيئي</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> proc_nice &nbsp;&nbsp; 
<?php
if (function_exists('proc_nice')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">تغيير أولوية العملية الحالية</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> proc_terminate &nbsp;&nbsp; 
<?php
if (function_exists('proc_terminate')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">إنهاء عملية تم فتحها بواسطة proc_open</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> proc_close &nbsp;&nbsp; 
<?php
if (function_exists('proc_close')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">إغلاق عملية تم فتحها بواسطة proc_open() وإرجاع رمز الخروج لهذه العملية</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> apache_child_terminate &nbsp;&nbsp; 
<?php
if (function_exists('apache_child_terminate')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">إنهاء عملية Apache بعد الطلب</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> posix_kill &nbsp;&nbsp; 
<?php
if (function_exists('posix_kill')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">إرسال إشارة إلى عملية</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> posix_setpgid &nbsp;&nbsp; 
<?php
if (function_exists('posix_setpgid')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">ضبط معرف مجموعة العملية للتحكم في المهام</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> posix_setsid &nbsp;&nbsp; 
<?php
if (function_exists('posix_setsid')) {
    echo '<span class="<?php echo $badgeDanger; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">جعل العملية الحالية قائد جلسة</pre></h6>
									    	</div>
											<div class="<?php echo $calloutClass; ?>" style="margin-bottom: 15px; padding: 15px;">
									    		<h6><i class="fas fa-code"></i> posix_setuid &nbsp;&nbsp; 
<?php
if (function_exists('posix_setuid')) {
    echo '<span class="<?php echo $badgeWarning; ?>">غير معطل</span>';
} else {
    echo '<span class="<?php echo $badgeSuccess; ?>">معطل</span>';
}
?>                                                
                                                <br /><br /><pre class="breadcrumb" class="font14">ضبط UID للعملية الحالية</pre></h6>
									    	</div>
									</div>
								</div>
							    </div>
                        </div>
                </div>
                    
				<div class="col-md-4">
				     <div class="shield-card">
						<div class="shield-card">
							<h3 class="shield-card"><i class="fas fa-info-circle"></i> معلومات ونصائح</h3>
						</div>
				        <div class="shield-card">
							  في هذه الصفحة، يمكنك رؤية دوال PHP الضعيفة المفعلة على مضيفك.<br />
				              إذا قررت تعطيلها، يمكنك القيام بذلك من ملف php.ini على مضيفك.		
                        </div>
				     </div>
                     <div class="shield-card">
						<div class="shield-card">
							<h3 class="shield-card"><i class="fab fa-php"></i> كيفية تعطيل دوال PHP</h3>
						</div>
				        <div class="shield-card">
							  <ol>
									<li>افتح ملف <b>php.ini</b> الخاص بموقعك</li>
									<li>ابحث عن متغير <b>disable_functions</b> واضبطه كما يلي على سبيل المثال: <br /><br />
										<pre class="breadcrumb" class="font14">disable_functions = exec,passthru,shell_exec,system,proc_open,popen</pre>
									</li>
									<li>احفظ الملف وأغلقه. أعد تشغيل خادم HTTPD (Apache)</li>
				             </ol>		
                        </div>
				     </div>
				</div>
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