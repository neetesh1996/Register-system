<?php
include('db.php');
if(isset($_POST["email"]) && (!empty($_POST["email"]))){
$email = $_POST["email"];
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$email = filter_var($email, FILTER_VALIDATE_EMAIL);
$error ="";
$result="";
if (!$email) {
   $error .="<p>Invalid email address please type a valid email address!</p>";
   }else{
   $sel_query = "SELECT * FROM `userinfo` WHERE email='".$email."'";
   $results = mysqli_query($con,$sel_query);
   $row = mysqli_num_rows($results);
   if ($row==""){
   $error .= "<p>No user is registered with this email address!</p>";
   }
  }
   if($error!=""){
   echo '
   <html>
<head>
<title></title>
<link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #7f8c8d">
<br>
  <div id="main-wrapper">
<div class="error">'.$error.'</div>
   <a href="javascript:history.go(-1)"><input type="button" name="loginSubmit"  id="back_btn" value="Back"/></a></a><br>
</div>
</body>
</html>';
   
   }else{
   $expFormat = mktime(
   date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
   );
   $expDate = date("Y-m-d H:i:s",$expFormat);

   $key = md5(2418*2);
   $addKey = substr(md5(uniqid(rand(),1)),3,10);
   $key = $key . $addKey;

   $result = mysqli_query($con, "SELECT fullname FROM `userinfo` WHERE email='".$email."'") or die(mysqli_error());
   $row= mysqli_fetch_row($result);
  $str = implode(",",$row);
// Insert Temp Table
mysqli_query($con,
"INSERT INTO `password_reset_temp` (`email`, `key`, `expDate`)
VALUES ('".$email."', '".$key."', '".$expDate."');");

 $output='<p>Dear '.$str.',</p>';
$output.='<p>Please click on the following link to reset your password.</p>';
$output.='<p><br></p>';
$output.='<p><a href="http://localhost/coding/register-system1/reset-password.php?key='.$key.'&email='.$email.'&action=reset" target="_blank">
http://localhost/coding/register-system1/reset-password.php
?key='.$key.'&email='.$email.'&action=reset</a></p>'; 
$output.='<p><br></p>';
$output.='<p>Please be sure to copy the entire link into your browser.
The link will expire after 5 minutes  for security reason.</p>';
$output.='<p>If you did not request this forgotten password email, no action 
is needed, your password will not be reset. However, you may want to log into 
your account and change your security password as someone may have guessed it.</p>';   
$output.='<p>Thanks,</p>';
$output.='<p>Team</p>';
$body = $output; 
$subject = "Password Recovery ";
 
$email_to = $email;
$fromserver = "kumarneetesh96@gmail.com"; 
require("PHPMailer/PHPMailerAutoload.php");
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Host = "smtp.gmail.com"; // Enter your host here
$mail->SMTPAuth = true;
$mail->Username = "kumarneetesh96@gmail.com"; // Enter your email here
$mail->Password = "Neetesh@18"; //Enter your password here
$mail->Port = 587;
$mail->IsHTML(true);
$mail->From = "kumarneetesh96@gmail.com";
$mail->FromName = "Team";
$mail->Sender = $fromserver; // indicates ReturnPath header
$mail->Subject = $subject;
$mail->Body = $body;
$mail->AddAddress($email_to);
if(!$mail->Send()){
echo "Mailer Error: " . $mail->ErrorInfo;
}else{
echo  '<html>
<head>
<title></title>
<link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #7f8c8d">
  <div id="main-wrapper">
<div class="error">
<h3>An email has been sent to you with instructions on how to reset your password.</h3>
</div><br /><br />
<a href="email.php"><input type="button" name="loginSubmit"  id="back_btn" value="Back"/></a><br/>
</div>
</body>
</html>';
 }
   }
}else{
?>
<!DOCTYPE html>
<html>
<head>
<title></title>
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
</head>
<body style="background-color: #7f8c8d">
  <br><br><br><br>
<div id="main-wrapper">
<form method="post" action="" name="reset" data-parsley-validate>
<div class="form-group">
<label><strong>Enter Your Email Address:</strong></label><br>
<input type="email" name="email" placeholder="username@email.com" class="inputvalues" required data-parsley-type="email" data-parsley-trigger="keyup" />

</div>
 <div class="form-group">

<button type="submit" id="signup_btn" />CONTINUE</button> 
</div>
 <a href="index.php"><input type="button" name="loginSubmit"  id="back_btn" value="Back"/></a><br/>
</form>
</div>
</body>
  </html>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php } ?>