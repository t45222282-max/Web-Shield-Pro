<?php include 'includes/header.php'; ?>
<div id="content">
    <div class="bloc">
        <div class="title">Your Products</div>
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
    </div>
</div>

</body>

</html>
