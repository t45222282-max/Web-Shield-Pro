<?php
require "core.php";
head();

if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];

    $query = $mysqli->query("DELETE FROM `psec_bans-other` WHERE id='$id'");
}
?>
<div class="content-wrapper">

<!--CONTAINER المحتوى-->
<!--===================================================-->
<!--CONTAINER المحتوى-->
<!--===================================================-->
<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>
    <header class="shield-page-header">
        <div class="shield-page-header__main">
            <h1 class="txt-h1">حظر آخر</h1>
            <p class="txt-body-sm txt-secondary">إدارة حظر المتصفحات، أنظمة التشغيل، مزودي خدمة الإنترنت، والمحيلين.</p>
        </div>
    </header>

    <div class="content">
    <div class="container-fluid">
    
<?php
if (isset($_POST['block'])) {

    $value = addslashes($_POST['value']);
    $type  = $_POST['type'];
    
    $queryvalid = $mysqli->query("SELECT * FROM `psec_bans-other` WHERE value='$value' and type='$type' LIMIT 1");
    $validator  = mysqli_num_rows($queryvalid);
    if ($validator > "0") {
        echo '<div style="background: var(--color-info); color: var(--bg-base); padding: var(--space-3); border-radius: var(--radius-md); margin-bottom: var(--space-4);"><i data-lucide="info" class="icon icon-sm"></i> يوجد سجل مشابه في قاعدة البيانات بالفعل.</div>';
    } else {
        $query = $mysqli->query("INSERT INTO `psec_bans-other` (value, type) VALUES('$value', '$type')");
    }
}
?>
                
    <div class="shield-grid shield-grid--2" style="margin-bottom: var(--space-6);">
        <!-- Form Section -->
        <div>
            <form action="" method="post">
                <div class="shield-card" style="margin-bottom: var(--space-6);">
                    <div class="shield-card__header">
                        <i data-lucide="shield-alert" class="icon icon-sm text-brand"></i>
                        <span class="shield-card__title">إضافة قاعدة حظر جديدة</span>
                    </div>
                    <div class="shield-card__body">
                        <div style="display: flex; flex-direction: column; gap: var(--space-4);">
                            <div>
                                <label class="txt-body-sm" style="font-weight: 500; display: block; margin-bottom: var(--space-2);">المتصفح، نظام التشغيل، مزود الإنترنت أو المحيل:</label>
                                <input name="value" type="text" required style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm);">
                            </div>
                            <div>
                                <label class="txt-body-sm" style="font-weight: 500; display: block; margin-bottom: var(--space-2);">النوع:</label>
                                <select name="type" required style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm);">
                                    <option value="browser" selected>متصفح</option>
                                    <option value="os">نظام التشغيل</option>
                                    <option value="isp">مزود خدمة الإنترنت</option>
                                    <option value="referrer">المحيل</option>
                                </select>
                            </div>
                            <button class="btn-shield-critical" name="block" type="submit" style="width: 100%; justify-content: center; margin-top: var(--space-2);">
                                <i data-lucide="ban" class="icon icon-sm"></i> حظر
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
                
        <!-- ISP List -->
        <div>
            <div class="shield-card" style="margin-bottom: var(--space-6);">
                <div class="shield-card__header">
                    <i data-lucide="cloud" class="icon icon-sm text-brand"></i>
                    <span class="shield-card__title">مزودو خدمة الإنترنت المحظورين</span>
                </div>
                <div class="shield-card__body">
                    <div class="shield-table-wrapper">
                        <table class="shield-table" id="dt-basic3" width="100%">
                            <thead>
                                <tr>
                                    <th>مزود الإنترنت</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_bans-other` WHERE type='isp'");
while ($row = $query->fetch_assoc()) {
    echo '
                                <tr>
                                    <td data-label="مزود الإنترنت">' . $row['value'] . '</td>
                                    <td data-label="الإجراءات">
                                        <a href="?delete-id=' . $row['id'] . '" class="btn-shield-secondary btn-shield-sm"><i data-lucide="unlock" class="icon icon-sm"></i> رفع الحظر</a>
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
    </div>
                
    <div class="shield-grid shield-grid--3" style="margin-bottom: var(--space-6);">
        <!-- Browsers List -->
        <div>
            <div class="shield-card" style="margin-bottom: var(--space-6);">
                <div class="shield-card__header">
                    <i data-lucide="globe" class="icon icon-sm text-brand"></i>
                    <span class="shield-card__title">المتصفحات المحظورة</span>
                </div>
                <div class="shield-card__body">
                    <div class="shield-table-wrapper">
                        <table class="shield-table" id="dt-basicphpconf" width="100%">
                            <thead>
                                <tr>
                                    <th>المتصفح</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_bans-other` WHERE type='browser'");
while ($row = $query->fetch_assoc()) {
    echo '
                                <tr>
                                    <td data-label="المتصفح">' . $row['value'] . '</td>
                                    <td data-label="الإجراءات">
                                        <a href="?delete-id=' . $row['id'] . '" class="btn-shield-secondary btn-shield-sm"><i data-lucide="unlock" class="icon icon-sm"></i> رفع الحظر</a>
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
                
        <!-- OS List -->
        <div>
            <div class="shield-card" style="margin-bottom: var(--space-6);">
                <div class="shield-card__header">
                    <i data-lucide="monitor" class="icon icon-sm text-brand"></i>
                    <span class="shield-card__title">أنظمة التشغيل المحظورة</span>
                </div>
                <div class="shield-card__body">
                    <div class="shield-table-wrapper">
                        <table class="shield-table" id="dt-basic2" width="100%">
                            <thead>
                                <tr>
                                    <th>نظام التشغيل</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_bans-other` WHERE type='os'");
while ($row = $query->fetch_assoc()) {
    echo '
                                <tr>
                                    <td data-label="نظام التشغيل">' . $row['value'] . '</td>
                                    <td data-label="الإجراءات">
                                        <a href="?delete-id=' . $row['id'] . '" class="btn-shield-secondary btn-shield-sm"><i data-lucide="unlock" class="icon icon-sm"></i> رفع الحظر</a>
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
            
        <!-- Referrers List -->
        <div>
            <div class="shield-card" style="margin-bottom: var(--space-6);">
                <div class="shield-card__header">
                    <i data-lucide="link" class="icon icon-sm text-brand"></i>
                    <span class="shield-card__title">المحيلون المحظورون</span>
                </div>
                <div class="shield-card__body">
                    <div class="shield-table-wrapper">
                        <table class="shield-table" id="dt-basic4" width="100%">
                            <thead>
                                <tr>
                                    <th>المحيل</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_bans-other` WHERE type='referrer'");
while ($row = $query->fetch_assoc()) {
    echo '
                                <tr>
                                    <td data-label="المحيل">' . $row['value'] . '</td>
                                    <td data-label="الإجراءات">
                                        <a href="?delete-id=' . $row['id'] . '" class="btn-shield-secondary btn-shield-sm"><i data-lucide="unlock" class="icon icon-sm"></i> رفع الحظر</a>
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
    </div>
            
    </div>
    </div>
<?php else: ?>
<div class="content-header">
	
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 "><i class="fas fa-desktop"></i> حظر آخر</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> لوحة التحكم</a></li>
					<li class="breadcrumb-item active">حظر آخر</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<!--محتوى الصفحة-->
<!--===================================================-->
<div class="content">
<div class="container-fluid">
	
<?php
if (isset($_POST['block'])) {

	$value = addslashes($_POST['value']);
	$type  = $_POST['type'];
	
	$queryvalid = $mysqli->query("SELECT * FROM `psec_bans-other` WHERE value='$value' and type='$type' LIMIT 1");
	$validator  = mysqli_num_rows($queryvalid);
	if ($validator > "0") {
		echo '<br />
		<div class="callout callout-info">
				<p><i class="fas fa-info-circle"></i> يوجد سجل مشابه في قاعدة البيانات بالفعل.</p>
		</div>';
	} else {
		$query = $mysqli->query("INSERT INTO `psec_bans-other` (value, type) VALUES('$value', '$type')");
	}
}
?>
				
<div class="row">
   
<div class="col-md-6">
				 <div class="shield-card">
					<div class="shield-card">
						<h3 class="shield-card">حظر المتصفح، نظام التشغيل، مزود الإنترنت أو المحيل</h3>
					</div>
					<div class="shield-card">
					<form class="form-horizontal" action="" method="post">
									<div class="form-group">
										<label class="control-label">المتصفح، نظام التشغيل، مزود الإنترنت أو المحيل: </label>
										<input name="value" class="form-control" type="text" required>
									</div>
									<div class="form-group">
										<label class="control-label">النوع: </label>
<select name="type" class="form-control" required>
	<option value="browser" selected>متصفح</option>
	<option value="os">نظام التشغيل</option>
	<option value="isp">مزود خدمة الإنترنت</option>
	<option value="referrer">المحيل</option>
</select>
									</div>
					</div>
					<div class="shield-card">
						<button class="btn btn-flat btn-block btn-danger" name="block" type="submit">حظر</button>
					</div>
				 </div>
			</div>
</form>
				
				<div class="col-md-6">
				 <div class="shield-card">
					<div class="shield-card">
						<h3 class="shield-card">مزودو خدمة الإنترنت <strong>المحظورين</strong></h3>
					</div>
					<div class="shield-card">
<table id="dt-basic3" class="shield-table" width="100%">
								<thead class="<?php echo $thead; ?>">
									<tr>
										<th><i class="fas fa-cloud"></i> مزود الإنترنت</th>
										<th><i class="fas fa-cog"></i> الإجراءات</th>
									</tr>
								</thead>
								<tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_bans-other` WHERE type='isp'");
while ($row = $query->fetch_assoc()) {
	echo '
									<tr>
										<td>' . $row['value'] . '</td>
										<td>
										<a href="?delete-id=' . $row['id'] . '" class="btn btn-flat btn-success btn-block btn-sm"><i class="fas fa-unlock"></i> رفع الحظر</a>
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
				
			<div class="row">
			<div class="col-md-6">
				<div class="shield-card">
					<div class="shield-card">
						<h3 class="shield-card">المتصفحات <strong>المحظورة</strong></h3>
					</div>
					<div class="shield-card">
<table id="dt-basicphpconf" class="shield-table" width="100%">
								<thead class="<?php echo $thead; ?>">
									<tr>
										<th><i class="fas fa-globe"></i> المتصفح</th>
										<th><i class="fas fa-cog"></i> الإجراءات</th>
									</tr>
								</thead>
								<tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_bans-other` WHERE type='browser'");
while ($row = $query->fetch_assoc()) {
	echo '
									<tr>
										<td>' . $row['value'] . '</td>
										<td>
										<a href="?delete-id=' . $row['id'] . '" class="btn btn-flat btn-success btn-block btn-sm"><i class="fas fa-unlock"></i> رفع الحظر</a>
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
				
			<div class="col-md-6">
				 <div class="shield-card">
					<div class="shield-card">
						<h3 class="shield-card">أنظمة التشغيل <strong>المحظورة</strong></h3>
					</div>
					<div class="shield-card">
<table id="dt-basic2" class="shield-table" width="100%">
								<thead class="<?php echo $thead; ?>">
									<tr>
										<th><i class="fas fa-desktop"></i> نظام التشغيل</th>
										<th><i class="fas fa-cog"></i> الإجراءات</th>
									</tr>
								</thead>
								<tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_bans-other` WHERE type='os'");
while ($row = $query->fetch_assoc()) {
	echo '
									<tr>
										<td>' . $row['value'] . '</td>
										<td>
										<a href="?delete-id=' . $row['id'] . '" class="btn btn-flat btn-success btn-block btn-sm"><i class="fas fa-unlock"></i> رفع الحظر</a>
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
			
			<div class="col-md-6">
				 <div class="shield-card">
					<div class="shield-card">
						<h3 class="shield-card">المحيلون <strong>المحظورون</strong></h3>
					</div>
					<div class="shield-card">
<table id="dt-basic4" class="shield-table" width="100%">
								<thead class="<?php echo $thead; ?>">
									<tr>
										<th><i class="fas fa-link"></i> المحيل</th>
										<th><i class="fas fa-cog"></i> الإجراءات</th>
									</tr>
								</thead>
								<tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_bans-other` WHERE type='referrer'");
while ($row = $query->fetch_assoc()) {
	echo '
									<tr>
										<td>' . $row['value'] . '</td>
										<td>
										<a href="?delete-id=' . $row['id'] . '" class="btn btn-flat btn-success btn-block btn-sm"><i class="fas fa-unlock"></i> رفع الحظر</a>
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
				
			</div>
			</div>
<?php endif; ?>
			<!--===================================================-->
			<!--نهاية محتوى الصفحة-->

		</div>
		<!--===================================================-->
		<!--نهاية محتوى الحاوية-->

</div>
<?php
footer();
?>