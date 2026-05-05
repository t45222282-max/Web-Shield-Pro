<?php include ("includes/header.php");
if (isset($_COOKIE['user_name'])){
    $uid = $_COOKIE['id'];
    $sql = mysqli_query($con,"select * from cart where user_id='$uid'");
}else {
    $sql = mysqli_query($con, "select * from cart where user_id=0");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id=$_POST['id'];
    $remove="delete from cart where id='$id'";
    mysqli_query($con, $remove);
//    header("refresh: 0", url = "");
    echo "<script>window.open('cart.php', '_self');</script>";
}
?>
    <div class="products-container">
        <div class="container_title">
            <h1>معلومات السلة</h1>
        </div>
        <div class="clear-fix">
            <div class="products-body">
                <table class="table table-striped">
                    <tr>
                        <th>المنتج</th>
                        <th>الكمية</th>
                        <th>السعر</th>
                        <th></th>
                    </tr>
                    <?php while ($row=mysqli_fetch_array($sql)): ?>
                    <tr>
                        <td>
                            <?php echo $row ['p_name'];?>
                        </td>
                        <td>
                            <?php echo $row ['qty'];?>
                        </td>
                        <td>
                            <?php echo $row ['price'];?>
                        </td>
                        <td>
                            <form method="POST" action="cart.php">
                                <input type="hidden" name="id" class="black-btn-pro" value="<?php echo $row['id'] ; ?>">
                                <input type="submit" name="remove" class="black-btn-pro" value="إزالة">
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <tr>
                        <td>رسوم نقل</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>الإجمالي</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="remove" class="black-btn-pro" value="تأكيد عملية الشراء"></td>
                        <td></td>
                        <td></td>

                    </tr>

                </table>
            </div>
        </div>
    </div>
    <?php include'includes/footer.php'; ?>
