<?php include 'includes/header.php';?>
<?php 
if(!isset($_COOKIE['user_name']) && ($_COOKIE['id'])){
    header("LOCATION:login.php");
}else {
?>
<?php
//Creat Query
$products = "SELECT products.*,categories.name FROM products
INNER JOIN categories ON products.category_id=categories.id";
//Run Query
$run_products= mysqli_query($con,$products);

//Create Query
$categories = "SELECT * FROM categories";

//Run Query
$run_categories = mysqli_query ($con,$categories);
    
    
$users= "SELECT * FROM users where admin = '0'";
//Run Query
$run_users = mysqli_query ($con,$users);
?>
    <!--            
              CONTENT 
                        -->
    <div id="content">
        <?php if ($act>0) : ?>
        <?php if ($check_unactive>0) { ?>
        <div class="bloc">
            <div class="title">Unactivated Users</div>
            <div class="content">
                <table class="table table-striped">
                    <tr>
                        <th>User #ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Username</th>

                        <th>Join Date</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_array($run_un)): ?>
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
                            <?php echo $row['join_date'];?>
                        </td>
                        <td style="text-align:right">
                            <form method="post" action="active_user.php?id=<?php echo $row['id'];?>">
                                <input type="submit" name="active_user" value="Active" class="btn-active">
                            </form>
                        </td>

                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
        <?php } ;?>
        <div class="bloc">
            <div class="title">Products</div>
            <div class="content">
                <table class="table table-striped">
                    <tr>
                        <th>Product #ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Keywords</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Edit</th>
                    </tr>

                    <?php while ($row = mysqli_fetch_array($run_products)): ?>
                    <tr>
                        <td>
                            <?php echo $row['id'];?>
                        </td>
                        <td>

                            <?php echo $row['title'];?>

                        </td>
                        <td>
                            <?php echo $row['name'];?>
                        </td>
                        <td>
                            <?php echo $row['description'];?>
                        </td>
                        <td>
                            <?php echo $row['keywords'];?>
                        </td>
                        <td>
                            <img src="../images/<?php echo $row['image'];?>" />
                        </td>
                        <td>
                            <?php echo $row['price'];?>
                        </td>
                        <td style="text-align:right">
                            <a href="edit_product.php?id=<?php echo $row['id'];?>"><button name="edit" class="black">Edit</button></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>

                </table>

            </div>
        </div>

        <div class="bloc">
            <div class="title">Categories</div>
            <div class="content">
                <table class="table table-striped">
                    <tr>
                        <th>Category #ID</th>
                        <th>Category Name</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_array($run_categories)): ?>
                    <tr>
                        <td>
                            <?php echo $row['id'];?>
                        </td>

                        <td>
                            <?php echo $row['name'];?>
                        </td>
                        <td style="text-align:right">
                            <a href="edit_category.php?id=<?php echo $row['id'];?>"><button name="edit" class="black">Edit</button></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>

            </div>
        </div>

        <div class="bloc">
            <div class="title">Users</div>
            <div class="content">
                <table class="table table-striped">
                    <tr>
                        <th>User #ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Username</th>

                        <th>Join Date</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_array($run_users)): ?>
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
                            <?php echo $row['join_date'];?>
                        </td>
                        <td style="text-align:right">
                            <a href="admin_edit_user.php?id=<?php echo $row['id'];?>"><button name="edit" class="black">Edit</button></a>
                        </td>

                    </tr>
                    <?php endwhile; ?>
                </table>

            </div>
        </div>
        <?php endif ;?>

        <?php if ($act==0):?>
        <div class="bloc">
            <div class="title">Your Products</div>
            <?php if (mysqli_num_rows($run_u_products)>0) :?>
            <div class="content">
                <table class="table table-striped">
                    <tr>
                        <th>Product #ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Keywords</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Edit</th>
                    </tr>

                    <?php while ($row = mysqli_fetch_array($run_u_products)): ?>
                    <tr>
                        <td>
                            <?php echo $row['id'];?>
                        </td>
                        <td>

                            <?php echo $row['title'];?>

                        </td>
                        <td>
                            <?php echo $row['name'];?>
                        </td>
                        <td>
                            <?php echo $row['description'];?>
                        </td>
                        <td>
                            <?php echo $row['keywords'];?>
                        </td>
                        <td>
                            <img src="../images/<?php echo $row['image'];?>" />
                        </td>
                        <td>
                            <?php echo $row['price'];?>
                        </td>
                        <td style="text-align:right">
                            <a href="edit_product.php?id=<?php echo $row['id'];?>"><button name="edit" class="black">Edit</button></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>

                </table>

            </div>
            <?php else :?>
            <h2 style="padding:20px; font-size:20px; font-weight:bold; text-align:center; color:blue;">You haven't post any products yet</h2>
            <?php endif; ?>
        </div>
        <?php endif ;?>
    </div>


    <!-- FOOTER -->
    </body>

    </html>
    <?php } ?>
