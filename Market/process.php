<?php include 'library/database.php';
    //Validation
   if ($_SERVER["REQUEST_METHOD"] == "POST") 
                 {
        
                   if ( $_POST["first_name"]!= trim("") && $_POST["last_name"]!= trim("") && $_POST["email"]!= trim("") && $_POST["username"]!= trim("")&& $_POST["password"]!= trim("") && $_POST["password2"]!= trim("")) 
                   {
                       $patern="/^([a-zA-Z]{3,20})$/";
                     if ( preg_match($patern,$_POST["first_name"])!=FALSE)
                     {
                         $patern1="/^([a-zA-Z]{3,10})$/";
                         if(preg_match($patern1,$_POST["last_name"])!=FALSE)
                         {
                             
                                $patern2="/^([a-zA-Z0-9_-]{2,20})@([a-zA-Z]{3,20}).([a-zA-Z0-9]{2,4})$/";
                                 if(preg_match($patern2,$_POST["email"])!=FALSE)
                                 {
                                     $patern3="/^([a-zA-Z0-9_-]{3,10})$/";
                                        if(preg_match($patern3,$_POST["username"])!=FALSE)
                                        {
                                            if($_POST["password"]==$_POST["password2"])
                                            {
                                                $patern4="/^([a-zA-Z0-9_.-]{7,50})$/";
                                                if(preg_match($patern4,$_POST["password"])!=FALSE)
                                                    {
                                                        $fname = mysqli_real_escape_string($con,$_POST['first_name']);
                                                        $lname = mysqli_real_escape_string($con,$_POST['last_name']);
                                                        $email = mysqli_real_escape_string($con,$_POST['email']);
                                                        $username= mysqli_real_escape_string($con,$_POST['username']);
                                                        $password= mysqli_real_escape_string($con,$_POST['password']);
                                                        $confirmpass= mysqli_real_escape_string($con,$_POST['password2']);
                                                        //$salt = base64_encode(mcrypt_create_iv((12), MCRYPT_DEV_URANDOM));
                                                        $insert_query = "insert into users (first_name,last_name,email,username,password) values ('$fname','$lname','$email','$username',MD5('$password'))";
                                                        if (mysqli_query($con,$insert_query)) {
                                                        include 'index.php';
                                                        echo "<script>alert('You have been registered successfully')</script>";
                                                        exit ();


                                                        }
                                                    }
                                                else 
                                                    {
                                                        include "register.php";
                                                        echo"<h2><center></b>". "<font color=red>" . " طول كلمة المرور يجب ان يكون 8 احرف على الأقل وتحوي فقط على (a-z A-Z 0-9 _ - .) ";
                                                    }


                                                    }
                                            else 
                                                {
                                                    include "register.php";
                                                    echo"<h2><center></b>". "<font color=red>" . " كلمة المرور غير متطابقة تأكد من كتابتها بشكل صحيح ";
                                                }
                                

                                            }
                             else 
                                 {
                                   include "register.php";
                                   echo"<h2><center></b>". "<font color=red>" . " إسم المستخدم يجب ان يتكون من 3 احرف على الأقل ويحوي (a-z,A-Z,0-9,_,-) ";
                                 } 
                         }
                         else 
                             {
                               include "register.php";
                               echo"<h2><center></b>". "<font color=red>" . " خطأ في إدخال الإيميل يجب ان يكون على الصورة التالية (example@example.com) ";
                             }
                       
                         
                     }
                     else 
                         {
                           include "register.php";
                           echo"<h2><center></b>". "<font color=red>" . "الإسم الأخير يجب ان يتكون من 3 احرف على الأقل ويتكون من (a-z,A-Z) ";
                         }
                   }
                 else{
                     include "register.php";
                     echo"<h2><center></b>". "<font color=red>" . "الإسم الأول يجب ان يتكون من 3 احرف على الأقل ويتكون من (a-z,A-Z)";
                     
                 }
                 }
         else 
             {
             include "register.php";
                echo"<h2><center></b>". "<font color=brown>" . " الرجاء تعبئة كافة الحقول ";
              }
                     
                             }
         else 
             {
             include "register.php";
                echo"<h2><center></b>". "<font color=brown>" . " الرجاء إدخال بيانات صحيحة للتسجيل ";
              }

    ?>
