<?php
// تأكد من بدء الجلسة لكي يتمكن الملف من قراءة الإشارة القادمة من login.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// الشرط: هل توجد إشارة "show_psec_msg"؟
if (isset($_SESSION['show_psec_msg']) && $_SESSION['show_psec_msg'] == true) {
?>
    <style>
    #psec_confbox {
        position: fixed; top: 0; left: 0; width: 100%;
        background-color: green; color: white; text-align: center;
        padding: 10px; font-size: 16px; z-index: 99999;
    }
    </style>
    <div id="psec_confbox">تكامل درع الويب صحيح</div>
    <script>
    setTimeout(function() {
        var el = document.getElementById("psec_confbox");
        if (el) el.style.display = "none";
    }, 3000);
    </script>
<?php
    // بمجرد عرض الرسالة، نحذف الإشارة فوراً لكي لا تظهر عند تحديث الصفحة أو التنقل
    unset($_SESSION['show_psec_msg']);
}
?>