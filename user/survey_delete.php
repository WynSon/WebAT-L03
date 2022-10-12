<?php
session_start();
require "../header.php";
require "../controller.php";
require "../validate.php";
$validate = new Validator();

 
// Delete Student identified by account
if(isset($_GET['id'])){
    $id = $_GET['id'];
    if ($id){
    $validate->is_customer();
    $survey = get_survey($id);
        if($_SESSION['role'] == 3 && $survey['user_id'] ==  $_SESSION['uid']){
            survey_delete($id);
            header("location: ./survey_list.php");
        }else{ 
                http_response_code(403);
                die('Forbidden');
            }
        }

        
    }

$conn =null;   
?>