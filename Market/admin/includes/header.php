<?php include ("../library/database.php");?>
<?php
session_start();
if(!isset($_SESSION['user_name'])) {
    header("LOCATION:login.php");
}else {
    $id = $_COOKIE['id'];
    $query = mysqli_query($con, "select * from users where id='$id'");
}
?>
<?php
$un_user="select * from users where active='0'";
$run_un= mysqli_query ($con,$un_user);
$check_unactive = mysqli_num_rows($run_un);
$active_admin ="select * from users where admin='1' and id='$id'";
$run_active = mysqli_query($con,$active_admin);
$act=mysqli_num_rows($run_active);


$user_products ="SELECT products.*,categories.name FROM products
INNER JOIN categories ON products.category_id=categories.id where user_id='$id'";
$run_u_products = mysqli_query($con,$user_products);

$user_account= "SELECT * FROM users where id = '$id'";
//Run Query
$u_account = mysqli_query ($con,$user_account);
$run_u_account = mysqli_fetch_array($u_account);
?>
    <!DOCTYPE html>
    <html>

    <head>
        <link rel="stylesheet" href="css/reset.css" />
        <link rel="stylesheet" href="css/style.css" />
        <script src="jquery.min.js" type="text/javascript"></script>
    </head>

    <body>
        <!--  HEAD -->
        <div id="head">
            <div class="left">
                <a href="account.php?id=<?php echo $id; ?>" class="button profile"><img src="css/img/img/icons/huser.png"></a>
                Hi,
                <a href="account.php?id=<?php echo $id;?>">
                    <?php echo $_COOKIE['user_name'];?>
                </a>|
                <a href="logout.php">Logout</a> |
                <a href="../index.php">Back To Site</a> |
                <a href="backup.php">backup</a>

            </div>
            <div class="right">
                <form action="#" id="search" class="search placeholder">
                    <label>Looking for something ?</label>
                    <input type="text" value="" name="q" class="text" />
                    <input type="submit" value="rechercher" class="submit" />
                </form>
            </div>

        </div>


        <!--            
                SIDEBAR
                         -->
        <div id="sidebar">
            <ul>
                <li class="nosubmenu">
                    <a href="index.php">
                        <img src="css/img/img/icons/menu/black-dashboard.png" alt="" /> Dashboard
                    </a>
                </li>

                <li>
                    <a href="index.php"><img src="css/img/img/icons/menu/black-layout.png" alt="" /> Elements</a>
                    <ul>
                        <?php if($act>0) : ?>
                        <li><a href="index.php">Dashboard</a></li>
                        <li><a href="add_product.php">Add Product</a></li>
                        <li><a href="add_category.php">Add Category</a></li>
                        <li><a href="my_products.php?id=<?php echo $id;?>">My Products</a></li>
                    </ul>
                </li>

                <li>
                    <ul>
                        <a href="index.php"><img src="css/img/img/icons/menu/black-color.png" alt="" /> Account And Users</a>
                        <li><a href="account.php?id=<?php echo $id;?>">My Account</a></li>
                        <li><a href="edit_admin.php">Admins</a></li>
                        <li><a href="edit_users.php">Users</a></li>
                    </ul>
                </li>
            </ul>
            <?php else :?>
            <li>
                <ul>
                    <li><a href="index.php">Dashboard</a></li>
                    <li><a href="add_product.php">Add Product</a></li>
                    <li><a href="account.php?id=<?php echo $id;?>">My Account</a></li>
                </ul>
            </li>
            <?php endif;?>

        </div>
