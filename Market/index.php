<?php
include_once ("includes/header.php") ;
$products = "SELECT products.*,users.username FROM products
INNER JOIN users ON products.user_id=users.id";
$run_products = mysqli_query ($con,$products);
//$id=$_COOKIE['id'];
//if (!isset($_COOKIE['user_name'])){
//    echo "<script>alert('Welcome Guste')</script>";
//}
//else
//{
//    $u = $_COOKIE['user_name'];
//    echo "<script>alert('Welcome $u')</script>";
//}
?>
    <div class="products-container">
        <div class="clear-fix">
            <div class="products-body">
                <?php while ($row=mysqli_fetch_array($run_products)) : ?>
                <div class="products">
                    <div class="item-block">
                        <p class="addby">By : <em><?php echo $row['username'];?></em></p>
                        <a href="details.php?id=<?php echo $row['id'];?>"><img src="images/<?php echo $row['image']; ?>"></a>
                        <div class="product-title">
                            <?php echo $row['title']; ?>
                        </div>
                        <div class="product-price">
                            $
                            <?php echo $row['price']; ?>
                        </div>
                        <div class="add-product">
                            <form action="cart_update.php" method="post">
                                الكمية: <input type="text" name="qty" value="1" class="qty">
                                <input type="hidden" name="id" value="<?php echo $row['id'] ; ?>">
                                <input type="hidden" name="price" value="<?php echo $row['price'] ; ?>">
                                <input type="hidden" name="title" value="<?php echo $row['title'] ; ?>">
                                <?php if(!isset($_COOKIE['user_name'])) : ?>
                                <a href="login.php"><input type="button" class="black-btn-pro" value="إضافة إلى السلة"></a>
                                <?php else :?>
                                    <input type="hidden" name="uid" value="<?php echo $_COOKIE['id'] ; ?>">
                                <input type="submit" name="add" class="black-btn-pro" value="إضافة إلى السلة">
                                <?php endif ;?>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endwhile ; ?>
                <?php mysqli_close($con); ?>
            </div>
        </div>
    </div>
    <?php include ("includes/footer.php") ; ?>
