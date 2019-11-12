<?php
session_start();
include('db.php');
?>
<!DOCTYPE html>
    <html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">

</head>
<body style="background-color: #bde3c7">
<div id="main-wrapper">
   <center><h2>Home page</h2>
    <h3>Welcome  <br> Name:
        <?php
        $m='';
         $m= $_SESSION['email'];
         $result = mysqli_query($con, "SELECT fullname FROM `userinfo` WHERE email='".$m."'") or die(mysqli_error());
       $row= mysqli_fetch_row($result);
      $str = implode(",",$row);
      echo $str;

         ?>
           <br>Gender:
           <?php
        $m='';
         $m= $_SESSION['email'];
         $result = mysqli_query($con, "SELECT 	gender FROM `userinfo` WHERE email='".$m."'") or die(mysqli_error());
       $row= mysqli_fetch_row($result);
      $str = implode(",",$row);
      echo $str;

         ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;






          Email:    
         <?php echo $_SESSION['email']; ?> 
         <br>Qualification:
           <?php
        $m='';
         $m= $_SESSION['email'];
         $result = mysqli_query($con, "SELECT 	qualification FROM `userinfo` WHERE email='".$m."'") or die(mysqli_error());
       $row= mysqli_fetch_row($result);
      $str = implode(",",$row);
      echo $str;

         ?> &nbsp;&nbsp;
        </h3>
   
   </center>

<form class="myform" action="home.php" method="post">
    
    <input name="logout" type="submit" id="logout_btn" value="Log out"/><br/>
</form>
<?php  
if (isset($_POST['logout'])) 
{ 
session_destroy();
header('location:index.php');
}
?>
</div>
</body>
</html>
