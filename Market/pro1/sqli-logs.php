<?php
require "core.php";
head();

if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];

    $query = $mysqli->query("DELETE FROM `psec_logs` WHERE id='$id'");
}

if (isset($_GET['delete-all'])) {

    $query = $mysqli->query("DELETE FROM `psec_logs` WHERE type='SQLi'");
}
?>
<div class="content-wrapper">

    <!--CONTENT CONTAINER-->
    <!--===================================================-->
    <div class="content-header">
        
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 "><i class="fas fa-align-justify"></i> سجلات هجمات SQL</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> لوحة التحكم</a></li>
                <li class="breadcrumb-item active">سجلات هجمات SQL</li>
              </ol>
            </div>
          </div>
        </div>
    </div>

    <!--Page content-->
    <!--===================================================-->
    <div class="content">
    <div class="container-fluid">

        <div class="row">
        <div class="col-md-12">
            
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">سجلات هجمات SQL</h3>&nbsp;&nbsp;&nbsp;
                    <a href="?delete-all" class="btn btn-flat btn-danger btn-sm float-sm-right" data-toggle="tooltip" title="حذف جميع سجلات SQLi"><i class="fas fa-trash"></i> حذف الكل</a>
                </div>
                <div class="card-body">

<table id="dt-basicbans" class="table table-bordered table-hover table-sm" width="100%">
    <thead class="<?php echo $thead; ?>">
        <tr>
          <th>عنوان IP</th>
          <th>التاريخ</th>
          <th>المتصفح</th>
          <th>نظام التشغيل</th>
          <th>الدولة</th>
          <th>الإجراءات</th>
          <th class="none">الصفحة والاستعلام:</th>
        </tr>
    </thead>
    <tbody>
<?php
$sql = $mysqli->query("SELECT id, ip, date, time, browser, browser_code, os, os_code, country, country_code, type, page, query FROM `psec_logs` WHERE type='SQLi' ORDER by id DESC");
while ($row = mysqli_fetch_assoc($sql)) {
    echo '
        <tr>
          <td>' . $row['ip'] . '</td>
          <td data-sort="' . strtotime($row['date']) . ' + ' . $row['time'] . '">' . $row['date'] . ' at ' . $row['time'] . '</td>
          <td><img src="assets/img/icons/browser/' . $row['browser_code'] . '.png" /> ' . $row['browser'] . '</td>
          <td><img src="assets/img/icons/os/' . $row['os_code'] . '.png" /> ' . $row['os'] . '</td>
          <td><img src="assets/plugins/flags/blank.png" class="flag flag-' . strtolower($row['country_code']) . '" alt="' . $row['country'] . '" /> ' . $row['country'] . '</td>
          <td>
            <a href="log-details.php?id=' . $row['id'] . '" class="btn btn-flat btn-primary btn-sm" data-toggle="tooltip" title="تفاصيل السجل"><i class="fas fa-tasks"></i></a>
            <a href="?delete-id=' . $row['id'] . '" class="btn btn-flat btn-danger btn-sm" data-toggle="tooltip" title="حذف السجل"><i class="fas fa-trash"></i></a>
          </td>
          <td>' . $row['page'] . '?' . $row['query'] . '</td>
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
    <!--===================================================-->
    <!--End page content-->

</div>
<!--===================================================-->
<!--END CONTENT CONTAINER-->

</div>  
<?php
footer();
?>