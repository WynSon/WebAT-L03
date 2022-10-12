<?php 
session_start();
include("../header.php");
require "../controller.php";
require "../validate.php";
$validate = new Validator();
//Only teacher can add student
if($_SESSION['role'] < 2){
    http_response_code(403);
            die('<center><br><h1>Forbidden</center></h1>');
}
$id = isset($_GET['id']) ? htmlspecialchars($_GET['id'])  : '';
$data = get_survey($id);
if($_SERVER['REQUEST_METHOD'] =='GET'){
if ($data){
    $surveys = get_surveys_answer($_SESSION['username']);
    $check = 0;
    $ans = 0;
    if($data && $surveys){
        foreach($surveys as $survey){
            if($data['id'] === $survey['id'] || $data['user_id'] == $_SESSION['uid']) $check = 1;
            if($data['id'] === $survey['id']) $ans = 1;
        }
        if(!$check){
            http_response_code(403);
            die('<center><br><h1>Forbidden</center></h1>');
        }
    }
    
}else{
    http_response_code(404);
    die('<center><br><h1>404 Not Found</center></h1>');
}
}

if (!empty($_POST['submit'])){
    $errors = $validate->answer_submit();
    if (!$errors){
        add_answer($data['sid'], $data['answer'], $data['user']); ?>
    <script>alert('Bạn đã hoàn thành khảo sát, xin cảm ơn !');
    window.location='./survey_answer.php'; </script>
    <?php 
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content=
        "width=device-width, initial-scale=1.0">
    <title>
        Customer Survey Online
    </title>
 
    <style>
 
        /* Styling the Body element i.e. Color,
        Font, Alignment */
        body {
            background-color: blue;
            font-family: Verdana;
            text-align: center;
        }
 
        /* Styling the Form (Color, Padding, Shadow) */
        form {
            background-color: #fff;
            max-width: 500px;
            margin: 50px auto;
            padding: 30px 20px;
            box-shadow: 2px 5px 10px rgba(0, 0, 0, 0.5);
        }
 
        /* Styling form-control Class */
        .form-control {
            text-align: left;
            margin-bottom: 25px;
        }
 
        /* Styling form-control Label */
        .form-control label {
            display: block;
            margin-bottom: 10px;
        }
 
        /* Styling form-control input,
        select, textarea */
        .form-control input,
        .form-control select,
        .form-control textarea {
            border: 1px solid #777;
            border-radius: 2px;
            font-family: inherit;
            padding: 10px;
            display: block;
            width: 95%;
        }
 
        /* Styling form-control Radio
        button and Checkbox */
        .form-control input[type="radio"],
        .form-control input[type="checkbox"] {
            display: inline-block;
            width: auto;
        }
 
        /* Styling Button */
        button {
            background-color: #05c46b;
            border: 1px solid #777;
            border-radius: 2px;
            font-family: inherit;
            font-size: 21px;
            display: block;
            width: 100%;
            margin-top: 50px;
            margin-bottom: 20px;
        }
    </style>
</head>
  
<body>
    <br>
    <h1><?php if(isset($data)) echo $data['title'] ?></h1>
    <?php if($_SESSION['role'] == 3){ ?>
    <!-- Create Form -->
    <form id="form" action="./survey.php" method="POST">
        <!-- Details -->
        <div class="form-control">
            <label for="comment">
                <?php if(isset($data)) echo $data['question']; ?>
            </label>
 
            <!-- multi-line text input control -->
            <textarea name="answer"
                placeholder="Enter your answer here" readonly></textarea>
        </div>
        <!-- Multi-line Text Input Control -->
        <?php if($_SESSION['uid'] == $data['user_id'] && !$ans){ ?>
        <button type="button" onclick="window.location = '../user/answer.php'" class="btn  btn-outline-dark">See Answer</button>
        <?php }else{ ?>
        <input name="sid" type="hidden" value="<?php echo $data['id']; ?>" >
        <input name="user" type="hidden" value="<?php echo $_SESSION['username'] ?>" >
        <button type="submit" name="submit" value="submit">
            Submit
        </button>
        <?php }?>
    </form> <?php }else{ ?>
        <h1><?php if(isset($data)) echo $data['title'] ?></h1>
    <!-- Create Form -->
        <!-- Details -->
        <div class="form-control">
            <label for="comment">
                <?php if(isset($data)) echo $data['question']; ?>
            </label>
        </div>
        <div class="form-control">
            <label for="comment">
                <?php if(isset($data)) echo $data['participants']; ?>
            </label>
        </div>
 <?php }?>
</body>
  
</html>
<?php include('../footer.php'); ?>