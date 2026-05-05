<?php include 'includes/header.php'; ?>
<div id="content">
    <h1>
        <?php echo $run_u_account['first_name'];?>
        <?php echo $run_u_account['last_name'];?>
    </h1>
    <div class="bloc">
        <div class="title">Change Password</div>
        <div class="content">
            <form method="post" action="val.php?id=<?php echo $id; ?>">
                <div class="input">
                    <label for="input1">Old Password</label>
                    <input name="old_pass" type="password" id="input1" placeholder="Enter your old password">
                </div>
                <div class="input">
                    <label for="input1">New Password</label>
                    <input name="new_pass" type="password" id="input1" placeholder="Enter New Password">
                </div>
                <div class="input">
                    <label for="input1">Confirm Password</label>
                    <input name="new_pass2" type="password" id="input1" placeholder="Confirm Password">
                </div>
                <div class="submit">
                    <input type="submit" name="update_pass" value="OK" class="black">
                    <a href="account.php"><input type="button" name="cancel" value="Cancel" class="black"></a>
                </div>
            </form>
        </div>

    </div>
</div>
