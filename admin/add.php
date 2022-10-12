<?php
session_start();
include("../header.php");
require "../controller.php";
require "../validate.php";
$validate = new Validator();
//Only admin can add staff and manager
$validate->is_admin();
if (!empty($_POST['add'])){
    //validate form add student
    $errors = $validate->add_form();
    
    // If don't have error -> insert  new user
    if (!$errors){
        admin_add_user($data['username'], password_hash($data['password'], PASSWORD_DEFAULT), $data['fullname'], $data['phone'], $data['email'], $data['address'], $data['role']);
        header("location: ./list.php");
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
                <form  method="POST" class="box">
                    <h1>Add User</h1>
                    <p class="text-muted"> Please enter user's information!</p> 
                    <input type="text" name="fullname" placeholder="Full Name" value="<?php echo !empty($data['fullname']) ? $data['fullname'] : ''; ?>" required> 
                    <p class="text-muted"><?php if (!empty($errors['fullname'])) echo $errors['fullname']; ?></p>  

                    <input type="text" name="username" placeholder="Username" value="<?php echo !empty($data['username']) ? $data['username'] : ''; ?>" required>
                    <p class="text-muted"><?php if (!empty($errors['username'])) echo $errors['username']; ?></p> 

                    <input type="password" name="password" placeholder="Password" value="<?php echo !empty($data['password']) ? $data['password'] : ''; ?>" required>
                    <p class="text-muted"><?php if (!empty($errors['password'])) echo $errors['password']; ?></p> 

                    <input type="text" name="email" placeholder="Email" value="<?php echo !empty($data['email']) ? $data['email'] : ''; ?>" required>
                    <p class="text-muted"><?php if (!empty($errors['email'])) echo $errors['email']; ?></p> 

                    <input type="text" name="phone" placeholder="Phone Number" value="<?php echo !empty($data['phone']) ? $data['phone'] : ''; ?>">  
                    <p class="text-muted"><?php if (!empty($errors['phone'])) echo $errors['phone']; ?></p>   

                    <input type="text" name="address" placeholder="Address" value="<?php echo !empty($data['address']) ? $data['address'] : ''; ?>">  
                    <p class="text-muted"><?php if (!empty($errors['address'])) echo $errors['address']; ?></p>    
                    <div class="custom-control custom-radio custom-control-inline text-muted">
                        <input type="radio" id="customRadioInline1" name="role" class="custom-control-input" value="2">
                        <label class="custom-control-label" for="customRadioInline1">Sale Staff </label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline text-muted">
                        <input type="radio" id="customRadioInline2" name="role" class="custom-control-input" value="1">
                        <label class="custom-control-label" for="customRadioInline2">Sale Manager</label>
                    </div>

                    <p class="text-muted"><?php if (!empty($errors['role'])) echo $errors['role']; ?></p>  
                    
                    
                    <input type="submit" name="add" value="OK" >
                    <button style="padding: 14px 40px;border-radius: 24px;transition: 0.25s;border: 2px solid #2ecc71;" 
                    class="btn btn-outline-success" onclick="window.location = '../list.php'" type="button"  >Cancel</button>
                    
                </form>
            </div>
        </div>
    </div>
</div>
<?php

include("../footer.php");
?>