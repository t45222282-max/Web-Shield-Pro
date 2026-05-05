<?php include 'includes/header.php'; ?>
<div id="content">
    <h1>Categories</h1>
    <div class="bloc">
        <div class="title">Add Category</div>
        <div class="content">
            <form method="post" action="val.php">
                <div class="input">
                    <label>Category Name</label>
                    <input name="name" type="text" id="input1" placeholder="Enter Category Name">
                </div>
                <div class="submit">
                    <input type="submit" name="submit" value="Confirm" class="black">
                    <a href="index.php"><input type="button" name="cancel" value="Cancel" class="black"></a>
                </div>
            </form>
        </div>

    </div>
</div>
