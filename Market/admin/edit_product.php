<?php include 'includes/header.php'; ?>
<?php
$product_id = $_GET['id'];
//Creat Query 
$product = "SELECT * FROM products WHERE id=" . $product_id;
//Run Query 
$run_product = mysqli_query($con, $product);
$run = mysqli_fetch_array($run_product);
//Creat Query 
$category = "SELECT * FROM categories";
//Run Query 
$run_category = mysqli_query($con, $category);
?>
<?php
if (isset($_POST['submit'])) {
    //Assign Vars.
    $category_id = $_POST['category_id'];
    $title = $_POST['title'];
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $keyword = $_POST['keywords'];
    //Validation
    if ($title == '' || $description == '' || $category_id == '' || $price == '') {
        echo "<script>alert('fill all fields')</script>";
        exit ();
    } else {
        if ($image != '') {
            $ext = explode('.', $_FILES['image']['name']);
            $new_name = time() . '.' . $ext[1];
            move_uploaded_file($_FILES['image']['tmp_name'], "../images/$new_name");
            $insert_query = "update products set category_id='$category_id',title='$title',image='$new_name',description='$description',price='$price',keywords='$keyword' where id='$product_id'";
        } else {
            $insert_query = "update products set category_id='$category_id',title='$title',description='$description',price='$price',keywords='$keyword' where id='$product_id'";
        }
        if (mysqli_query($con, $insert_query)) {
            header("LOCATION:index.php");
            echo "<script>alert('Data has been inserted')</script>";
            exit ();
        }
    }
}

if (isset($_POST['delete'])) {
    $del_query = "delete from products where id=$product_id";
    if (mysqli_query($con, $del_query)) {
        echo "<script>alert('Data has been deleted')</script>";
        exit ();
    }
}
?>
<div id="content">
    <h1>Products</h1>
    <div class="bloc">
        <div class="title">Edit Product</div>
        <div class="content">
            <form method="post" action="edit_product.php?id=<?php echo $product_id; ?>" enctype="multipart/form-data">
                <div class="input">
                    <label for="input1">Product title</label>
                    <input name="title" type="text" id="input1" placeholder="Enter Title"
                           value="<?php echo $run['title']; ?>">
                </div>
                <div class="input textarea">
                    <label for="textarea1">Description</label>
                    <textarea name="description" id="textarea1" rows="3" cols="4">
                        <?php echo $run['description']; ?>
                    </textarea>
                </div>
                <div class="input">
                    <label for="select">Category</label>
                    <img src="../images/<?php echo $run['image']; ?>" style="float:right; width:300px; height: 270px;">
                    <select name="category_id" id="select">
                        <?php while ($row = mysqli_fetch_array($run_category)) : ?>
                            <?php if ($row['id'] == $run['category_id']) {
                                $selected = 'selected';
                            } else {
                                $selected = '';
                            }; ?>
                            <option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>><?php echo $row['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="input">
                    <label>Image</label>
                    <input type="button" value="Change Picture" id="change_pic">
                    <input type="file" id="pic" style="display:none" name='image' value="<?php echo $run['image']; ?>">
                    <!--<input type='file' name='image' id='file' value="" />-->

                    <script>
                        $(function () {
                            $('#change_pic').on('click', function () {
                                $('#pic').trigger('click');
                            })
                        })

                    </script>
                </div>
                <div class="input">
                    <label for="input1">Price: $</label>
                    <input type='text' name='price' id='price' value="<?php echo $run['price']; ?>"/>
                </div>
                <div class="input">
                    <label for="input1">Keywords</label>
                    <input name="keywords" type="text" id="input1" value="<?php echo $run['keywords']; ?>">
                </div>
                <div class="submit">
                    <input type="submit" name="submit" value="Confirm" class="black">
                    <a href="index.php"><input type="button" name="cancel" value="Cancel" class="black"></a>
                    <input type="submit" name="delete" value="Delete" class="btn-danger">
                </div>
            </form>
        </div>

    </div>
</div>
