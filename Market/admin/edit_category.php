<?php include 'includes/header.php'; ?>
<?php 
$id=$_GET['id'];
//Creat Query 
$query = "SELECT * FROM categories WHERE id=".$id;
//Run Query 
$category=mysqli_query($con,$query);
if (isset($_POST['submit'])){
    //Assign Vars.
    $name = mysqli_real_escape_string($con,$_POST['name']);
    //Validation
    if ($name==''){
        include 'edit_category.php';
        echo "<script>alert('fill all fields')</script>";
        exit ();
    } else {
        $update_query = "update categories set name='$name' where id=$id";
        if (mysqli_query($con,$update_query)) {
            include 'edit_category.php';
            echo "<script>alert('Data has been updated')</script>";
            exit ();
        }
    }
}
if (isset($_POST['delete'])){
    $del_query = "delete from categories where id=$id";
    if (mysqli_query($con,$del_query)){
        include 'edit_category.php';
            echo "<script>alert('Data has been deleted')</script>";
            exit ();
    }
}
?>

<div id="content">
    <h1>Categories</h1>
    <div class="bloc">
        <div class="title">Edit Category</div>
        <div class="content">
            <?php while ($row = mysqli_fetch_array($category)) :?>
            <form role="form" method="post" action="edit_category.php?id=<?php echo $id; ?>">
                <div class="input">
                    <label for="input1">Category Name</label>
                    <input name="name" type="text" id="input1" placeholder="Enter Category Name" value="<?php echo $row['name']; ?>">
                </div>
                <div class="submit">
                    <input type="submit" name="submit" value="Confirm" class="black">
                    <a href="index.php"><input type="button" name="cancel" value="Cancel" class="black"></a>
                    <input type="submit" name="delete" value="Delete" class="btn-danger">
                </div>
            </form>
            <?php endwhile; ?>
        </div>

    </div>
</div>
