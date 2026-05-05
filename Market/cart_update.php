<?php 
include 'library/database.php';
if (isset($_POST['add'])){
    $uid=$_POST['uid'];
    $id=$_POST['id'];
    $name=$_POST['title'];
    $qty=$_POST['qty'];
    $price=$_POST['price'];
    $insert="insert into cart (p_id,user_id,p_name,qty,price) values ('$id','$uid','$name','$qty','$price')";
        if(mysqli_query($con,$insert)){
            include 'index.php';
            echo "<script>alert('1 item Added')</script>";
            exit();
        }
    else
    {
        echo "<script>alert('Sorry Problem occures while adding to cart please try again later .. Thank you .')</script>";
        exit();
            include 'index.php';
    }
}
?>
