<?php
include "header.php";
?>
<br />
<div class="row d-flex justify-content-center">
    <center>
        <div class="alert alert-secondary" style="background-color: #f8f9fa; border: 1px solid #ddd; color: #555;">
            <h5 class="alert-heading">الموقع خارج الخدمة حالياً</h5>
        </div><br />

        <p class="font20"><i class="fas fa-tools fa-4x" style="color: #888;"></i></p>
        <h6>نعتذر عن الإزعاج، يرجى المحاولة لاحقاً.</h6>

        <br />
        <a href="mailto:<?php echo $settings['email']; ?>" class="btn btn-outline-secondary col-12" target="_blank">
            <i class="fas fa-envelope"></i> تواصل مع الدعم
        </a>
    </center>
</div>