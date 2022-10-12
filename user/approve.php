<?php
session_start();
require "../controller.php";
require "../validate.php";
$validate = new Validator();
//Only teacher can add student
$validate->is_access();
$id = isset($_GET['id']) ? $_GET['id'] :'';
$sid = isset($_GET['sid']) ? $_GET['sid'] :'';
if($id){
    $user = get_temp($id);
    $uid = get_profile($user['username'])['id'];
    if ($_SESSION['role'] == 2){
        approve($id);
        header("location: ./in_comming.php");
    }elseif($_SESSION['role'] == 1){
        if($_GET['action'] == 'add'){
            admin_add_user($user['username'], $user['password'], $user['fullname'], $user['phone'], $user['email'], $user['address'], 3);
            reject($id); ?>
            <script>alert('Approve reuqest add customer successfully!');
            window.location='./in_comming.php'; </script> <?php
        }elseif($_GET['action'] == 'edit'){
            admin_edit($uid, $user['fullname'], $user['phone'], $user['email'], $user['address'], 3, 1);
            reject($id); ?>
            <script>alert('Approve reuqest edit customer successfully!');
            window.location='./in_comming.php'; </script> <?php
        }elseif($_GET['action'] == 'delete'){
            admin_delete($uid);
            reject($id); ?>
            <script>alert('Approve reuqest delete customer successfully!');
            window.location='./in_comming.php'; </script> <?php
        }else{
            http_response_code(404);
            die('404 Not Found');
        }
    }
}
if($sid){
    approve_survey($sid);
    header("location: ./customer_survey.php");
}

?>