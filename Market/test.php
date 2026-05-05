<html>

<head>
    <meta charset="UTF-8">
    <title></title>
</head>

<body>
    <table cellpadding="5" cellspacing="10" align="center">
        <form method="post" action="test.php">
            <tr>
                <th>Username:</th>
                <td><input type="text" name="user"></td>
            </tr>
            <tr>
                <th>Password:</th>
                <td><input type="password" name="pass"></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" value="Login" name="login"></td>
            </tr>
        </form>


        <?php
       if(isset($_POST['login']))
            {
                if(!empty($_POST['user'])&& !empty($_POST['pass']))
                {
                    
                    $link = mysqli_connect("localhost", "root", "","project");
                    $username= mysqli_real_escape_string($link,$_POST['user']);
                    $password=mysqli_real_escape_string($link,$_POST['pass']);
                    $sql = "SELECT salt FROM test WHERE username='$username'";
                    $result = mysqli_query($link, $sql); //execute the query
                   // var_dump($result);
                    if($row = mysqli_fetch_assoc($result))
                {
                    $salt = $row['salt'];
                    
                   $saltSql = "SELECT username FROM test WHERE username='$username' AND  password=MD5('$password$salt')";
                   $finalResult = mysqli_query($link, $saltSql);
                    if($finalrow = mysqli_fetch_assoc($finalResult))
                        {
                       echo "wlecome ".$finalrow['username'];
                        }
                        else {
                            echo "invailds  password";
                        }
                    }
                    else{
                        echo 'username is wrong';
                    }
                }
                else {
                    echo 'Username and Password shuold not be empty ??? ';
                    
                }
            }
            else
                {
                echo 'Fill the username and password then press Register';
                
                }
                
                ?>
</body>

</html>
