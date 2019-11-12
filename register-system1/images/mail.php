<?php

session_start();
$con=mysqli_connect("localhost","root","");
mysqli_select_db($con,'samplelogin');
$mail1=$_REQUEST['email'];
$query="SELECT * FROM userinfo WHERE email='$mail1'";
$result = mysqli_query($con,$query);
$row=mysqli_fetch_assoc($result);
$url= "http://localhost/coding/New%20folder/index.php ?
key='.$key.'&email='.$email.'&action=reset" target="_blank";
echo $row['email'];
    require 'phpmailer/PHPMailerAutoload.php';
    $mail = new PHPMailer();
    $mail->SMTPDebug = 1;
    $mail->isSMTP();
    $mail->Host='smtp.gmail.com';
    $mail->SMTPAuth=true;
    $mail->Username='neetesh.wri240@webreinvent.com';
    $mail->Password='ultraL!ne56';
    $mail->SMTPSecure='tls';
    $mail->Port=587;
    $mail->setFrom('neetesh.wri240@webreinvent.com','neetesh');
    $mail->addAddress($row['email']);
    $mail->isHTML(true);
    $mail->Subject='Forget password';
    $mail->Body= "<h1>Hi ".$row['username'  ].$url."</h1>";

    if($mail->send()){
       header('Location: emailConfirm.php');

    }
    else{
        echo "Something went wrong try again ";

    }



?>