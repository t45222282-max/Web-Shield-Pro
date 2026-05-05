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

					<div class="card card-primary card-outline">
						<div class="card-header">
							<h3 class="card-title">سجل تسجيل الدخول</h3>
						</div>
						<div class="card-body">
							<table id="dt-basicloghist" class="table table-bordered table-hover table-sm" width="100%">
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
		<td data-sort="' . strtotime($row['date']) . ' + ' . $row['time'] . '">' . $row['date'] . ' at  ' . $row['time'] . '</td>
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

</div>
<?php
footer();
?>
