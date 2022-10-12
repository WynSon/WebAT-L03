<?php
session_start();
include("header.php");
require_once "controller.php";
require_once "validate.php";

if(isset($_POST['username']) && isset($_POST['password'])){
    $validate =new Validator();

    $errors = $validate->login_form();

    if(!$errors){
        $result = login($data['username']);
        if($result){
            if(password_verify($data['password'], $result['password'])){
                var_dump($result['is_active'] === 1);
                if($result['is_active'] == 1){
                $_SESSION['username'] = $result['username'];
                $_SESSION['role'] = $result['role'];
                $_SESSION['uid'] = $result['id'];
                $_SESSION['supporter_id'] = $result['supporter_id'];
                header("location: home.php");
                }else{
                    $errors['invalid'] = "Yor account isn't active, please contact the employee to help!";
                }
            }else{
                $errors['invalid'] = "Invalid username or password!";
        }
        }else{
            $errors['invalid'] = "Invalid username or password!";
        }
    
}
}
?>
<head>
<link rel="stylesheet" href="./css/login.css">
</head>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <form  class="box" method="POST">
                    <h1>Login</h1>
                    <p style="color:red"><?php if(!empty($errors['invalid'])) echo $errors['invalid']; else echo "Please enter your login and password!";?></p> 
                    <input type="text" name="username" placeholder="Username" value="<?php echo !empty($data['username']) ? $data['username'] : ''; ?>" required> 
                    <p class="text-muted"><?php if (!empty($errors['username'])) echo $errors['username']; ?></p>
                    <input type="password" name="password" placeholder="Password" value="<?php echo !empty($data['password']) ? $data['password'] : ''; ?>" required>
                    <p class="text-muted"><?php if (!empty($errors['password'])) echo $errors['password']; ?></p> 
                            <input id="chk1" type="checkbox" name="chk"> 
                            <label for="chk1" class="text-muted" >Remember me</label><br> 
                    <a class="forgot text-muted" href="./user/sendmail.php">Forgot password? </a><p style="color: grey;">or</p><a class="forgot text-muted" href="register.php"> Register</a>  
                    <input type="submit" name="" value="Login">
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
include("footer.php");
?>