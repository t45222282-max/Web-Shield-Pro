<?php include 'includes/header.php'; ?>
<?php 
$user_id = $_GET['id'];
//Creat Query 
$user = "SELECT * FROM users WHERE id=".$user_id;
//Run Query 
$run_user = mysqli_query($con,$user);
$run=mysqli_fetch_array($run_user);

$chk_admin = mysqli_query($con,"select * from users where admin = '0' and id= $user_id");
$run_chk = mysqli_fetch_array ($chk_admin);
$chk = mysqli_num_rows($chk_admin);
?>
<?php
if (isset($_POST['del_admin'])){
        $update_query = "update users set admin= '0' where id=$user_id";
        if (mysqli_query($con,$update_query)) {
            echo "<script>alert('You Have Deleted An ADMIN')</script>";
            echo "<script>window.open('edit_admin.php', '_self');</script>";
            exit ();
        }
    }
if (isset($_POST['delete'])){
    $del_query = "delete from users where id=$user_id";
    if (mysqli_query($con,$del_query)){
            echo "<script>alert('User has been deleted')</script>";
            echo "<script>window.open('edit_admin.php', '_self');</script>";
            exit ();
    }
}
?>
    <div id="content">
        <h1>Users</h1>
        <div class="bloc">
            <div class="title">Edit User</div>
            <div class="content">
                <form method="post" action="admin_edit_user.php?id=<?php echo $user_id; ?>">
                    <div class="input">
                        <label for="input1">First Name</label>
                        <input name="first_name" type="text" id="input1" value="<?php echo $run['first_name']; ?>">
                    </div>
                    <div class="input">
                        <label for="input1">Last Name</label>
                        <input name="last_name" type="text" id="input1" value="<?php echo $run['last_name']; ?>">
                    </div>
                    <div class="input">
                        <label for="input1">Email</label>
                        <input name="email" type="email" id="input1" value="<?php echo $run['email']; ?>">
                    </div>
                    <div class="input">
                        <label for="input1">Join Date</label>
                        <label for="input1"><?php echo $run['join_date'];?></label>

                    </div>
                    <div class="input">
                        <input name="admin" type="hidden" id="input1" value="<?php echo $run['admin']; ?>">
                    </div>
                    <div class="submit">
                        <input type="submit" name="del_admin" value="Delete Admin Privilege" class="btn-danger">
                        <input type="submit" name="delete" value="Delete User" class="btn-danger">
                        <a href="index.php"><input type="button" name="cancel" value="Cancel" class="black"></a>
                    </div>
                </form>
            </div>

        </div>
    </div>
