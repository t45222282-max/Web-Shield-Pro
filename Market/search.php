<?php include 'includes/header.php';?>
<?php 
if (isset($_GET['search'])){
    if ( $_GET["value"]!= trim("")) {
    $search_id = $_GET['value'];    
        $search_query = "SELECT * FROM products where keywords like '%$search_id%'";
    $run_query = mysqli_query($con,$search_query);
    }
    else {
    header ("LOCATION:index.php");
    }
    mysqli_close($con);
    
    
 //   if ($_SERVER["REQUEST_METHOD"] == "get") 
 //                {
 //       
 //                  if ( $_GET["value"]!= trim(""))
 //                  {
 //                      $search_id = $_GET['value'];
 //                      $search_query = "SELECT * FROM products where keywords like '%$search_id%'";
 //   $run_query = mysqli_query($con,$search_query);
 //                    }
 //                else{header ("LOCATION:index.php");
 //                    
 //                }
 //                }
 //        else 
 //            {
 //            include "search.php";
 //               echo"<h2><center></b>". "<font color=brown>" . " الرجاء إدخال بيانات صحيحة  ";
 //             }
    
    
}
?>

<div class="products-container">
    <div class="container_title">
        <h1>نتائج البحث</h1>
    </div>
    <div class="clear-fix">
        <div class="products-body">
            <?php if (mysqli_num_rows($run_query)>0) : ?>
            <?php while ($row=mysqli_fetch_array($run_query)) : ?>
            <div class="products">
                <div class="item-block">
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
            <?php else : ?>
            <h2 style="padding:20px; font-size:20px; font-weight:bold; text-align:center; background:none; color:#333;">
                لا يوجد نتائج مطابقة لـ
                <?php echo $search_id ; ?>
            </h2>
            <?php endif ; ?>
        </div>
    </div>
</div>
<?php include 'includes/footer.php';?>
