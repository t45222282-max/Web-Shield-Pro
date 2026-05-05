<?php include 'includes/header.php'; ?>
<?php 
$show_admins = mysqli_query($con,"select * from users where admin = '0' and id!='$id'");
?>
<div id="content">
    <h1>Users</h1>
    <div class="bloc">
        <div class="title">Userss List</div>
        <div class="content">
            <table class="table table-striped">
                <tr>
                    <th>#ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                <?php while ($row = mysqli_fetch_array($show_admins)): ?>
                <tr>
                    <td>
                        <?php echo $row['id'];?>
                    </td>

                    <td>
                        <?php echo $row['first_name'];?>
                    </td>
                    <td>
                        <?php echo $row['last_name'];?>
                    </td>
                    <td>
                        <?php echo $row['email'];?>
                    </td>
                    <td>
                        <?php echo $row['username'];?>
                    </td>
                    <td>
                        <?php echo $row['active'] == 1 ? "Active" : "Not Acitve";?>
                    </td>
                    <td style="text-align:right">
                        <td style="text-align:right">
                            <a href="admin_edit_user.php?id=<?php echo $row['id'];?>"><button name="edit" class="black">Edit</button></a>
                        </td>
                    </td>

                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</div>
