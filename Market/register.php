<?php include ("includes/header.php");?>
<?php if (!isset($_COOKIE['user_name'])) :?>
<div class="products-container">
    <div class="container_title">
        <h1>إنشاء حساب جديد</h1>
    </div>
    <div class="clear-fix">
        <div class="products-body">
            <form method="POST" action="process.php">
                <div class="form-group">
                    <input type="text" name="first_name" placeholder="الإسم الأول" class="form-control">
                </div>
                <div class="form-group">
                    <input type="text" name="last_name" placeholder="الإسم الأخير" class="form-control">
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="الإيميل" class="form-control">
                </div>
                <div class="form-group">
                    <input type="text" name="username" placeholder="إسم المستخدم" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="كلمة المرور" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" name="password2" placeholder="تأكيد كلمة المرور" class="form-control">
                </div>
                <button name="reg" type="submit" class="black-btn reg">تسجيل</button>
            </form>
        </div>
    </div>
</div>
<?php else:?>
    <script>window.open('index.php', '_self');</script>
<?php endif; ?>
<?php include ("includes/footer.php"); ?>
