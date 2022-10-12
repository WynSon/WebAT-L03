<?php
session_start();
require "../header.php";
require "../controller.php";
require "../validate.php";
$validate = new Validator();
$validate->is_manager();

if(isset($_GET['staff']) && isset($_GET['cid'])){
    $staff_id = get_profile($_GET['staff'])['id'];
    ass_support($staff_id, $_GET['cid']); ?>
    <script>alert('Assigned supporter for this customer sucessfully!');
    window.location='./customers.php'; </script>
<?php
}else{
    http_response_code(404);
            die('404 Not Found');
}

$conn =null;   
?>