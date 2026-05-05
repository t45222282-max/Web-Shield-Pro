<?php include 'includes/header.php';
if (isset($_GET['category_id'])){
$category_id=$_GET['category_id'];

//Create Query
$query = "SELECT products.*,users.username FROM products
INNER JOIN users ON products.user_id=users.id AND category_id='$category_id'";
//$query= "SELECT * FROM products WHERE category_id= ".$category_id;
//Run Query
$products = mysqli_query($con,$query);
} else {
//Create Query
$query= "SELECT * FROM products";

//Run Query
$products=mysqli_query($con,$query);    
}
;?>
<div class="products-container">
    <div class="clear-fix">
        <div class="products-body">
            <?php while ($row=mysqli_fetch_array($products)) : ?>
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
                        <form action="header.php" method="post">
                            الكمية: <input type="text" name="qty" value="1" class="qty">
                            <input type="hidden" name="id" value="<?php echo $row['id'] ; ?>">
                            <input type="hidden" name="price" value="<?php echo $row['price'] ; ?>">
                            <input type="hidden" name="title" value="<?php echo $row['title'] ; ?>">
                            <input type="submit" name="add" class="black-btn-pro" value="إضافة إلى السلة">
                        </form>
                    </div>
                </div>
            </div>
            <?php endwhile ; ?>
            <?php mysqli_close($con); ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
