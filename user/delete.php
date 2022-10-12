<?php
session_start();
require "../header.php";
require "../controller.php";
require "../validate.php";
$validate = new Validator();

 
if(isset($_GET['username']) && !isset($_GET['messid'])){
    $username = isset($_GET['username']) ? htmlspecialchars($_GET['username'])  : '';
    if ($username){
    $validate->is_login();
    $user_role = get_profile($username);
        if($_SESSION['role'] == 2 && $user_role['role'] == 3){
            register($username, $user_role['password'], $user_role['fullname'], $user_role['email'], $user_role['phone'], $user_role['address'], 1, 'delete');
            header("location: ./customers.php");
        }else{
            if($user_role !== 3){ ?>
                <script>alert("You can only delete Customer!")</script>
            <?php }else{ 
                http_response_code(403);
                die('Forbidden');
            }
        }

        
    }
 
}
    

if(isset($_GET['messid']) && isset($_GET['username'])){
    $messid = isset($_GET['messid']) ? $_GET['messid'] : '';
    $username = isset($_GET['username']) ? $_GET['username'] : '';
    if (check_message($messid, $_SESSION['username'], $username)){
        $username = isset($_GET['username']) ? $_GET['username'] : '';
    // $validate->is_permission($username);
        delete_message($messid);
        header("location: ../chat.php?username=$username");
    }else{
        echo "<center><br><h1>Message isn't avaliable</center></h1>";
            exit;

    }
 
}

$conn =null;   
?>