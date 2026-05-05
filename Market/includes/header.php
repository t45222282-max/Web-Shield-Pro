<?php
require_once __DIR__ . '/../pro1/project-security.php';
session_start ();
include ("library/database.php");
$categories= "select * from categories";
$run_category = mysqli_query ($con,$categories);
if (isset($_COOKIE['user_name'])){
    $uid = $_COOKIE['id'];
    $cart = mysqli_query($con,"select * from cart where user_id='$uid'");
}else {
    $cart = mysqli_query($con, "select * from cart where user_id=0");
}

?>
    <!DOCTYPE html>
    <html dir="rtl">

    <head>
        <title></title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
        <script src="css/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                $(".account").click(function() {
                    $(".login").slideToggle("slow");
                });
            });

        </script>
    </head>

    <body>

        <header class="main-header">
            <div class="top_header">
                <a href="index.php" class="logo">MY<span class="market">Market</span></a>
                <?php if (!isset($_COOKIE['user_name'])) :?>
                <input type="button" class="account" value="تسجيل الدخول">
                <?php else :?>
                <a href="#" class="account">مرحباً <?php echo $_COOKIE['user_name']; ?></a>
                <?php endif ; ?>
                <!--<h3>إسم المستخدم او كلمة المرور غير صحيح او انه لم يتم تفعيلك بعد</h3>-->
                <div class="clear-fix"></div>
            </div>
            <div class="login">
                <?php if (!isset($_COOKIE['user_name'])) :?>
                <form action="login.php" method="post" class="login-form">
                    <input type="text" name="user_name" placeholder="إسم المستخدم" class="login-input" />
                    <input type="password" name="password" placeholder="كلمة المرور" class="login-input" />
                    <input type="submit" name="login" value="تسجيل الدخول" class="black-btn-login" />
                    <?php else :?>
                    <a href="admin/index.php" class="logedin">الذهاب إلى لوحة التحكم</a>
                    <a href="logout.php" class="black-btn-logout">تسجيل الخروج</a>
                    <?php endif ; ?>
                </form>
            </div>

        </header>
        <div class="clear-fix"></div>

        <div class="navbar">

            <div class="main-navbar">
                <ul class="right-nav">
                    <li><a href="index.php">الرئيسية</a></li>
                    <?php if (!isset($_COOKIE['user_name'])) :?>
                    <li><a href="register.php">إنشاء حساب</a></li>
                    <?php else :?>
                        <li><a href="admin/index.php">الذهاب إلى لوحة التحكم</a></li>
                    <?php endif; ?>

                </ul>
                <div class="search">
                    <form action="search.php" method="get" enctype="multipart/form-data">
                        <input type="text" name="value" placeholder="بحث" class="search-input" />
                        <input type="submit" name="search" class="search-submit" />
                    </form>
                </div>
            </div>
        </div>
        <div class="clear-fix"></div>


        <div id="body-wrapper">
            <div class="sidebar">
                <div class="row">
                    <form action="cart.php" method="post">
                        <div class="table-head">
                            <table cellpadding="5" cellspacing="1" style="width:100%" border="none">
                                <tr>
                                    <th class="cart-ico"></th>

                                    <th>
                                        00
                                    </th>
                                    <th><a href="cart.php">تحديث السلة</a></th>
                                </tr>
                            </table>
                        </div>
                    </form>
                    <div class="cart-block">
                        <form action="header.php" method="post">
                            <table cellpadding="5" cellspacing="1" style="width:100%" border="none">

                                <tr>
                                    <th style="text-align:center">الكمية</th>
                                    <th style="text-align:center">الوصف</th>
                                    <th style="text-align:left">السعر</th>
                                </tr>
                                <?php while ($row=mysqli_fetch_array($cart)):?>
                                <tr>
                                    <th style="text-align:center">
                                        <?php echo $row['qty'];?>
                                    </th>
                                    <th style="text-align:center">
                                        <?php echo $row['p_name'];?>
                                    </th>
                                    <th style="text-align:left">
                                        $
                                        <?php echo $row['price'];?>
                                    </th>
                                </tr>
                                <?php endwhile; ?>

                                <tr>
                                    <td>
                                    </td>
                                    <td style="text-align:center">الإجمالي</td>

                                    <td style="text-align:left">$

                                    </td>
                                </tr>

                            </table>
                        </form>
                    </div>
                    <div class="cate-panel">
                        <div class="panel-header">
                            <h3 class="panel-title">الأصناف</h3>
                        </div>
                        <?php while ($row=mysqli_fetch_array($run_category)) : ?>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <a href="products.php?category_id=<?php echo $row['id'];?>">
                                    <?php echo $row ['name']; ?>
                                </a>
                            </li>
                        </ul>
                        <?php endwhile ; ?>
                    </div>
                </div>
            </div>
