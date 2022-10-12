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
    reject($id);
    header("location: in_comming.php");
}elseif($sid){
    reject_survey($sid);
    header("location: ./customer_survey.php");
}else{
    http_response_code(404);
            die('404 Not Found');
}



?>