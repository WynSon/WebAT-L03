<?php
session_start();
require "../header.php";
require "../controller.php";
require "../validate.php";
$validate = new Validator();

 
// Delete Student identified by account
if(isset($_GET['username']) && !isset($_GET['messid'])){
    $username = isset($_GET['username']) ? htmlspecialchars($_GET['username'])  : '';
    if ($username){
    $validate->is_login();
    $user_role = get_profile($username);
        if($_SESSION['role'] == 0 && $user_role['role'] != 3 && $user_role['role'] != 0){
            delete_user($username);
            header("location: ./list.php");
        }else{
            if($user_role['role'] == 3 || $user_role['role'] != 0){ ?>
                <script>
                alert("You only can delete Staff and Manager!");
                window.location='./list.php';
                </script>
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