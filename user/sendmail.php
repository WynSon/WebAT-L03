<?php
session_start();
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require '..\PHPMailer\src\Exception.php';
require '..\PHPMailer\src\PHPMailer.php';
require '..\PHPMailer\src\SMTP.php';

include("../header.php");
require "../controller.php";
require_once "../validate.php";

if(isset($_POST["email"]) && (!empty($_POST["email"]))){
$email = $_POST["email"];
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$email = filter_var($email, FILTER_VALIDATE_EMAIL);
$error = "";
if (!$email) {
   $error .="<p>Invalid email address please type a valid email address!</p>";
   }else{
   $results = get_email($email);
   if (!$results){
   $error .= "<p>No user is registered with this email address!</p>";
   }
  }
   if($error!=""){
   echo "<div class='error'>".$error."</div>
   <br /><a href='javascript:history.go(-1)'>Go Back</a>";
   }else{
   $expFormat = mktime(
   date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
   );
   $expDate = date("Y-m-d H:i:s",$expFormat);
   $key = md5(strval(2418*2).$email);
   $addKey = substr(md5(uniqid(rand(),1)),3,10);
   $key = $key . $addKey;
// Insert Temp Table
add_key($email, $key, $expDate);

$output='<p>Dear user,</p>';
$output.='<p>Please click on the following link to reset your password.</p>';
$output.='<p>-------------------------------------------------------------</p>';
$output.='<p><a href="http://localhost/PHP-Security/user/reset-password.php?key='.$key.'&email='.$email.'&action=reset" target="_blank">
http://localhost/PHP-Security/user/reset-password.php?key='.$key.'&email='.$email.'&action=reset</a></p>';		
$output.='<p>-------------------------------------------------------------</p>';
$output.='<p>Please be sure to copy the entire link into your browser.
The link will expire after 1 day for security reason.</p>';
$output.='<p>If you did not request this forgotten password email, no action 
is needed, your password will not be reset. However, you may want to log into 
your account and change your security password as someone may have guessed it.</p>';   	
$output.='<p>------------------------------------------<br>
Thanks you and Warmest Regards,</p>';
$output.='<p><strong>Quyền Hồng Sơn ( SonQH2 )<br>
Cyber Security Assurance Service - SAS</strong><br>
Address:  Fville 1 building  - Hoa Lac High-Tech Park, Hanoi, Vietnam<br>
Mobile: (+84) 377881277</p>';
$body = $output; 
$subject = "Password Recovery - White Hat Hacker";
$email_to = $email;
$mail = new PHPMailer(true);
try {
    //Server settings                 //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'ssl://smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'son.pentest2k@gmail.com';                     //SMTP username
    $mail->Password   = 'xnhdvlmkhkgpskvq';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('trickerhack02@mail.com', 'White Hat Hacker');
    $mail->addAddress($email_to, 'Hacker');     //Add a recipient

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->AltBody = 'Error';

    $re = $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
if(!$re){
echo "Mailer Error: " . $mail->ErrorInfo;
}else{ ?>
<script>
alert('An email has been sent to you with instructions on how to reset your password!');
window.location= '../login.php';
</script>
<?php
	}
   }
}else{
?>
<head>
<link rel="stylesheet" href="../css/login.css">
</head>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <form  class="box" method="POST">
                    <h1>Enter your email</h1>
                    <p class="text-muted"><?php if(!empty($errors['invalid'])) echo $errors['invalid']; else echo "Please enter your email associated with your account";?></p> 
                    <input type="text" name="email" placeholder="Email" value="<?php echo !empty($data['mail']) ? $data['email'] : ''; ?>" > 
                    <input type="submit" name="" value="Reset password">
                </form>
            </div>
        </div>
    </div>
</div>

<?php } ?>