<?php
require "core.php";
head();

if (isset($_GET['delete-all'])) {
    $query = $mysqli->query("TRUNCATE TABLE `psec_bans-ranges`");
}

if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];

    $query = $mysqli->query("DELETE FROM `psec_bans-ranges` WHERE id='$id'");
}
?>
<<div class="content-wrapper">

<!--CONTAINER المحتوى-->
<!--===================================================-->
<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>
    <header class="shield-page-header">
        <div class="shield-page-header__main">
            <h1 class="txt-h1">حظر نطاقات الـ IP</h1>
            <p class="txt-body-sm txt-secondary">إدارة نطاقات عناوين IP المحظورة بالكامل لمنع وصول فئات كاملة من الشبكات.</p>
        </div>
    </header>

    <div class="content">
    <div class="container-fluid">

<?php
if (isset($_POST['ban-iprange'])) {
    $ip_range = addslashes(htmlspecialchars($_POST['ip_range']));
    
    $queryvalid = $mysqli->query("SELECT * FROM `psec_bans-ranges` WHERE ip_range='$ip_range' LIMIT 1");
    $validator  = mysqli_num_rows($queryvalid);
    if ($validator > "0") {
        echo '<div style="background: var(--color-info); color: var(--bg-base); padding: var(--space-3); border-radius: var(--radius-md); margin-bottom: var(--space-4);"><i data-lucide="info" class="icon icon-sm"></i> تم حظر هذا <strong>النطاق الـ IP</strong> بالفعل.</div>';
    } else {
        $query = $mysqli->query("INSERT INTO `psec_bans-ranges` (`ip_range`) VALUES ('$ip_range')");
    }
}
?>
                
    <div class="shield-grid shield-grid--3" style="margin-bottom: var(--space-6);">
        <!-- Main Content (2/3) -->
        <div style="grid-column: span 2;">
<?php
if (isset($_GET['edit-id'])) {
    $id    = (int) $_GET["edit-id"];
    
    $result = $mysqli->query("SELECT * FROM `psec_bans-ranges` WHERE id = '$id'");
    $row    = mysqli_fetch_assoc($result);
    
    if (empty($id) || mysqli_num_rows($result) == 0) {
        echo '<meta http-equiv="refresh" content="0; url=bans-iprange.php">';
        exit();
    }
    
    if (isset($_POST['edit-ban'])) {
        $ip_range = addslashes(htmlspecialchars($_POST['ip_range']));
        $update = $mysqli->query("UPDATE `psec_bans-ranges` SET ip_range = '$ip_range' WHERE id='$id'");
    }
?>         
            <form action="" method="post">
                <div class="shield-card" style="margin-bottom: var(--space-6);">
                    <div class="shield-card__header">
                        <i data-lucide="edit" class="icon icon-sm text-brand"></i>
                        <span class="shield-card__title">تعديل حظر نطاق IP</span>
                    </div>
                    <div class="shield-card__body">
                        <div style="display: flex; flex-direction: column; gap: var(--space-4);">
                            <div>
                                <label class="txt-body-sm" style="font-weight: 500; display: block; margin-bottom: var(--space-2);">نطاق الـ IP:</label>
                                <input name="ip_range" type="text" maxlength="19" value="<?php echo $row['ip_range']; ?>" required style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm);">
                            </div>
                            <div style="display: flex; gap: var(--space-3); margin-top: var(--space-2);">
                                <button class="btn-shield-primary" name="edit-ban" type="submit" style="flex: 2; justify-content: center;">حفظ التعديلات</button>
                                <a href="bans-iprange.php" class="btn-shield-secondary" style="flex: 1; justify-content: center;">إلغاء</a>
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
                        <i data-lucide="network" class="icon icon-sm text-brand"></i>
                        <span class="shield-card__title">نطاقات الـ IP المحظورة</span>
                    </div>
                    <a href="?delete-all" class="btn-shield-critical btn-shield-sm" title="حذف جميع نطاقات الـ IP المحظورة">
                        <i data-lucide="trash-2" class="icon icon-sm"></i> حذف الكل
                    </a>
                </div>
                <div class="shield-card__body">
                    <div class="shield-table-wrapper">                
                        <table class="shield-table" id="dt-basic2" width="100%">
                            <thead>
                                <tr>
                                    <th>نطاق الـ IP</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_bans-ranges`");
while ($row = $query->fetch_assoc()) {
    echo '
                                <tr>
                                    <td data-label="نطاق الـ IP" style="font-family: monospace;">' . $row['ip_range'] . '</td>
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
                    <span class="shield-card__title">إضافة حظر لنطاق IP</span>
                </div>
                <div class="shield-card__body">
                    <form action="" method="post">
                        <div style="display: flex; flex-direction: column; gap: var(--space-4);">
                            <div>
                                <label class="txt-body-sm" style="font-weight: 500; display: block; margin-bottom: var(--space-2);">نطاق الـ IP:</label>
                                <input name="ip_range" type="text" placeholder="الصيغة: 12.34.56 أو 1111:db8:3333:4444" maxlength="19" required style="width: 100%; border: 1px solid var(--border-default); background: var(--bg-surface-3); color: var(--text-primary); padding: var(--space-2); border-radius: var(--radius-sm);">
                            </div>
                            <button class="btn-shield-critical" name="ban-iprange" type="submit" style="width: 100%; justify-content: center; margin-top: var(--space-2);">
                                <i data-lucide="ban" class="icon icon-sm"></i> حظر النطاق
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
				<h1 class="m-0 "><i class="fas fa-grip-horizontal"></i> حظر نطاقات الـ IP</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> لوحة التحكم</a></li>
					<li class="breadcrumb-item active">حظر نطاقات الـ IP</li>
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
if (isset($_POST['ban-iprange'])) {
	$ip_range = addslashes(htmlspecialchars($_POST['ip_range']));
	
	$queryvalid = $mysqli->query("SELECT * FROM `psec_bans-ranges` WHERE ip_range='$ip_range' LIMIT 1");
	$validator  = mysqli_num_rows($queryvalid);
	if ($validator > "0") {
		echo '<br />
		<div class="callout callout-info">
				<p><i class="fas fa-info-circle"></i> تم حظر هذا <strong>النطاق الـ IP</strong> بالفعل.</p>
		</div>';
	} else {
		$query = $mysqli->query("INSERT INTO `psec_bans-ranges` (`ip_range`) VALUES ('$ip_range')");
	}
}
?>
				
<div class="row">
	
<div class="col-md-9">
<?php
if (isset($_GET['edit-id'])) {
	$id    = (int) $_GET["edit-id"];
	
	$result = $mysqli->query("SELECT * FROM `psec_bans-ranges` WHERE id = '$id'");
	$row    = mysqli_fetch_assoc($result);
	
	if (empty($id) || mysqli_num_rows($result) == 0) {
		echo '<meta http-equiv="refresh" content="0; url=bans-iprange.php">';
		exit();
	}
	
	if (isset($_POST['edit-ban'])) {
		$ip_range = addslashes(htmlspecialchars($_POST['ip_range']));
		
		$update = $mysqli->query("UPDATE `psec_bans-ranges` SET ip_range = '$ip_range' WHERE id='$id'");
	}
?>         
<form class="form-horizontal" action="" method="post">
				<div class="shield-card">
					<div class="shield-card">
						<h3 class="shield-card">تعديل - حظر نطاق IP</h3>
					</div>
					<div class="shield-card">
						<div class="form-group">
							<label class="control-label">نطاق الـ IP: </label>
							<input name="ip_range" class="form-control" type="text" maxlength="19" value="<?php
echo $row['ip_range'];
?>" required>
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
						<h3 class="shield-card">حظر نطاقات الـ IP</h3>
						<a href="?delete-all" class="btn btn-flat btn-danger btn-sm float-sm-right" data-toggle="tooltip" title="حذف جميع نطاقات الـ IP المحظورة"><i class="fas fa-trash"></i> حذف الكل</a>
					</div>
					<div class="shield-card">

<table id="dt-basic2" class="shield-table" width="100%">
									<thead class="<?php echo $thead; ?>">
										<tr>
											<th><i class="fas fa-grip-horizontal"></i> نطاق الـ IP</th>
											<th><i class="fas fa-cog"></i> الإجراءات</th>
										</tr>
									</thead>
									<tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_bans-ranges`");
while ($row = $query->fetch_assoc()) {
	echo '
										<tr>
											<td>' . $row['ip_range'] . '</td>
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
						<h3 class="shield-card">حظر نطاق IP</h3>
					</div>
					<div class="shield-card">
					<form class="form-horizontal" action="" method="post">
						<div class="form-group">
							<label class="control-label">نطاق الـ IP: </label>
							<input name="ip_range" class="form-control" type="text" placeholder="الصيغة: 12.34.56 أو 1111:db8:3333:4444" maxlength="19" value="" required>
						</div>
					</div>
					<div class="shield-card">
						<button class="btn btn-flat btn-danger btn-block" name="ban-iprange" type="submit">حظر</button>
					</div>
				 </div>
			</div>
</form>
			</div>
			
</div>
</div>
<!--===================================================-->
<!--نهاية محتوى الصفحة-->

</div>
<?php endif; ?>
<!--===================================================-->
<!--نهاية محتوى الحاوية-->

</div>
<?php
footer();
?>