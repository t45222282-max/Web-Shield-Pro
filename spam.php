<?php
require "core.php";
head();

if (isset($_POST['add-database'])) {
    $database   = $_POST['database'];
	
    $queryvalid = $mysqli->query("SELECT * FROM `psec_dnsbl-databases` WHERE `database`='$database' LIMIT 1");
    $validator  = mysqli_num_rows($queryvalid);
    if ($validator > "0") {
    } else {
        $query = $mysqli->query("INSERT INTO `psec_dnsbl-databases` (`database`) VALUES ('$database')");
    }
}

if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];

    $query = $mysqli->query("DELETE FROM `psec_dnsbl-databases` WHERE id='$id'");
}

if (isset($_POST['save'])) {

    if (isset($_POST['protection'])) {
        $settings['spam_protection'] = 1;
    } else {
        $settings['spam_protection'] = 0;
    }
    
    if (isset($_POST['logging'])) {
        $settings['spam_logging'] = 1;
    } else {
        $settings['spam_logging'] = 0;
    }
    
    if (isset($_POST['mail'])) {
        $settings['spam_mail'] = 1;
    } else {
        $settings['spam_mail'] = 0;
    }
    
    $settings['spam_redirect'] = $_POST['redirect'];
    
    file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
}
?>
<div class="content-wrapper">
<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>

    <header class="shield-page-header">
        <div class="shield-page-header__main">
            <h1 class="txt-h1">وحدة الحماية: مكافحة السبام</h1>
            <p class="txt-body-sm txt-secondary">إدارة قواعد بيانات الحظر (DNSBL) لحماية الموقع من المرسلين العشوائيين والبريد المزعج.</p>
        </div>
    </header>

    <div class="shield-grid shield-grid--3" style="margin-bottom: var(--space-6);">
        <!-- Main Column (2/3) -->
        <div style="grid-column: span 2;">
            <?php
            $querysp = $mysqli->query("SELECT * FROM `psec_dnsbl-databases`");
            if ($settings['spam_protection'] == 1 && mysqli_num_rows($querysp) > 0): ?>
                <div class="neon-host-card neon-border-success" style="padding: 25px; margin-bottom: var(--space-6); display: flex; align-items: center; gap: 20px;">
                    <i data-lucide="shield-check" class="neon-icon-success neon-icon-animated micro-anim-fingerprint" style="width: 56px; height: 56px;"></i>
                    <div style="text-align: right;">
                        <h2 class="txt-h3 text-success" style="text-shadow: 0 0 10px rgba(0,255,150,0.3);">الحماية مفعلة</h2>
                        <p class="txt-body-md txt-secondary">الموقع محمي حالياً من **المرسلين العشوائيين (سبام)**.</p>
                    </div>
                </div>
            <?php else: ?>
                <div class="neon-host-card neon-border-danger" style="padding: 25px; margin-bottom: var(--space-6); display: flex; align-items: center; gap: 20px;">
                    <i data-lucide="shield-alert" class="neon-icon-pink neon-icon-animated micro-anim-cpu" style="width: 56px; height: 56px; filter: hue-rotate(300deg);"></i>
                    <div style="text-align: right;">
                        <h2 class="txt-h3 text-critical" style="text-shadow: 0 0 10px rgba(255,0,85,0.3);">الحماية غير مفعلة</h2>
                        <p class="txt-body-md txt-secondary">الموقع حالياً **عرضة** لرسائل البريد المزعج والسبام.</p>
                    </div>
                </div>
            <?php endif; ?>

            <div class="neon-panel-cyan" style="margin-bottom: var(--space-6);">
                <div class="shield-card__header" style="display: flex; justify-content: space-between; align-items: center; padding: 20px 20px 0;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i data-lucide="database" class="neon-icon-info" style="width: 24px; height: 24px;"></i>
                        <span class="shield-card__title" style="font-size: 1.2em;">قواعد بيانات السبام (DNSBL)</span>
                    </div>
                    <button type="button" data-target="#add" data-toggle="modal" class="btn-shield-primary btn-shield-sm" style="box-shadow: 0 0 10px rgba(0,210,255,0.2);">
                        <i data-lucide="plus" class="icon icon-sm"></i> إضافة قاعدة جديدة
                    </button>
                </div>
                <div class="shield-card__body" style="padding: 20px;">
                    <form class="form-horizontal mb-lg" method="POST">
                        <div class="modal fade" id="add" role="dialog" tabindex="-1" aria-labelledby="add" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content" style="background: var(--bg-surface-1); border: 1px solid var(--border-default); border-radius: var(--radius-lg);">
                                    <div class="modal-header" style="border-bottom: 1px solid var(--border-subtle);">
                                        <h6 class="modal-title txt-h5">إضافة قاعدة بيانات سبام (DNSBL)</h6>
                                        <button data-dismiss="modal" class="close" type="button" style="color: var(--text-primary); opacity: 1;">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="control-label txt-body-sm" style="font-weight: 500; margin-bottom: var(--space-2); display: block;">
                                                <i data-lucide="database" class="icon icon-sm"></i> قاعدة بيانات سبام (DNSBL):
                                            </label>
                                            <input type="text" class="form-control" name="database" required style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm);" />
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="border-top: 1px solid var(--border-subtle);">
                                        <input class="btn-shield-primary" style="width: 100%; justify-content: center;" name="add-database" type="submit" value="إضافة">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php if (mysqli_num_rows($querysp) > 2): ?>
                        <div style="background: var(--color-warning); color: var(--bg-base); padding: var(--space-3); border-radius: var(--radius-md); margin-bottom: var(--space-4); display: flex; gap: var(--space-2); align-items: center;">
                            <i data-lucide="alert-triangle" class="icon icon-sm"></i>
                            <p class="txt-body-sm">لا يُنصح باستخدام أكثر من <b>قاعدتي بيانات</b> للسبام لأن الأداء والدقة قد يتأثران سلباً.</p>
                        </div>
                    <?php endif; ?>

                    <div class="shield-table-wrapper" style="margin-top: var(--space-4);">                
                        <table class="shield-table" width="100%">
                            <thead>
                                <tr>
                                    <th>قاعدة بيانات DNSBL</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $query = $mysqli->query("SELECT * FROM `psec_dnsbl-databases`");
                            while ($rowd = $query->fetch_assoc()) {
                                echo '
                                <tr>
                                    <td data-label="قاعدة بيانات DNSBL">' . $rowd['database'] . '</td>
                                    <td data-label="الإجراءات">
                                        <a href="?delete-id=' . $rowd['id'] . '" class="btn-shield-critical btn-shield-sm"><i data-lucide="trash" class="icon icon-sm"></i> حذف</a>
                                    </td>
                                </tr>
                                ';
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Column (1/3) -->
        <div>
            <div class="shield-card" style="margin-bottom: var(--space-6);">
                <div class="shield-card__header">
                    <i data-lucide="info" class="icon icon-sm text-brand"></i>
                    <span class="shield-card__title">ما هو السبام و DNSBL؟</span>
                </div>
                <div class="shield-card__body">
                    <p class="txt-body-sm txt-secondary" style="line-height: 1.6; margin-bottom: var(--space-3);"><strong>الرسائل الإلكترونية العشوائية (سبام)</strong> هي استخدام أنظمة الرسائل الإلكترونية لإرسال رسائل غير مرغوب فيها، خاصةً الإعلانات، أو إرسال رسائل متكررة في نفس الموقع.</p>
                    <p class="txt-body-sm txt-secondary" style="line-height: 1.6; margin-bottom: var(--space-3);"><strong>قائمة الحظر المستندة إلى DNS (DNSBL)</strong> هي قائمة لعناوين IP تُستخدم غالبًا لنشر عناوين لأجهزة كمبيوتر أو شبكات مرتبطة بإرسال السبام.</p>
                    <p class="txt-body-sm txt-secondary" style="line-height: 1.6;">يمكن العثور على القوائم هنا: <a href="https://www.dnsbl.info/dnsbl-list.php" target="_blank" style="color: var(--color-brand-primary);">dnsbl.info</a></p>
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
                                    <p class="txt-body-sm txt-secondary" style="margin: 0;">تفعيل الحماية وحظر التهديدات</p>
                                </div>
                                <label class="custom-checkbox-wrapper">
                                    <input type="checkbox" name="protection" <?php echo ($settings['spam_protection'] == 1) ? 'checked="checked"' : ''; ?> />
                                    <div class="custom-checkbox-box"></div>
                                </label>
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-subtle); padding-bottom: var(--space-3);">
                                <div>
                                    <p class="txt-body-md" style="font-weight: 500; margin: 0;">التسجيل (Logging)</p>
                                    <p class="txt-body-sm txt-secondary" style="margin: 0;">تسجيل التهديدات المكتشفة</p>
                                </div>
                                <label class="custom-checkbox-wrapper">
                                    <input type="checkbox" name="logging" <?php echo ($settings['spam_logging'] == 1) ? 'checked="checked"' : ''; ?> />
                                    <div class="custom-checkbox-box"></div>
                                </label>
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <p class="txt-body-md" style="font-weight: 500; margin: 0;">الإشعارات بالبريد</p>
                                    <p class="txt-body-sm txt-secondary" style="margin: 0;">تلقي إشعار عند الاكتشاف</p>
                                </div>
                                <label class="custom-checkbox-wrapper">
                                    <input type="checkbox" name="mail" <?php echo ($settings['spam_mail'] == 1) ? 'checked="checked"' : ''; ?> />
                                    <div class="custom-checkbox-box"></div>
                                </label>
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

<!--محتوى الصفحة-->
<!--===================================================-->
<div class="content">
	<div class="container-fluid">

		<div class="row">
			<div class="col-md-8">

<?php
$querysp = $mysqli->query("SELECT * FROM `psec_dnsbl-databases`");
if ($settings['spam_protection'] == 1 && mysqli_num_rows($querysp) > 0) {
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
					<h3 class="shield-card">وحدة حماية من السبام</h3>
				</div>
				<div class="shield-card">
<?php
if ($settings['spam_protection'] == 1 && mysqli_num_rows($querysp) > 0) {
echo '
	<h1 class="pm_enabled"><i class="fas fa-check-circle"></i> مفعّلة</h1>
	<p>الموقع محمي من <strong>المرسلين العشوائيين (سبام)</strong></p>
';
} else {
echo '
	<h1 class="pm_disabled"><i class="fas fa-times-circle"></i> غير مفعّلة</h1>
	<p>الموقع غير محمي من <strong>المرسلين العشوائيين (سبام)</strong></p>
';
}
?>
				</div>
			</div>
			
			<div class="shield-card">
				<div class="shield-card">
					<h3 class="shield-card"><i class="fas fa-server"></i> قواعد بيانات السبام (DNSBL)</h3>
					<button data-target="#add" data-toggle="modal" class="btn btn-flat btn-primary btn-sm float-sm-right"><i class="fas fa-plus-circle"></i> إضافة قاعدة بيانات سبام (DNSBL)</button>
				</div>
				<div class="shield-card">

<form class="form-horizontal mb-lg" method="POST">
<div class="modal fade" id="add" role="dialog" tabindex="-1" aria-labelledby="add" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title">إضافة قاعدة بيانات سبام (DNSBL)</h6>
				<button data-dismiss="modal" class="close" type="button">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label class="control-label"><i class="fas fa-database"></i> قاعدة بيانات سبام (DNSBL):</label>
					<input type="text" class="form-control" name="database" required />
				</div>
			</div>
			<div class="modal-footer">
				<input class="btn btn-block btn-flat btn-primary" name="add-database" type="submit" value="إضافة">
			</div>
		</div>
	</div>
</div>
</form>

<?php
if (mysqli_num_rows($querysp) > 2) {
echo '
	<div class="callout callout-warning">
		لا يُنصح باستخدام أكثر من <b>قاعدتي بيانات</b> للسبام لأن الأداء والدقة قد يتأثران سلباً.
	</div>';
}
?>

<div class="shield-table">                
<table class="shield-table">
	<thead>
		<tr>
			<th><i class="fas fa-database"></i> قاعدة بيانات DNSBL</th>
			<th><i class="fas fa-cog"></i> الإجراءات</th>
		</tr>
	</thead>
	<tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_dnsbl-databases`");
while ($rowd = $query->fetch_assoc()) {
echo '
		<tr>
			<td>' . $rowd['database'] . '</td>
			<td>
			<a href="?delete-id=' . $rowd['id'] . '" class="btn btn-flat btn-danger btn-sm btn-block"><i class="fas fa-trash"></i> حذف</a>
			</td>
		</tr>
';
}
?>
	</tbody>
</table>
</div>
						
				</div>
			</div>
			
		</div>
			
		<div class="col-md-4">
			<div class="shield-card">
				<div class="shield-card">
					<h3 class="shield-card"><i class="fas fa-info-circle"></i> ما هو السبام و DNSBL؟</h3>
				</div>
				<div class="shield-card">
					<strong>الرسائل الإلكترونية العشوائية (سبام)</strong> هي استخدام أنظمة الرسائل الإلكترونية لإرسال رسائل غير مرغوب فيها، خاصةً الإعلانات، أو إرسال رسائل متكررة في نفس الموقع.
					<br /><br />
					<strong>قائمة الحظر المستندة إلى DNS (DNSBL)</strong> أو <strong>قائمة الحظر الفوري (RBL)</strong> هي قائمة لعناوين IP تُستخدم غالبًا لنشر عناوين لأجهزة كمبيوتر أو شبكات مرتبطة بإرسال السبام.
					<br /><br />
					جميع <strong>قوائم الحظر</strong> يمكن العثور عليها هنا: <strong><a href="https://www.dnsbl.info/dnsbl-list.php" target="_blank">https://www.dnsbl.info/dnsbl-list.php</a></strong>
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
if ($settings['spam_protection'] == 1) {
echo 'checked="checked"';
}
?> /><br />
							<span class="text-muted">عند تفعيل وحدة الحماية هذه، سيتم حظر جميع التهديدات من هذا النوع</span>
						</li>
						<li class="list-group-item">
							<p>التسجيل</p>
							<input type="checkbox" name="logging" class="psec-switch" <?php
if ($settings['spam_logging'] == 1) {
echo 'checked="checked"';
}
?> /><br />
							<span class="text-muted">تسجيل التهديدات المكتشفة</span>
						</li>
						<li class="list-group-item">
							<p>الإشعارات بالبريد</p>
							<input type="checkbox" name="mail" class="psec-switch" <?php
if ($settings['spam_mail'] == 1) {
echo 'checked="checked"';
}
?> /><br />
							<span class="text-muted">تلقي إشعار عبر البريد عند اكتشاف تهديد من هذا النوع</span>
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
<!--نهاية محتوى الصفحة-->

</div>
<!--===================================================-->
<!--نهاية حاوية المحتوى-->
</div>
<?php
footer();
?>
