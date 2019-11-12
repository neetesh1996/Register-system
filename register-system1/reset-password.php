<?php
include('db.php');
if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) 
&& ($_GET["action"]=="reset") && !isset($_POST["action"])){
  $key = $_GET["key"];
  $email = $_GET["email"];
  $curDate = date("Y-m-d H:i:s");
  $error ="";
  $query = mysqli_query($con,
  "SELECT * FROM `password_reset_temp` WHERE `key`='".$key."' and `email`='".$email."';"
  );
  $row = mysqli_num_rows($query);
  if ($row==""){
  $error .= ' <html>
<head>
<title></title>
<link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #7f8c8d">
<br><br><br><br>
  <div id="main-wrapper">
  <h2>Invalid Link</h2>
<p>The link is invalid/expired. Either you did not copy the correct link
from the email, or you have already used the key in which case it is 
deactivated.</p>
<p><a href="http://localhost/coding/register-system1/email.php">
</a> Try again!.</p> 
 <a href="email.php"><input type="submit" id="signup_btn" value="Reset Password"/>
 <a href="index.php"><input type="button" name="loginSubmit"  id="back_btn" value="Back"/></a><br/>
</div>
</body>
</html>';

 }else{
  
  $row = mysqli_fetch_assoc($query);
  $expDate = $row['expDate'];
  if ($expDate >= $curDate){
  ?>
  <br />
  <!DOCTYPE html>
<html>
<head>
<title>Registration Page</title>
<link rel="stylesheet" href="style.css">
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/parsley.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/themes/bootstrap.rtl.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.1/parsley.js"></script>
    </style>
<style type="text/css" >
  .errorMsg{border:1px solid green; }
  .message{color: red; font-weight:bold; }
 </style>
</head>
<body style="background-color: #7f8c8d">
  <br><br><br><br>
  <div id="validate_form4">
  <div id="main-wrapper" >
    <span align="center"  style="margin-top:0px;" ><?php if (isset($errorMsg)) { echo "<p class='message'>" .$errorMsg. "</p>" ;} ?></span>
  
<form id="validate_form1" action="" name="update"  method="post"  data-parsley-validate >
  <input type="hidden" name="action" value="update" />
      <!-- Modal body -->
      
        <div class="form-group">
           <label><strong>Enter New Password:</strong></label><br />
  <input type="password" name="pass1" class="inputvalues" id="form_password"  required data-parsley-minlength="8" data-parsley-trigger="keyup" />
  <span class="error_form" id="password_error_message"></span>
        </div>
         <div class="form-group">
          <label><strong>Re-Enter New Password:</strong></label><br />
  <input type="password" name="pass2" class="inputvalues" id="form_retype_password"   required data-parsley-equalto="#form_password" data-parsley-trigger="keyup"/>
  <span class="error_form" id="retype_password_error_message"></span> 

        </div>

      <!-- Modal footer -->
       <input type="hidden" name="email" value="<?php echo $email;?>"/>
     <button type="submit" id="login_btn" name="submit" value="Submit" class="btn btn-primary"  onsubmit ="addRecord()">Submit</button>
  <a href="login.php?reg=true"><input type="button" name="loginSubmit"  id="back_btn" value="Back"/></a><br/>
  <span<?php if(isset($code) && $code == 2){echo "class=errorMsg" ;}?> ></span>
  </form>
         </div>
</div>
    </div>
       </body>
  </html>
<?php
}else{
$error .= ' <html>
<head>
<title></title>
<link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #7f8c8d">
  <div id="main-wrapper">
<h2>Link Expired</h2>
<p>The link is expired. You are trying to use the expired link which 
as valid only 5 minutes (5 minutes after request).<br /><br /></p>
</div>
</body>
</html>';
            }
      }
if($error!=""){
  echo "<div class='error'>".$error."</div><br />";
  } 
 // isset email key validate end
 }
    
if(isset($_POST["email"]) && isset($_POST["action"]) &&
 ($_POST["action"]=="update")){
$error="";
$pass1 = mysqli_real_escape_string($con,$_POST["pass1"]);
$pass2 = mysqli_real_escape_string($con,$_POST["pass2"]);
$email = $_POST["email"];
$curDate = date("Y-m-d H:i:s");
if ($pass1=$pass2){
 
  $query="select * from userinfo where password = '".md5($pass1)."'";
           $query_run=mysqli_query($con, $query);
           if(mysqli_num_rows($query_run) > 0)
$error.= "<p> Old  Password and New Password should not be same.<br /><br /></p>";
  }
  if($error!=""){
echo 
'<div class="error">'.$error.'</div>
   <a href="javascript:history.go(-1)"><input type="button" name="loginSubmit"  id="back_btn" value="Back"/></a></a><br>
</div>'; 
}else{
$pass1 = md5($pass1);


mysqli_query($con,
"UPDATE `userinfo` SET `password`='".$pass1."', `trn_date`='".$curDate."' 
WHERE `email`='".$email."';"
);

mysqli_query($con,"DELETE FROM `password_reset_temp` WHERE `email`='".$email."';");
 
echo '<html>
<head>
<title></title>
<link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #7f8c8d">
  <div id="main-wrapper">
<div class="error"><p>Congratulations! Your password has been updated successfully.</p>
<p><a href="http://localhost/coding/register-system1/login.php?reg=true">
</a> Now you can Login.</p></div><br /> <a href="index.php"><input type="button" name="loginSubmit"  id="back_btn" value="Login"/></a><br/>
</div>
</body>
</html>';
   }

}


?>
<!-- <script> 
$errorMsg="Error :Invalid Creadentials";
               $code= "2";  
$(document).ready(function(){  
    $('#validate_form4').parsley();
 
 $('#validate_form4').on('submit', function(event){
  event.preventDefault();
  if($('#validate_form4').parsley().isValid())
  {
   $.ajax({
    url:"",
    method:"",
    data:$(this).serialize(),
    beforeSend:function(){
     $('#save').attr('disabled','disabled');
     $('#save').val('Submitting...');
    },
    success:function(data)
    {
     $('#validate_form4')[0].reset();
     $('#validate_form4').parsley().reset();
     $('#save').attr('disabled',false);
     $('#save').val('Submit');
     alert("college added successfully");
    }
   });
  }
 });
});  */
</script>
<script type="text/javascript">
    $(function() {
        
        $("#password_error_message").hide();
        $("#retype_password_error_message").hide();
        
        var error_password = false;
        var error_retype_password = false;
       
        });
        $("#form_password").focusout(function() {
            check_password();
        });
        $("#form_retype_password").focusout(function() {
            check_retype_password();
        });
       
        function check_password() {
            var password_length = $("#form_password").val().length;
            if (password_length < 8) {
                $("#password_error_message").html('<span style="color:purple" > Atleast 8 Characters </span>');
                $("#password_error_message").show();
                $("#form_password").css("border","2px solid #F90A0A");
                error_password = true;
            } else {
                $("#password_error_message").hide();
                $("#form_password").css("border","2px solid #34F458");
            }
        }
        function check_retype_password() {
            var password = $("#form_password").val();
            var retype_password = $("#form_retype_password").val();
            if (password !== retype_password) {
                $("#retype_password_error_message").html(' <span style="color:purple" >Passwords Did not Matched </span>');
                $("#retype_password_error_message").show();
                $("#form_retype_password").css("border","2px solid #F90A0A");
                error_retype_password = true;
            } else {
                $("#retype_password_error_message").hide();
                $("#form_retype_password").css("border","2px solid #34F458");
            }
        } 
       
        $("#registration_form").submit(function() {
           
            error_password = false;
            error_retype_password = false;
           
            check_password();
            check_retype_password();
            if (error_fname === false && error_sname === false && error_email === false && error_password === false && error_retype_password === false) {
                alert("Registration Successfull");
                return true;
            } else {
                alert("Please Fill the form Correctly");
                return false;
            }
        });
    
</script> -->
  

 