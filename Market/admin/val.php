<?php include '../library/database.php'; ?>
<?php
//--------------------------------------------------- ADD CATEGORY ---------------------------------------------------------
if (isset($_POST['submit'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST["name"] != trim("")) {
            $patern = "/^([a-zA-Z_ ]{2,20})$/";
            if (preg_match($patern, $_POST['name']) != FALSE) {
                $name = mysqli_real_escape_string($con, $_POST['name']);
                $insert_query = "insert into categories (name) values ('$name')";
                if (mysqli_query($con, $insert_query)) {
                    include 'index.php';
                    echo "<script>alert('Data has been inserted')</script>";
                    exit ();
                }
            } else {
                include 'add_category.php';
                echo "<script>alert('Category Name must be at least 4 charecteres and must contian this(a-z,A-Z,_)')</script>";
                exit ();

            }
        } else {
            include 'add_category.php';
            echo "<script>alert('fill')</script>";
            exit ();
        }

    } else {
        include 'add_category.php';
        echo "<script>alert('Please fill correct data')</script>";
        exit ();
    }
}
//--------------------------------------------------- END ADD CATEGORY ---------------------------------------------------------

//--------------------------------------------------- ADD PRODUCT ---------------------------------------------------------
if (isset($_POST['add_prod'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST["title"] != trim("") && $_FILES["image"]['name'] != trim("") && $_POST["description"] != trim("") && $_POST["price"] != trim("") && $_POST["keywords"] != trim("")) {
            $patern = "/^([a-zA-Z0-9999._ ]{3,20})$/";
            if (preg_match($patern, $_POST["title"]) != FALSE) {
                $patern1 = "/^([a-zA-Z0-9999_&=+]{1,300}).([jpg-png-jpeg-png]{3,4})$/";
                if (preg_match($patern1, $_FILES["image"]['name']) != FALSE) {
                    $patern2 = "/^([a-zA-Z,._%&-+=0-9999 ]{3,9999})$/";
                    if (preg_match($patern2, $_POST["description"]) != FALSE) {
                        $patern3 = "/^([0-9]{1,10000})$/";
                        if (preg_match($patern3, $_POST["price"]) != FALSE) {
                            $patern3 = "/^([a-zA-Z,._%-0-9999' ]{2,1000})$/";
                            if (preg_match($patern3, $_POST["keywords"]) != FALSE) {
                                //Assign Vars.
                                $category_id = mysqli_real_escape_string($con, $_POST['category_id']);
                                $uid = mysqli_real_escape_string($con, $_POST['userid']);
                                $title = mysqli_real_escape_string($con, $_POST['title']);
                                $image = mysqli_real_escape_string($con, $_FILES['image']['name']);
                                $image_tmp = mysqli_real_escape_string($con, $_FILES['image']['tmp_name']);
                                $description = mysqli_real_escape_string($con, $_POST['description']);
                                $price = mysqli_real_escape_string($con, $_POST['price']);
                                $keyword = mysqli_real_escape_string($con, $_POST['keywords']);
                                $ext = explode('.',$_FILES['image']['name']);
                                $new_name = time() . '.' . $ext[1];
                                move_uploaded_file($_FILES['image']['tmp_name'], "../images/$new_name");
                                $insert_query = "insert into products (category_id,user_id,title,image,description,price,keywords) values ('$category_id','$uid','$title','$new_name','$description','$price','$keyword')";
                                if (mysqli_query($con, $insert_query)) {
                                    include 'index.php';
                                    echo "<script>alert('Data has been inserted')</script>";
                                    exit ();
                                    //Validation
                                }
                            } else {
                                include "add_product.php";
                                echo "<script>alert('Keywords Must be at least 4 digits and contain (a-z A-Z 0-9999 ,\'._%-)')</script>";

                            }
                        } else {
                            include "add_product.php";
                            echo "<script>alert('Price must be at least 1 - 10000 digits and contain only numbers.')</script>";
                        }
                    } else {
                        include "add_product.php";
                        echo "<script>alert('Description must be at least 3 to 200 digits and contain only a-zA-Z,._%&-+=0-9999')</script>";
                    }
                } else {
                    include "add_product.php";
                    echo "<script>alert('Image must be JPG or PNG only')</script>";
                }
            } else {
                include "add_product.php";
                echo "<script>alert('Title must be at least 3 to 20 digits')</script>";
            }
        } else {
            include "add_product.php";
            echo "<script>alert('Please fill all fields')</script>";
        }

    } else {
        include "add_product.php";
        echo "<script>alert('Please Enter correct data')</script>";
    }
}

//------------------------------------------------------------------ END ADD PRODUCT ---------------------------------------------------------------
?>

<?php
//--------------------------------------------------- CHANGE PASSWORD ---------------------------------------------------------
$id = $_GET['id'];
$user = mysqli_query($con, "select * from users where id='$id'");
$run_user = mysqli_fetch_array($user);
if (isset($_POST['update_pass'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST["old_pass"] != trim("") && $_POST["new_pass"] != trim("") && $_POST["new_pass2"] != trim("")) {
            if (md5($_POST['old_pass']) == $run_user['password']) {
                if ($_POST["old_pass"] != FALSE) {
                    if ($_POST["new_pass"] == $_POST["new_pass2"]) {
                        $patern1 = "/^([a-zA-Z0-9_.-]{7,50})$/";
                        if (preg_match($patern1, $_POST["new_pass"]) != FALSE) {
                            $npass = $_POST['new_pass'];
                            $update_query = "update users set password = MD5('$npass') where id = '$id'";
                            if (mysqli_query($con, $update_query)) {
                                include 'account.php';
                                echo "<script>alert('You have been chaned your password successfully')</script>";
                                exit ();

                            }
                        } else {
                            //include "change_password.php";
                            include "change_password.php";
                            echo "<h2><center></b>" . "<font color=red>" . "  New Password must be at least 8-50 digits and contain only (a-z A-Z 0-9 _ - .) Without SPACES";
                        }
                    } else {
                        include "change_password.php";
                        echo "<h2><center></b>" . "<font color=red>" . "  New Password and Conferm New Password are not the same";
                    }
                } else {
                    header("location:change_password.php");
                    echo "<h2><center></b>" . "<font color=red>" . "  Please Enter Your Old Password ";
                }
            } else {
                include "change_password.php";
                echo "<h2'><center></b>" . "<font color=red>" . " Old Password isn't correct ";
            }
        } else {
            include "change_password.php";
            echo "<h2><center></b>" . "<font color=red>" . " You Must Fill All Feilds ";
        }
    } else {
        include "change_password.php";
        echo "<h2><center></b>" . "<font color=red>" . " Please fill correct data ";
    }
}
//--------------------------------------------------- END CHANGE PASSWORD ---------------------------------------------------------

//--------------------------------------------------- UPDATE ACCOUNT ---------------------------------------------------------
if (isset($_POST['update_account'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST["first_name"] != trim("") && $_POST["last_name"] != trim("") && $_POST["email"] != trim("") && $_POST["username"] != trim("")) {
            $patern = "/^([a-zA-Z]{3,20})$/";
            if (preg_match($patern, $_POST["first_name"]) != FALSE) {
                $patern1 = "/^([a-zA-Z ]{3,10})$/";
                if (preg_match($patern1, $_POST["last_name"]) != FALSE) {

                    $patern2 = "/^([a-zA-Z0-9_]{2,20})@([a-zA-Z]{3,20}).([a-zA-Z0-9]{2,4})$/";
                    if (preg_match($patern2, $_POST["email"]) != FALSE) {
                        $patern3 = "/^([a-zA-Z0-9_ ]{3,10})$/";
                        if (preg_match($patern3, $_POST["username"]) != FALSE) {
                            $fname = mysqli_real_escape_string($con, $_POST['first_name']);
                            $lname = mysqli_real_escape_string($con, $_POST['last_name']);
                            $email = mysqli_real_escape_string($con, $_POST['email']);
                            $username = mysqli_real_escape_string($con, $_POST['username']);
                            $update_query = "update users set first_name = '$fname',last_name='$lname',email='$email',username='$username' where id = '$id'";
                            if (mysqli_query($con, $update_query)) {
                                include 'index.php';
                                echo "<script>alert('You have been update your account successfully')</script>";
                                exit ();

                            }
                        } else {
                            include "account.php";
                            echo "<h2 style='font-size:18px;'><center><b>" . "<font color=red>" . " Username Must be at least 3-10 digits and contain only:(a-z,A-Z,0-9,_,-)";
                        }
                    } else {
                        include "account.php";
                        echo "<h2 style='font-size:18px;'><center><b>" . "<font color=red>" . " Wrong Email (example@example.com) Without SPACES";
                    }


                } else {
                    include "account.php";
                    echo "<h2 style='font-size:18px;'><center><b>" . "<font color=red>" . "Lastname must be at least 3-10 digits and contain only:(a-z,A-Z) ";
                }
            } else {
                include "account.php";
                echo "<h2 style='font-size:18px;'><center><b>" . "<font color=red>" . "First Name must be at least 3-10 digits and contain only:(a-z,A-Z) Without SPACES";

            }
        } else {
            echo "<h2><center></b>" . "<font color=brown>" . " Please fill all fields";
            include "account.php";
        }

    } else {
        include "account.php";
        echo "<h2><center></b>" . "<font color=brown>" . " Please Enter correct data ";
    }
}
//--------------------------------------------------- END UPDATE ACCOUNT ---------------------------------------------------------

//--------------------------------------------------- DELETE ACCOUNT ---------------------------------------------------------
if (isset($_POST['del_account'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $del_query = "delete from users where id='$id'";
        if (mysqli_query($con, $del_query)) {
            session_start();
            header("LOCATION:index.php");
            session_destroy();
        }
    }
}
?>