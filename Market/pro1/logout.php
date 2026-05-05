//<?php
include "config.php";

if (!isset($_SESSION)) {
    session_start();
}

// حذف الجلسة
session_unset();
session_destroy();

// إعادة توجيه صحيحة
header("Location: index.php");
exit();
?>//

<?php
include "config.php";

if (!isset($_SESSION)) {
    session_start();
}

// حذف الجلسة
session_unset();
session_destroy();

// إعادة توجيه صحيحة
header("Location: index.php");
exit();
?>