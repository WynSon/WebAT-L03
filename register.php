<?php
include("./header.php");
require "./controller.php";
require "./validate.php";
// Check Submit form
if (!empty($_POST['signup']))
{
    $validate = new Validator();
    $errors = $validate->register_form();
    // If don't have erro -> insert  new student
    if (!$errors){
        register($data['username'], password_hash($data['password'], PASSWORD_DEFAULT), $data['fullname'], $data['email'], $data['phone'], $data['address'], 0, 'add');
?>
        // Show detail infor
        <script> alert("Register Successfuly, Contact Satff to active your account?"); 
        window.location="login.php";</script>
<?php } 
} ?>
<head>
<link rel="stylesheet" href="./css/login.css">
</head>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <form  class="box" method="POST">
                    <h1>Register</h1>
                    <p class="text-muted"> Please enter your information!</p> 
                    <input type="text" name="fullname" placeholder="Full Name" value="<?php echo !empty($data['fullname']) ? $data['fullname'] : ''; ?>" required> 
                    <p class="text-muted"><?php if (!empty($errors['fullname'])) echo $errors['fullname']; ?></p> 
                    
                    <input type="text" name="username" placeholder="Username" value="<?php echo !empty($data['username']) ? $data['username'] : ''; ?>" required> 
                    <p class="text-muted"><?php if (!empty($errors['username'])) echo $errors['username']; ?></p> 

                    <input type="password" name="password" placeholder="Password" value="<?php echo !empty($data['password']) ? $data['password'] : ''; ?>" required>
                    <p class="text-muted"><?php if (!empty($errors['password'])) echo $errors['password']; ?></p> 

                    <input type="password" name="repassword" placeholder="Retype Password" value="<?php echo !empty($data['repassword']) ? $data['repassword'] : ''; ?>" required>
                    <p class="text-muted"><?php if (!empty($errors['repassword'])) echo $errors['repassword']; ?></p> 

                    <input type="text" name="email" placeholder="Email" value="<?php echo !empty($data['email']) ? $data['email'] : ''; ?>" required>
                    <p class="text-muted"><?php if (!empty($errors['email'])) echo $errors['email']; ?></p> 

                    <input type="text" name="phone" placeholder="Phone Number" value="<?php echo !empty($data['phone']) ? $data['phone'] : ''; ?>"> 
                    <p class="text-muted"><?php if (!empty($errors['phone'])) echo $errors['phone']; ?></p> 

                    <input type="text" name="address" placeholder="Address" value="<?php echo !empty($data['address']) ? $data['address'] : ''; ?>"> 

                    <p class="text-muted">Already have an account? <a class="forgot text-muted" href="login.php">Sign in</a> </p>
                    <input type="submit" name="signup" value="Sign Up" >
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