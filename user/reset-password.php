<?php
include("../header.php");
require "../controller.php";
require_once "../validate.php";
$validate =new Validator();
$error="";
if(isset($_POST["email"])){
    $errors = $validate->password_reset();
    if(!$errors){
        if(reset_pass($data['email'], password_hash($data['newpassword'], PASSWORD_DEFAULT))){ ?>

<script>alert('Reset Password Successfully, Go to Login!');
window.location='../login.php';
</script>
<?php
        };
                
    }
}
if (isset($_GET["key"]) && isset($_GET["email"])){
  $key = $_GET["key"];
  $email = $_GET["email"];
  $curDate = date("Y-m-d H:i:s");
  $result = is_reset($key, $email);
  if ($result==""){
  $error .= '<h2>Invalid Link</h2>
<p>The link is invalid/expired. Either you did not copy the correct link
from the email, or you have already used the key in which case it is 
deactivated.</p>
<p><a href="https://www.allphptricks.com/forgot-password/index.php">
Click here</a> to reset password.</p>';
	}else{
  $expDate = $result['expire'];
  if ($expDate >= $curDate){
  ?>
  <head>
<link rel="stylesheet" href="../css/login.css">
</head>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <form  class="box" method="POST" action="./reset-password.php">
                    <h1>Reset Password  </h1>
                    <input type="password" name="newpassword" placeholder="New Password" value="<?php echo !empty($data['newpassword']) ? $data['newpassword'] : ''; ?>" required >
                    <p class="text-muted"><?php if (!empty($errors['newpassword'])) echo $errors['newpassword']; ?></p> 

                    <input type="password" name="repassword" placeholder=" Re New Password" value="<?php echo !empty($data['repassword']) ? $data['repassword'] : ''; ?>" required>
                    <p class="text-muted"><?php if (!empty($errors['repassword'])) echo $errors['repassword']; ?></p> 

                    <input type="hidden" name="email" value="<?php echo $email;?>"/>
                    <input type="hidden" name="csrftoken" value="<?php echo $token; ?>">
  <br>
                    <input type="submit" value="Reset Password" />
                </form>
            </div>
        </div>
    </div>
</div>

<?php
}else{
$error .= "<h2>Link Expired</h2>
<p>The link is expired. You are trying to use the expired link which 
as valid only 24 hours (1 days after request).<br /><br /></p>";
            }
      }
if($error!=""){
  echo "<div class='error'>".$error."</div><br />";
  }			
} // isset email key validate end




?>