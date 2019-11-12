<?php
session_start();
require 'db.php';
?>
<!DOCTYPE html>
    <html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">

</head>
<body style="background-color: #bde3c7">
<div id="main-wrapper">
   <center><h2>Login Form</h2>
    <img src="images/stev.jpg" class="avatar"></center>

<form class="myform" action="index.php" method="post">
    <label><b>Email</b></label><br/>
    <input name="email" type="text" class="inputvalues"  placeholder="enter email" value ="<?php if(isset($_COOKIE['email'])) echo $_COOKIE['email']; ?>" required />
    <label><b>Password</b> </label><br/>
    <input  name="password" type="password" class="inputvalues" placeholder="enter password"  value ="<?php if(isset($_COOKIE['password'])) echo $_COOKIE['password']; ?>"required />
    <input type="checkbox" name="remember" id ="remember"
    value="1" <?php if(isset($_COOKIE['email'])){echo "checked='checked'";}?> >
    <label for="remember"> Remember Me</label>
    <a href="email.php"> <span style="margin-left: 340px; ">ForgetPassword</span></a>


    
    
    <input name="login" type="submit" id="login_btn" value="Login"/><br/>
   <a href="register.php"> <input type="button" id="register_btn" value="Register"/></a><br/>
</form>
<?php 
if (isset($_POST['login'])) {
    $email=$_POST['email'];
     $password=$_POST['password'];
   if(isset($_REQUEST['remember']))
    $escapeRemember = mysqli_real_escape_string($con,$_REQUEST['remember']);
 $cookie_time = 60 * 60 * 24 * 30;
   $cookie_time_Onset=$cookie_time+ time();
    if(isset($escapeRemember)) {
        setcookie("email", $email, $cookie_time_Onset);
        setcookie("password", $password, $cookie_time_Onset);
    }else{
        $cookie_time_fromOffset=time() -$cookie_time;
        setcookie("email", '',$cookie_time_fromOffset);
        setcookie("password",'',$cookie_time_fromOffset);
    }
     $query="select * from userinfo WHERE email='$email' AND password='".md5($password)."'";
     $query_run = mysqli_query($con,$query);
     if (mysqli_num_rows($query_run)>0) {
        $row= mysqli_fetch_assoc($query_run);
         //valid
        $_SESSION['email']=$row['email'];
        
        header('location:home.php');
     }
     else
     {
        //invalid
        echo '<script type="text/javascript"> alert("Invalid Creadentials")</script>';
     }

 }
 ?>
</div>
</body>
</html>
