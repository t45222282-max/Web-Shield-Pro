<?php include 'includes/header.php'; ?>
<?php if(!isset($_SESSION['user_name'])) {
    header ("LOCATION:login.php");
} else { ?>
<div id="content">
    <h1>
        <?php echo $run_u_account['first_name'];?>
        <?php echo $run_u_account['last_name'];?>
    </h1>
    <div class="bloc">
        <div class="title">Edit Your Account</div>
        <div class="content">
            <form method="post" action="val.php?id=<?php echo $id; ?>">
                <div class="input">
                    <label for="input1">First Name</label>
                    <input name="first_name" type="text" id="input1" value="<?php echo $run_u_account['first_name']; ?>">
                </div>
                <div class="input">
                    <label for="input1">Last Name</label>
                    <input name="last_name" type="text" id="input1" value="<?php echo $run_u_account['last_name']; ?>">
                </div>
                <div class="input">
                    <label for="input1">Email</label>
                    <input name="email" type="email" id="input1" value="<?php echo $run_u_account['email']; ?>">
                </div>
                <div class="input">
                    <label for="input1">User Name</label>
                    <input name="username" type="text" id="input1" value="<?php echo $run_u_account['username']; ?>">
                </div>
                <div class="input">
                    <input name="admin" type="hidden" id="input1" value="<?php echo $run_u_account['admin']; ?>">
                </div>
                <div class="submit">
                    <input type="submit" name="update_account" value="Update" class="black">
                    <a href="change_password.php"><input type="button" name="ch_pass" value="Change Your Password" class="black"></a>
                    <input type="submit" name="del_account" value="Delete Account" class="btn-danger">
                    <a href="index.php"><input type="button" name="cancel" value="Cancel" class="black"></a>
                </div>
            </form>
        </div>

    </div>
</div>
<?php } ?>
