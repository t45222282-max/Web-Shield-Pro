<?php  ?>
<?php include ("../library/database.php");
if (isset($_POST['login'])){
    $uname=mysqli_real_escape_string($con,$_POST['user_name']);
    $pass=mysqli_real_escape_string($con,$_POST['password']);
    $query = "SELECT * FROM users WHERE username='$uname' AND password=MD5('$pass') AND active='1'";
    $run = mysqli_query($con,$query);
    if($user= mysqli_fetch_assoc($run)){
    //if (mysqli_num_rows($run)>0){
        setcookie('user_name', $uname, time () + 60 * 60 * 24 * 30);
        //setcookie('password', MD5("$upass$salt"), time () + 60 * 60 * 24 * 30);
        setcookie('id', $user['id'], time () + 60 * 60 * 24 * 30);
  //      if (isset($_COOKIE['user_name'])){
            session_start();
        $_SESSION['user_name']=$uname;
        $_COOKIE['id'] = $user['id'];
        //$_SESSION['id']=$user['id'];
        $u=$_COOKIE['user_name']; //= $_SESSION['user_name'];
// echo "
//<script>
//    window.open('index.php', '_self')
//</script>
//";
        mysqli_close($con);
        header("Location: index.php");
//    } else {
//        echo "<script>alert('User name or password is not correct or your account is not activated yet')</script>";
    }else {
        echo "<script>alert('password is not correct or your account is not activated yet')</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Your Admin Panel</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <!-- Reset all CSS rule -->
    <link rel="stylesheet" href="css/reset.css" />

    <!-- Main stylesheed  (EDIT THIS ONE) -->
    <link rel="stylesheet" href="css/style.css" />

    </script>

</head>

<body>
    <div id="content" class="login">

        <h1><img src="css/img/img/icons/locked.png" alt="" />Admin panel</h1>
        <form method="post" action="login.php">

            <div class="input placeholder">
                <input type="text" name="user_name" id="login" placeholder="Username" />
            </div>
            <div class="input placeholder">
                <input type="password" name="password" id="pass" placeholder="Password" />
            </div>

            <div class="submit">
                <input type="submit" name="login" value="LOGIN" />
            </div>
        </form>


    </div>


</body>

</html>
