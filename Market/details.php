<?php include 'includes/header.php'; ?>
<?php
//Create Query
$product_id = $_GET['id'];
$query= "SELECT * FROM products WHERE id= " .$product_id;
//Run Query
$product = mysqli_query($con,$query);
$run_product = mysqli_fetch_array($product);
$category = "select * from categories";
$run_categories = mysqli_query($con,$category);
?>
    <div class="products-container">
        <div class="container_title">
            <h1>تفاصيل المنتج</h1>
        </div>
        <div class="products-body">
            <div class="clear-fix">
                <div class="item-block">
                    <img src="images/<?php echo $run_product['image']; ?>">
                </div>
                <div class="details-body">
                    <h3 class="details-title">
                        <?php echo $run_product['title']; ?> </h3>
                    <div class="details-price">
                        السعر:
                        <?php echo $run_product['price']; ?>$
                    </div>
                    <div class="desc-head">
                        <h2>الوصف</h2>
                    </div>
                    <div class="details-description">
                        <?php echo $run_product['description']; ?>
                    </div>
                    <div class="details-buy">
                        <form method="post" action="cart/id">
                            الكمية: <input class="qty " type="text " name="qty " value="1 " />
                            <button class="black-btn " type="submit "> إضافة إلى العربة </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php mysqli_close($con); ?>
    <?php include 'includes/footer.php'; ?>
