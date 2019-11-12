<?php
require 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/parsley.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/themes/bootstrap.rtl.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.1/parsley.js"></script>
<title>Registration Page</title>
<link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #7f8c8d">

   <form style="padding: 10px;" class="myform" action="register.php" method="post" class="myform" data-parsley-validate>
    <div id="main-wrapper">
   <center><h2>Registration Form</h2>
   
   </center>
         <label><b>FullName</b></label><br/>
    <input name="fullname" type="text" class="inputvalues" placeholder="Enter fullname" required data-parsley-pattern="^[a-zA-Z ]*$" data-parsley-trigger="keyup"  /><br/>
     <label><b>Gender:</b></label>
     <input  type="radio" class="radiobtns" name="gender" value="male" required  />Male
     <input  type="radio" class="radiobtns" name="gender" value="female"  required  />Female
     <input  type="radio" class="radiobtns" name="gender" value="transgender"  required  />Transgender<br>
      <label><b>Qualification</b></label>
      <select class="qualification" name="qualification" required >
        <option value="" > Select </option>
          <option value="B.Tech">B.Tech</option>
           <option value="Bsc">Bsc</option>
            <option value="BE">BE</option>
             <option value="BMS">BMS</option>
      </select><br/>
    
    <label><b>Email:</b></label><br>
       <input name="email" id="email" type="text"  class="inputvalues" placeholder="Enter your email"    required data-parsley-type="email" data-parsley-trigger="keyup"/>
    <label><b>Password</b> </label>
    <input name="password" type="password" id="form_password" class="inputvalues" placeholder="Enter password"  required data-parsley-minlength="8" data-parsley-trigger="keyup" />
    <label><b>Confirm Password</b> </label>
    <input name="cpassword" type="password" class="inputvalues" placeholder="Confirm password"   required data-parsley-equalto="#form_password" data-parsley-trigger="keyup"/>

    <input name="submit_btn" type="submit" id="signup_btn" value="Singn Up"/><br/>
    <a href="index.php"><input type="button" name="loginSubmit"  id="back_btn" value="Login"/></a><br/>
  </div>
</form>
   <?php
     if(isset($_POST['submit_btn']))
      {
         
        // echo '<script type="text/javascript">alert("Sign|button clicked")</script>';
        $email=$_POST['email'];
        $fullname=$_POST['fullname'];
        $gender=$_POST['gender'];
        $qualification=$_POST['qualification'];
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
        $trn_date = date("Y-m-d H:i:s");
        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

         if (filter_var($emailB, FILTER_VALIDATE_EMAIL) === false ||
          $emailB != $email
          ) {
      echo '<script type="text/javascript">alert("This email adress isn\'t valid!")</script>';
      exit(0);
    }
        if($password==$cpassword)
        {
           $query="select * from userinfo where email='$email'";
           $query_run=mysqli_query($con,$query);
           if(mysqli_num_rows($query_run)>0)
           {
             //there is l=already a user with the same username
             echo '<script type="text/javascript">alert("Email already exists..try another email")</script>';

           }
           else
           {
             $query="insert into userinfo values('','$fullname','$gender','$qualification','$email','".md5($password)."','$trn_date')";
             $query_run=mysqli_query($con,$query);
             if($query_run)
             {
                 echo '<script type="text/javascript">alert("User Registered..Go to login page to login")</script>';
                 
                 header('location:index.php');
             }
             else
             {
                 echo '<script type="text/javascript">alert("Error!")</script>';
             }




           }

        }
        else
        {
            echo '<script type="text/javascript">alert("Your password and confirm password does not match")</script>';

        }




      }




    ?>
</div>

</body>
</html>