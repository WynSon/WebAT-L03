<?php
session_start();
include("../header.php");
require_once "../controller.php";
require_once "../validate.php";
$validate =new Validator();
function csrfguard_generate_token()
{
	$token = random_bytes(64); // PHP 7, or via paragonie/random_compat
	$_SESSION['csrftoken']= $token;
	return $token;
}
//Check role, allow teacher or owner account change pass
if(isset($_GET['username'])){
    $token = csrfguard_generate_token();
    $username = htmlspecialchars($_GET['username']);
    $validate->is_permission($username);
    $check = get_profile($username);
    if($check){
        if(($_SESSION['username']!=$check['username'])){
            echo "<center><br><h1>Access Denied</center></h1>";
                exit;
        }
    }else{
        echo "<center><br><h1>User doesn't exists</center></h1>";
                exit;
    }
    
}

if(isset($_POST['username'])){
    // validate form password
    $errors = $validate->password_form();
    $validate->is_permission($data['username']);
    $formtoken = $_POST['csrftoken'];
    $validate->check_csrf($formtoken, $_SESSION['csrftoken']);
    // if no error after validate, change pass
    if(!$errors){
        changepass($data['username'], password_hash($data['newpassword'], PASSWORD_DEFAULT) );
        if($result==null){
            if($_SESSION['username'] !==$username){
                header("location: ./profile.php?username=$username");
            }else{
                session_destroy();
                header("location: ../login.php");
            }
                
    }else{
        $errors['invalid'] = "Thay đổi mật khẩu thất bại";
    }
    
}
}
?>
<head>
<link rel="stylesheet" href="../css/login.css">
</head>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <form  class="box" method="POST">
                    <input type="hidden" name="username" value="<?php echo $username?>" >
                    <h1>Change Password  </h1>
                    <h3 class="text-muted" >for <?php echo $username ?></h3>
                    <!-- if not teacher or teacher's account, require old password -->
                    <?php if(!$_SESSION['role'] || $_SESSION['username']==$username){ ?>
                    <input type="password" name="oldpassword" placeholder="Mật Khẩu cũ" value="<?php echo !empty($data['oldpassword']) ? $data['oldpassword'] : ''; ?>" required> 
                    <p class="text-muted"><?php if (!empty($errors['oldpassword'])) echo $errors['oldpassword']; ?></p>
                    <?php } ?>
                    <input type="password" name="newpassword" placeholder="New Password" value="<?php echo !empty($data['newpassword']) ? $data['newpassword'] : ''; ?>" required >
                    <p class="text-muted"><?php if (!empty($errors['newpassword'])) echo $errors['newpassword']; ?></p> 

                    <input type="password" name="repassword" placeholder=" Re New Password" value="<?php echo !empty($data['repassword']) ? $data['repassword'] : ''; ?>" required>
                    <p class="text-muted"><?php if (!empty($errors['repassword'])) echo $errors['repassword']; ?></p> 
                    <input type="hidden" name="csrftoken" value="<?php echo $token; ?>"    >
                    <input type="submit" value="Submit">
                    <div class="col-md-12">
                        <ul class="social-network social-circle">
                            <li><a href="#" class="icoFacebook" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#" class="icoTwitter" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#" class="icoGoogle" title="Google +"><i class="fab fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

include("../footer.php");
?>