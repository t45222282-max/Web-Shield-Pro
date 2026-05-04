<?php
require "core.php";
head();

// حذف سجلات تسجيل الدخول الأقدم من 6 أشهر
$datetod = strtotime(date('d F Y', strtotime('-6 months')));
$query2 = $mysqli->query("SELECT id, date FROM `psec_logins` ORDER BY id ASC");
while ($row2 = $query2->fetch_assoc()) {
	if (strtotime($row2['date']) < $datetod) {
		$id     = $row2['id'];
		$query3 = $mysqli->query("DELETE FROM `psec_logins` WHERE id = '$id'");
	}
}
?>
<div class="content-wrapper">

	<!-- رأس الصفحة -->
<?php if (!empty($settings['ui_engine']) && $settings['ui_engine'] === 'shield'): ?>
    <header class="shield-page-header">
        <div class="shield-page-header__main">
            <h1 class="txt-h1">سجل تسجيل الدخول</h1>
            <p class="txt-body-sm txt-secondary">سسجلات تسجيل الدخول الأخيرة. تُحذف السجلات الأقدم من 6 أشهر تلقائيًا.</p>
        </div>
    </header>
    <div class="content"><div class="container-fluid">
    <div class="shield-card">
        <div class="shield-card__header">
            <i data-lucide="history" class="icon icon-sm text-brand"></i>
            <span class="shield-card__title">سجل تسجيل الدخول</span>
        </div>
        <div class="shield-card__body p-0">
            <div class="shield-table-wrapper">
                <table class="shield-table" id="dt-basicloghist" width="100%">
                    <thead><tr>
                        <th>اسم المستخدم</th>
                        <th>عنوان IP</th>
                        <th>التاريخ والوقت</th>
                        <th>حالة الدخول</th>
                        <th>الإجراءات</th>
                    </tr></thead>
                    <tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_logins` ORDER BY id DESC");
while ($row = $query->fetch_assoc()) {
    $status = $row['successful'] == 0
        ? '<span class="shield-badge shield-badge--critical">فشل</span>'
        : '<span class="shield-badge shield-badge--success">ناجح</span>';
    echo '<tr>
        <td data-label="اسم المستخدم">' . $row['username'] . '</td>
        <td data-label="عنوان IP">' . $row['ip'] . '</td>
        <td data-label="التاريخ والوقت" data-sort="' . strtotime($row['date']) . '">' . date('Y-m-d h:i:s A', strtotime($row['date'] . ' ' . $row['time'])) . '</td>
        <td data-label="حالة الدخول">' . $status . '</td>
        <td data-label="الإجراءات"><a href="ip-lookup.php?ip=' . $row['ip'] . '" class="btn-shield-secondary btn-shield-sm"><i data-lucide="search" class="icon icon-sm"></i> بحث عن IP</a></td>
    </tr>';
}
?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div></div>
<?php else: ?>
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0"><i class="fas fa-history"></i> سجل تسجيل الدخول</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> لوحة التحكم</a></li>
						<li class="breadcrumb-item active">سجل تسجيل الدخول</li>
					</ol>
				</div>
			</div>
		</div>
	</div>

	<!-- محتوى الصفحة -->
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">

					<div class="callout callout-info">
						سيتم حذف سجلات تسجيل الدخول الأقدم من 6 أشهر تلقائيًا.
					</div>

					<div class="shield-card">
						<div class="shield-card">
							<h3 class="shield-card">سجل تسجيل الدخول</h3>
						</div>
						<div class="shield-card">
							<table id="dt-basicloghist" class="shield-table" width="100%">
								<thead class="<?php echo $thead; ?>">
									<tr>
										<th><i class="fas fa-user"></i> اسم المستخدم</th>
										<th><i class="fas fa-address-card"></i> عنوان IP</th>
										<th><i class="far fa-calendar-alt"></i> التاريخ والوقت</th>
										<th><i class="fas fa-info-circle"></i> حالة الدخول</th>
										<th><i class="fas fa-cog"></i> الإجراءات</th>
									</tr>
								</thead>
								<tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_logins` ORDER BY id DESC");
while ($row = $query->fetch_assoc()) {
    echo '
	<tr>
		<td>' . $row['username'] . '</td>
		<td>' . $row['ip'] . '</td>
		<td data-sort="' . strtotime($row['date']) . ' + ' . $row['time'] . '">' . date('Y-m-d h:i:s A ', strtotime($row['date'] . ' ' . $row['time'])) . '</td>
		<td>';
    if ($row['successful'] == 0) {
        echo '<span class="badge badge-danger">فشل</span>';
    } else {
        echo '<span class="badge badge-success">ناجح</span>';
    }
    echo '
		</td>
		<td>
			<a href="ip-lookup.php?ip=' . $row['ip'] . '" class="btn btn-flat btn-primary btn-sm"><i class="fas fa-search"></i> بحث عن IP</a>
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
</div>
<?php
footer();
?>
