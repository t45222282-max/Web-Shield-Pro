<?php
require "core.php";
head();

if (isset($_POST['add-word'])) {
    $word       = $_POST['word'];
	
    $queryvalid = $mysqli->query("SELECT * FROM `psec_bad-words` WHERE `word`='$word' LIMIT 1");
    $validator  = mysqli_num_rows($queryvalid);
    if ($validator > "0") {
    } else {
        $query = $mysqli->query("INSERT INTO `psec_bad-words` (`word`) VALUES ('$word')");
    }
}

if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];
    
    $query = $mysqli->query("DELETE FROM `psec_bad-words` WHERE id='$id'");
}

if (isset($_POST['save'])) {
    $settings['badword_replace'] = $_POST['badword-replace'];
	
    file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
}
?>
<div class="content-wrapper">

<!--CONTAINER CONTENT-->
<!--===================================================-->
<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>

    <header class="shield-page-header">
        <div class="shield-page-header__main">
            <h1 class="txt-h1">تصفية الكلمات السيئة</h1>
            <p class="txt-body-sm txt-secondary">إدارة قائمة الكلمات المحظورة وكلمة الاستبدال.</p>
        </div>
    </header>
    <div class="content"><div class="container-fluid">
<?php
$s_qfc  = $mysqli->query("SELECT * FROM `psec_bad-words`");
$s_cfc  = mysqli_num_rows($s_qfc);
$s_status_cls = $s_cfc > 0 ? 'shield-badge--success' : 'shield-badge--neutral';
$s_status_lbl = $s_cfc > 0 ? 'مفعّل — يتم تصفية الكلمات السيئة' : 'غير مفعّل — لم يتم إضافة كلمات بعد';
?>
    <div class="shield-grid shield-grid--3" style="gap:var(--space-4);">
        <div style="grid-column:span 2;">
            <!-- Status Card -->
            <div class="shield-card" style="margin-bottom:var(--space-4);">
                <div class="shield-card__body" style="display:flex;align-items:center;gap:var(--space-3);">
                    <i data-lucide="filter" class="icon icon-md text-brand"></i>
                    <div>
                        <div class="txt-body-sm txt-secondary">حالة وحدة تصفية الكلمات</div>
                        <span class="shield-badge <?= $s_status_cls ?>"><?= $s_status_lbl ?></span>
                    </div>
                </div>
            </div>
            <!-- Replace word setting -->
            <div class="neon-panel-cyan">
                <div class="shield-card__header"><i data-lucide="replace" class="icon icon-sm text-brand"></i><span class="shield-card__title">كلمة الاستبدال</span></div>
                <form action="" method="post">
                <div class="shield-card__body">
                    <label class="txt-body-sm font-medium" style="display:block;margin-bottom:var(--space-2);">النص الذي يظهر بدلاً من الكلمة السيئة</label>
                    <input type="text" name="badword-replace" value="<?= $settings['badword_replace'] ?>" class="glow-input">
                </div>
                <div class="shield-card__footer" style="padding:var(--space-3);border-top:1px solid rgba(255, 255, 255, 0.1);">
                    <button type="submit" name="save" class="btn-cyan-glow-sm"><i data-lucide="save" class="icon icon-sm"></i> حفظ التغييرات</button>
                </div>
                </form>
            </div>
            <!-- Words Table -->
            <div class="shield-card">
                <div class="shield-card__header" style="justify-content:space-between;">
                    <div style="display:flex;align-items:center;gap:var(--space-2);">
                        <i data-lucide="list" class="icon icon-sm text-brand"></i>
                        <span class="shield-card__title">الكلمات السيئة</span>
                    </div>
                    <button type="button" onclick="document.getElementById('shield-add-word-form').style.display=document.getElementById('shield-add-word-form').style.display==='none'?'block':'none'" class="btn-cyan-glow-sm"><i data-lucide="plus" class="icon icon-xs"></i> إضافة</button>
                </div>
                <div id="shield-add-word-form" style="display:none;padding:var(--space-4);border-bottom:1px solid var(--border-subtle);">
                    <form method="post" action="" style="display:flex;gap:var(--space-2);">
                        <input type="text" name="word" required placeholder="أدخل الكلمة السيئة" class="glow-input" style="flex:1;">
                        <button type="submit" name="add-word" class="btn-cyan-glow-sm"><i data-lucide="plus" class="icon icon-sm"></i> إضافة</button>
                    </form>
                </div>
                <div class="shield-card__body p-0">
                    <div class="shield-table-wrapper">
                        <table class="shield-table" id="dt-basicbadwords" width="100%">
                            <thead><tr><th>الكلمة</th><th>الإجراءات</th></tr></thead>
                            <tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_bad-words`");
while ($rowd = $query->fetch_assoc()) {
    echo '<tr><td data-label="الكلمة">' . $rowd['word'] . '</td><td data-label="الإجراءات"><a href="?delete-id=' . $rowd['id'] . '" class="btn-shield-secondary btn-shield-sm" style="color:var(--color-critical);"><i data-lucide="trash" class="icon icon-xs"></i> حذف</a></td></tr>';
}
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Info sidebar -->
        <div>
            <div class="shield-card">
                <div class="shield-card__header"><i data-lucide="info" class="icon icon-sm text-brand"></i><span class="shield-card__title">حول الوحدة</span></div>
                <div class="shield-card__body">
                    <p class="txt-body-sm txt-secondary">يمكن استخدام هذه الوحدة لحجب (إخفاء, استبدال) الكلمات السيئة والروابط والجمل.</p>
                    <hr style="border-top:1px solid var(--border-subtle);margin:var(--space-3) 0;">
                    <p class="txt-body-sm txt-secondary">إذا لم يتم إضافة أي كلمات, فإن الوحدة تكون معطلة تلقائيًا.</p>
                    <hr style="border-top:1px solid var(--border-subtle);margin:var(--space-3) 0;">
                    <p class="txt-body-sm txt-secondary">تعمل الوحدة بطريقتين:</p>
                    <ul style="padding-right:var(--space-4);color:var(--text-secondary);font-size:var(--text-sm);">
                        <li>تصفية الكلمات قبل عرض الصفحة</li>
                        <li>تصفية بيانات POST</li>
                    </ul>
                    <hr style="border-top:1px solid var(--border-subtle);margin:var(--space-3) 0;">
                    <p class="txt-body-sm txt-secondary"><strong>كلمة الاستبدال</strong> — النص الذي سيظهر بدلاً من الكلمة السيئة.</p>
                </div>
            </div>
        </div>
    </div>
    </div></div>
<?php else: ?>
<div class="content-header">
	
	<div class="container-fluid">
	  <div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 "><i class="fas fa-filter"></i> وحدة الحماية</h1>
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
$queryfc = $mysqli->query("SELECT * FROM `psec_bad-words`");
$countfc = mysqli_num_rows($queryfc);
if ($countfc > 0) {
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
		<h3 class="shield-card">كلمات سيئة - وحدة الحماية</h3>
	</div>
	<div class="shield-card">
<?php
if ($countfc > 0) {
echo '
	<h1 class="pm_enabled"><i class="fas fa-check-circle"></i> مفعل</h1>
	<p>الكلمات السيئة تم <strong>تصفيتها</strong></p>
';
} else {
echo '
	<h1 class="pm_disabledblue"><i class="fas fa-times-circle"></i> غير مفعل</h1>
	<p>الكلمات السيئة لم تُصفى بعد <strong>بعد</strong></p>
';
}
?>
				</div>
			</div>
			
			<div class="shield-card">
				<div class="shield-card">
					<h3 class="shield-card">الكلمات السيئة</h3>
					<button data-target="#add" data-toggle="modal" class="btn btn-flat btn-primary btn-sm float-sm-right"><i class="fas fa-plus-circle"></i> إضافة كلمة سيئة</button>
				</div>
				<div class="shield-card">
				
				<form action="" method="post" class="form-horizontal form-bordered">
				
					<div class="form-group">
						<label class="control-label"><i class="fas fa-pen-square"></i> كلمة استبدال</label>
						<input type="text" name="badword-replace" value="<?php
echo $settings['badword_replace'];
?>" class="form-control">
					</div>
				
					<button type="button submit" name="save" class="mb-xs mt-xs mr-xs btn btn-flat btn-success btn-sm btn-block"><i class="fas fa-save"></i>&nbsp;&nbsp;حفظ</button>
				</form>
				
				<hr /><br />
							
<form class="form-horizontal mb-lg" method="POST">
	<div class="modal fade" id="add" role="dialog" tabindex="-1" aria-labelledby="add" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title">إضافة كلمة سيئة</h6>
					<button data-dismiss="modal" class="close" type="button">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label">الكلمة السيئة:</label>
						<input type="text" class="form-control" name="word" required />
					</div>
				</div>
				<div class="modal-footer">
					<input class="btn btn-block btn-flat btn-primary" name="add-word" type="submit" value="إضافة">
				</div>
			</div>
		</div>
	</div>
</form>               
<table id="dt-basicbadwords" class="shield-table" width="100%">
							<thead class="<?php echo $thead; ?>">
								<tr>
									<th>الكلمة السيئة</th>
									<th>الإجراءات</th>
								</tr>
							</thead>
							<tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_bad-words`");
while ($rowd = $query->fetch_assoc()) {
echo '
								<tr>
									<td>' . $rowd['word'] . '</td>
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
			
		<div class="col-md-4">
			 <div class="shield-card">
					<div class="shield-card">
						<h3 class="shield-card"><i class="fas fa-info-circle"></i> حول تصفية الكلمات السيئة</h3>
					</div>
					<div class="shield-card">
						يمكن استخدام هذه الوحدة لحجب (إخفاء، استبدال) الكلمات السيئة، الروابط، والجمل.
						<br /><br />
						إذا لم يتم إضافة أي كلمات سيئة، فإن الوحدة تكون معطلة تلقائيًا.
						<br /><br />
						تعمل الوحدة بطريقتين:
						<ul>
						  <li>تصفية الكلمات السيئة في الوقت الفعلي قبل العرض (رندر الصفحة)</li>
						  <li>تصفية الكلمات السيئة بعد إرسال بيانات POST</li>
						</ul>
						<strong>كلمة الاستبدال</strong> - النص (الكلمة) التي ستظهر بدلاً من الكلمة السيئة
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

<?php endif; ?>
</div>
<?php
footer();
?>