<?php
require "core.php";
head();

if (isset($_GET['delete-all'])) {
    $query = $mysqli->query("TRUNCATE TABLE `psec_bans`");
}

if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];

    $query = $mysqli->query("DELETE FROM `psec_bans` WHERE id='$id'");
}
?>
<div class="content-wrapper">

<!-- حاوية المحتوى -->
<!--===================================================-->
<!-- حاوية المحتوى -->
<!--===================================================-->
<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>
    <header class="shield-page-header">
        <div class="shield-page-header__main">
            <h1 class="txt-h1">حظر عناوين الـ IP</h1>
            <p class="txt-body-sm txt-secondary">إدارة عناوين IP المحظورة ومنع وصولها إلى النظام.</p>
        </div>
    </header>

    <div class="content">
    <div class="container-fluid">

<?php
if (isset($_POST['ban-ip'])) {
    $ip       = addslashes(htmlspecialchars($_POST['ip']));
    $date     = date("d F Y");
    $time     = date("H:i");
    $reason   = addslashes(htmlspecialchars($_POST['reason']));
    $redirect = $_POST['redirect'];
    $url      = addslashes(htmlspecialchars($_POST['url']));

    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        echo '<div style="background: var(--color-critical); color: var(--bg-base); padding: var(--space-3); border-radius: var(--radius-md); margin-bottom: var(--space-4);"><i data-lucide="alert-triangle" class="icon icon-sm"></i> عنوان الـ <strong>IP</strong> المدخل غير صالح.</div>';
    } else if ($redirect == 1 and $url == NULL) {
        echo '<div style="background: var(--color-critical); color: var(--bg-base); padding: var(--space-3); border-radius: var(--radius-md); margin-bottom: var(--space-4);"><i data-lucide="alert-triangle" class="icon icon-sm"></i> من فضلك أدخل رابط التوجيه للمستخدم المحظور.</div>';
    } else {
        $queryvalid = $mysqli->query("SELECT * FROM `psec_bans` WHERE ip='$ip' LIMIT 1");
        $validator  = mysqli_num_rows($queryvalid);
        if ($validator > "0") {
            echo '<div style="background: var(--color-info); color: var(--bg-base); padding: var(--space-3); border-radius: var(--radius-md); margin-bottom: var(--space-4);"><i data-lucide="info" class="icon icon-sm"></i> عنوان الـ <strong>IP</strong> هذا محظور بالفعل.</div>';
        } else {
            $query = $mysqli->query("INSERT INTO `psec_bans` (`ip`, `date`, `time`, `reason`, `redirect`, `url`) VALUES ('$ip', '$date', '$time', '$reason', '$redirect', '$url')");
        }
    }
}
?>
    
    <div class="shield-grid shield-grid--3" style="margin-bottom: var(--space-6);">
        <!-- Main Content (2/3) -->
        <div style="grid-column: span 2;">
<?php
if (isset($_GET['edit-id'])) {
$id = (int) $_GET["edit-id"];

$result = $mysqli->query("SELECT * FROM `psec_bans` WHERE id = '$id'");
$row    = mysqli_fetch_assoc($result);

if (empty($id) || mysqli_num_rows($result) == 0) {
    echo '<meta http-equiv="refresh" content="0; url=bans-ip.php">';
    exit();
}

if (isset($_POST['edit-ban'])) {
    $ip       = $_POST['ip'];
    $redirect = $_POST['redirect'];
    $url      = $_POST['url'];
    $reason   = $_POST['reason'];
    
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        echo '<div style="background: var(--color-critical); color: var(--bg-base); padding: var(--space-3); border-radius: var(--radius-md); margin-bottom: var(--space-4);"><i data-lucide="alert-triangle" class="icon icon-sm"></i> عنوان الـ <strong>IP</strong> المدخل غير صالح.</div>';
    } else if ($redirect == 1 and $url == NULL) {
        echo '<div style="background: var(--color-critical); color: var(--bg-base); padding: var(--space-3); border-radius: var(--radius-md); margin-bottom: var(--space-4);"><i data-lucide="alert-triangle" class="icon icon-sm"></i> من فضلك أدخل رابط التوجيه للمستخدم المحظور.</div>';
    } else {
        $update = $mysqli->query("UPDATE `psec_bans` SET ip='$ip', redirect='$redirect', url='$url', reason='$reason' WHERE id='$id'");
    }
}
?>         
            <form action="" method="post">
                <div class="shield-card" style="margin-bottom: var(--space-6);">
                    <div class="shield-card__header">
                        <i data-lucide="edit" class="icon icon-sm text-brand"></i>
                        <span class="shield-card__title">تعديل حظر عنوان IP</span>
                    </div>
                    <div class="shield-card__body">
                        <div style="display: flex; flex-direction: column; gap: var(--space-4);">
                            <div>
                                <label class="txt-body-sm" style="font-weight: 500; display: block; margin-bottom: var(--space-2);">عنوان الـ IP:</label>
                                <input name="ip" type="text" value="<?php echo $row['ip']; ?>" required style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm);">
                            </div>
                            <div>
                                <label class="txt-body-sm" style="font-weight: 500; display: block; margin-bottom: var(--space-2);">السبب:</label>
                                <input name="reason" type="text" value="<?php echo $row['reason']; ?>" style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm);">
                            </div>
                            <div>
                                <label class="txt-body-sm" style="font-weight: 500; display: block; margin-bottom: var(--space-2);">إعادة التوجيه إلى الصفحة / الموقع:</label>
                                <select name="redirect" required style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm);">
                                    <option value="0" <?php echo ($row['redirect'] == 0) ? 'selected' : ''; ?>>لا</option>
                                    <option value="1" <?php echo ($row['redirect'] == 1) ? 'selected' : ''; ?>>نعم</option>
                                </select>
                            </div>
                            <div>
                                <label class="txt-body-sm" style="font-weight: 500; display: block; margin-bottom: var(--space-2);">رابط إعادة التوجيه:</label>
                                <input name="url" type="url" value="<?php echo $row['url']; ?>" style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm);">
                            </div>
                            <div>
                                <label class="txt-body-sm" style="font-weight: 500; display: block; margin-bottom: var(--space-2);">تاريخ الحظر:</label>
                                <input name="date" type="text" value="<?php echo $row['date'] . ' at ' . $row['time']; ?>" readonly style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-1); color: var(--text-secondary); padding: var(--space-2); border-radius: var(--radius-sm); cursor: not-allowed;">
                            </div>
                            <div>
                                <label class="txt-body-sm" style="font-weight: 500; display: block; margin-bottom: var(--space-2);">محظور تلقائيًا:</label>
                                <input name="autoban" type="text" value="<?php echo ($row['autoban'] == 1) ? 'نعم' : 'لا'; ?>" readonly style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-1); color: var(--text-secondary); padding: var(--space-2); border-radius: var(--radius-sm); cursor: not-allowed;">
                            </div>
                            <div style="display: flex; gap: var(--space-3); margin-top: var(--space-2);">
                                <button class="btn-shield-primary" name="edit-ban" type="submit" style="flex: 2; justify-content: center;">حفظ التعديلات</button>
                                <a href="bans-ip.php" class="btn-shield-secondary" style="flex: 1; justify-content: center;">إلغاء</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
<?php
}
?>

            <div class="shield-card" style="margin-bottom: var(--space-6);">
                <div class="shield-card__header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: var(--space-2);">
                        <i data-lucide="list" class="icon icon-sm text-brand"></i>
                        <span class="shield-card__title">عناوين IP المحظورة</span>
                    </div>
                    <a href="?delete-all" class="btn-shield-critical btn-shield-sm" title="حذف جميع حظر عناوين الـ IP">
                        <i data-lucide="trash-2" class="icon icon-sm"></i> حذف الكل
                    </a>
                </div>
                <div class="shield-card__body">
                    <div class="shield-table-wrapper">                
                        <table class="shield-table" id="dt-basicbans" width="100%">
                            <thead>
                                <tr>
                                    <th>عنوان الـ IP</th>
                                    <th>تاريخ الحظر</th>
                                    <th>إعادة التوجيه</th>
                                    <th>تلقائي</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_bans`");
while ($row = $query->fetch_assoc()) {
echo '
                                <tr>
                                    <td data-label="عنوان الـ IP" style="font-family: monospace;">' . $row['ip'] . '</td>
                                    <td data-label="تاريخ الحظر" data-sort="' . strtotime($row['date']) . '">' . $row['date'] . '</td>
                                    <td data-label="إعادة التوجيه">';
if ($row['redirect'] == 1) { echo '<span class="shield-badge shield-badge--success">نعم</span>'; } else { echo '<span class="shield-badge shield-badge--secondary">لا</span>'; }
echo '</td>
                                    <td data-label="محظور تلقائيًا">';
if ($row['autoban'] == 1) { echo '<span class="shield-badge shield-badge--warning">نعم</span>'; } else { echo '<span class="shield-badge shield-badge--secondary">لا</span>'; }
echo '</td>
                                    <td data-label="الإجراءات">
                                        <div style="display: flex; gap: var(--space-2);">
                                            <a href="?edit-id=' . $row['id'] . '" class="btn-shield-secondary btn-shield-sm"><i data-lucide="edit" class="icon icon-sm"></i> تعديل</a>
                                            <a href="?delete-id=' . $row['id'] . '" class="btn-shield-critical btn-shield-sm"><i data-lucide="unlock" class="icon icon-sm"></i> رفع الحظر</a>
                                        </div>
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

        <!-- Sidebar (1/3) -->
        <div>
            <div class="shield-card" style="margin-bottom: var(--space-6);">
                <div class="shield-card__header">
                    <i data-lucide="plus-circle" class="icon icon-sm text-brand"></i>
                    <span class="shield-card__title">إضافة حظر IP</span>
                </div>
                <div class="shield-card__body">
                    <form action="" method="post">
                        <div style="display: flex; flex-direction: column; gap: var(--space-4);">
                            <div>
                                <label class="txt-body-sm" style="font-weight: 500; display: block; margin-bottom: var(--space-2);">عنوان الـ IP:</label>
                                <input name="ip" type="text" required style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm);" placeholder="مثال: 192.168.1.1">
                            </div>
                            <div>
                                <label class="txt-body-sm" style="font-weight: 500; display: block; margin-bottom: var(--space-2);">السبب:</label>
                                <input name="reason" type="text" style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm);" placeholder="سبب الحظر...">
                            </div>
                            <div>
                                <label class="txt-body-sm" style="font-weight: 500; display: block; margin-bottom: var(--space-2);">إعادة التوجيه:</label>
                                <select name="redirect" required style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm);">
                                    <option value="0" selected>لا</option>
                                    <option value="1">نعم</option>
                                </select>
                            </div>
                            <div>
                                <label class="txt-body-sm" style="font-weight: 500; display: block; margin-bottom: var(--space-2);">رابط التوجيه:</label>
                                <input name="url" type="url" style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm);" placeholder="https://...">
                            </div>
                            <button class="btn-shield-critical" name="ban-ip" type="submit" style="width: 100%; justify-content: center; margin-top: var(--space-2);">
                                <i data-lucide="ban" class="icon icon-sm"></i> حظر العنوان
                            </button>
                        </div>
                    </form>
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
				<h1 class="m-0 "><i class="fas fa-user"></i> حظر عناوين الـ IP</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> لوحة الإدارة</a></li>
					<li class="breadcrumb-item active">حظر عناوين الـ IP</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<!-- محتوى الصفحة -->
<!--===================================================-->
<div class="content">
<div class="container-fluid">

<?php
if (isset($_POST['ban-ip'])) {

$ip       = addslashes(htmlspecialchars($_POST['ip']));
$date     = date("d F Y");
$time     = date("H:i");
$reason   = addslashes(htmlspecialchars($_POST['reason']));
$redirect = $_POST['redirect'];
$url      = addslashes(htmlspecialchars($_POST['url']));

if (!filter_var($ip, FILTER_VALIDATE_IP)) {
	echo '<br />
	<div class="callout callout-danger">
			<p><i class="fas fa-exclamation-triangle"></i> عنوان الـ <strong>IP</strong> المدخل غير صالح.</p>
	</div>';
} else if ($redirect == 1 and $url == NULL) {
	echo '<br />
	<div class="callout callout-danger">
			<p><i class="fas fa-exclamation-triangle"></i> من فضلك أدخل رابط التوجيه للمستخدم المحظور.</p>
	</div>';
} else {
	$queryvalid = $mysqli->query("SELECT * FROM `psec_bans` WHERE ip='$ip' LIMIT 1");
	$validator  = mysqli_num_rows($queryvalid);
	if ($validator > "0") {
		echo '<br />
	<div class="callout callout-info">
			<p><i class="fas fa-info-circle"></i> عنوان الـ <strong>IP</strong> هذا محظور بالفعل.</p>
	</div>';
	} else {
		$query = $mysqli->query("INSERT INTO `psec_bans` (`ip`, `date`, `time`, `reason`, `redirect`, `url`) VALUES ('$ip', '$date', '$time', '$reason', '$redirect', '$url')");
	}
}
}
?>
			
		<div class="row">
			
	<div class="col-md-9">
<?php
if (isset($_GET['edit-id'])) {
$id = (int) $_GET["edit-id"];

$result = $mysqli->query("SELECT * FROM `psec_bans` WHERE id = '$id'");
$row    = mysqli_fetch_assoc($result);

if (empty($id) || mysqli_num_rows($result) == 0) {
	echo '<meta http-equiv="refresh" content="0; url=bans-ip.php">';
	exit();
}

if (isset($_POST['edit-ban'])) {
	$ip       = $_POST['ip'];
	$redirect = $_POST['redirect'];
	$url      = $_POST['url'];
	$reason   = $_POST['reason'];
	
	if (!filter_var($ip, FILTER_VALIDATE_IP)) {
		echo '<br />
		<div class="callout callout-danger">
				<p><i class="fas fa-exclamation-triangle"></i> عنوان الـ <strong>IP</strong> المدخل غير صالح.</p>
		</div>';
	} else if ($redirect == 1 and $url == NULL) {
		echo '<br />
		<div class="callout callout-danger">
				<p><i class="fas fa-exclamation-triangle"></i> من فضلك أدخل رابط التوجيه للمستخدم المحظور.</p>
		</div>';
	} else {
		$update = $mysqli->query("UPDATE `psec_bans` SET ip='$ip', redirect='$redirect', url='$url', reason='$reason' WHERE id='$id'");
	}
}
?>         
<form class="form-horizontal" action="" method="post">
				<div class="shield-card">
					<div class="shield-card">
						<h3 class="shield-card">تعديل - حظر عنوان الـ IP</h3>
					</div>
					<div class="shield-card">
									<div class="form-group">
										<label class="control-label">عنوان الـ IP: </label>
										<input name="ip" class="form-control" type="text" value="<?php
echo $row['ip'];
?>" required>
									</div>
									<div class="form-group">
										<label class="control-label">السبب: </label>
										<input name="reason" class="form-control" type="text" value="<?php
echo $row['reason'];
?>">
									</div>
									<div class="form-group">
										<label class="control-label">إعادة التوجيه إلى الصفحة / الموقع: </label>
<select name="redirect" class="form-control" required>
	<option value="0" <?php
if ($row['redirect'] == 0) {
	echo 'selected';
}
?>>لا</option>
	<option value="1" <?php
if ($row['redirect'] == 1) {
	echo 'selected';
}
?>>نعم</option>
</select>
									</div>
									<div class="form-group">
										<label class="control-label">رابط إعادة التوجيه: </label>
										<input name="url" class="form-control" type="url" value="<?php
echo $row['url'];
?>">
									</div>
									<div class="form-group">
										<label class="control-label">تاريخ الحظر: </label>
										<input name="date" class="form-control" type="text" value="<?php
echo $row['date'] . ' at ' . $row['time'];
?>" readonly>
									</div>
									<div class="form-group">
										<label class="control-label">محظور تلقائيًا: </label>
										<input name="autoban" class="form-control" type="text" value="<?php
if ($row['autoban'] == 1) {
	echo 'نعم';
} else {
	echo 'لا';
}
?>" readonly>
									</div>
					</div>
					<div class="shield-card">
						<div class="col-md-8">
							<button class="btn btn-flat btn-success btn-block" name="edit-ban" type="submit">حفظ</button>
						</div>
						<div class="col-md-4">
							<button type="reset" class="btn btn-flat btn-default btn-block">إعادة تعيين</button>
						</div>
					</div>
				 </div>
			</form>
<?php
}
?>
				<div class="shield-card">
					<div class="shield-card">
						<h3 class="shield-card">حظر عناوين الـ IP</h3>
						<a href="?delete-all" class="btn btn-flat btn-danger btn-sm float-sm-right" data-toggle="tooltip" title="حذف جميع حظر عناوين الـ IP"><i class="fas fa-trash"></i> حذف الكل</a>
					</div>
					<div class="shield-card">
					
<table id="dt-basicbans" class="shield-table" width="100%">
								<thead class="<?php echo $thead; ?>">
									<tr>
									  <th><i class="fas fa-user"></i> عنوان الـ IP</th>
									  <th><i class="fas fa-calendar"></i> تاريخ الحظر</th>
									  <th><i class="fas fa-share"></i> إعادة التوجيه</th>
									  <th><i class="fas fa-magic"></i> محظور تلقائيًا</th>
									  <th><i class="fas fa-cog"></i> الإجراءات</th>
									</tr>
								</thead>
								<tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_bans`");
while ($row = $query->fetch_assoc()) {
echo '
									<tr>
										<td>' . $row['ip'] . '</td>
										<td data-sort="' . strtotime($row['date']) . '">' . $row['date'] . '</td>
										<td>';
if ($row['redirect'] == 1) {
	echo 'نعم';
} else {
	echo 'لا';
}
echo '</td>
										<td>';
if ($row['autoban'] == 1) {
	echo 'نعم';
} else {
	echo 'لا';
}
echo '</td>
										<td>
										<a href="?edit-id=' . $row['id'] . '" class="btn btn-flat btn-primary btn-sm"><i class="fas fa-edit"></i> تعديل</a>
										<a href="?delete-id=' . $row['id'] . '" class="btn btn-flat btn-success btn-sm"><i class="fas fa-trash"></i> رفع الحظر</a>
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

			<div class="col-md-3">
				 <div class="shield-card">
					<div class="shield-card">
						<h3 class="shield-card">حظر عنوان الـ IP</h3>
					</div>
					<div class="shield-card">
					<form class="form-horizontal" action="" method="post">
									<div class="form-group">
										<label class="control-label">عنوان الـ IP: </label>
										<input name="ip" class="form-control" type="text" value="" required>
									</div>
									<div class="form-group">
										<label class="control-label">السبب: </label>
										<input name="reason" class="form-control" type="text" value="">
									</div>
									<div class="form-group">
										<label class="control-label">إعادة التوجيه إلى الصفحة / الموقع: </label>
<select name="redirect" class="form-control" required>
	<option value="0" selected>لا</option>
	<option value="1">نعم</option>
</select>
									</div>
									<div class="form-group">
										<label class="control-label">رابط إعادة التوجيه: </label>
										<input name="url" class="form-control" type="url" value="">
									</div>
					</div>
					<div class="shield-card">
						<button class="btn btn-block btn-flat btn-danger" name="ban-ip" type="submit">حظر</button>
					</div>
				 </div>
			</div>
</form>
			</div>
			
		</div>
		</div>
		<!--===================================================-->
		<!-- نهاية محتوى الصفحة -->

	</div>
<?php endif; ?>
	<!--===================================================-->
	<!-- نهاية حاوية المحتوى -->

</div>
<?php
footer();
?>