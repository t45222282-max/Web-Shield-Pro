<?php include '../library/database.php'; 
$user_id = $_GET['id'];
if (isset($_POST['active_user'])){
        $update_query = "update users set active = '1' where id=$user_id";
        if (mysqli_query($con,$update_query)) {
            include 'index.php';
            echo "<script>alert('User has been Activiated')</script>";
            exit ();
        }
    }
?>
<form method="post" action="active_user">
    <input type="hidden" name="active_user" value="<?php echo $run['active'];?>">
</form>
