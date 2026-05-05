<?php include 'includes/header.php';?>
<?php 
$category = "SELECT * FROM categories";
//Run Query 
$run_category = mysqli_query($con,$category);

$prod = "select * from products";
$run_prod = mysqli_query($con,$prod);
$run = mysqli_fetch_array($run_prod);
$user_id = $_COOKIE['id'];
$users = mysqli_query ($con,"select * from users where id ='$user_id'");
$user = mysqli_fetch_array($users);
?>
<div id="content">
    <h1>Products</h1>
    <div class="bloc">
        <div class="title">Add Product</div>
        <div class="content">
            <form role="form" method="post" action="val.php" enctype="multipart/form-data">
                <div class="input">
                    <label for="input1">Product title</label>
                    <input name="title" type="text" id="input1" placeholder="Enter Title">
                </div>
                <div class="input textarea">
                    <label for="textarea1">Description</label>
                    <textarea name="description" id="textarea1" rows="3" cols="4"></textarea>
                </div>
                <div class="input">
                    <label for="select">Category</label>
                    <select name="category_id" id="select">
<?php while($row= mysqli_fetch_array($run_category)): ?>
<?php if ($row['id'] == $run['category_id']) {
    $selected='selected';
} else {
    $selected='';
}
?>
<option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>>
    <?php echo $row['name']; ?>
</option>
<?php endwhile; ?>
</select>
                </div>
                <div class="input">
                    <label>Image</label>
                    <input type='file' name='image' id='file' />
                </div>
                <div class="input">
                    <label for="input1">Price: $</label>
                    <input type='text' name='price' id='price' />
                </div>
                <div class="input">
                    <label for="input1">Keywords</label>
                    <input name="keywords" type="text" id="input1" placeholder="Keywords">
                </div>
                <div>
                    <input type="hidden" name="userid" value="<?php echo $user['id'];?>"> </div>
                <div class="submit">
                    <input type="submit" name="add_prod" value="Confirm" class="black">
                    <a href="index.php"><input type="button" name="cancel" value="Cancel" class="black"></a>
                </div>
            </form>
        </div>

    </div>
</div>
