<?php
session_start();
include("./header.php");
require "./controller.php";
require "./validate.php";

$validate = new Validator();
$validate->is_login();

if(isset($_POST['msgid']) && isset($_POST['editmess']) && isset($_POST['username'])){

    $msgid = htmlspecialchars($_POST['msgid']) ;
    $content = htmlspecialchars($_POST['editmess']);
    $username = htmlspecialchars($_POST['username']);
    if(!check_message($msgid, $_SESSION['username'], $username)){
        echo "<center><br><h1>Access Denied</center></h1>";
            exit;
    }
    edit_message($msgid, $content);
    header("location: ./chat.php?username=$username");
}

if(isset($_GET['messid'])){
    $messid = htmlspecialchars($_GET['messid']);
}

if(isset($_POST['username']) || isset($_GET['username'])){
    $username =isset($_POST['username'])? htmlspecialchars($_POST['username']) : htmlspecialchars($_GET['username']) ;
    $currentuser = $_SESSION['username'];
    
    if(!empty($_POST['message'])){
            $message = htmlspecialchars($_POST['message']) ;
            add_message($message, $currentuser, $username);
}
$message = get_massage( $currentuser,$username);
}

?>
<head>
    <link rel="stylesheet" href="./css/message.css" >
</head>
<div  class="wrapper">
    <div class="main" >
        <div class="px-2 scroll" >
            <?php foreach($message as $msg){
                if($msg[2]==$username){?>
            <div class="d-flex align-items-center">
                <div class="text-left pr-1"><img src="https://img.icons8.com/color/40/000000/guest-female.png" width="30" class="img1" /></div>
                <div class="pr-2 pl-1"> <span class="name"><?php echo "$msg[2]  ",date("H:i",strtotime($msg[4])); ?></span>
                    <p class="msg"><?php echo $msg[1]; ?></p>
                </div>
            </div>
            <?php }else{ ?>
            <div class="d-flex align-items-center text-right justify-content-end ">
                <div class="pr-2"><span class="name"><?php echo "You  ",date("H:i",strtotime($msg[4])); ?></span>
                <div class="btn-group">
                        <button type="button" class="btn btn-secondary " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="...">
                        </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="./chat.php?messid=<?php echo $msg['0'],"&username=$username"; ?>">Edit</a>
                        <a class="dropdown-item" href="./user/delete.php?messid=<?php echo $msg['0'],"&username=$username" ?>">Delete</a>
                    </div>
                </div>
                <?php if(isset($messid) && $messid===$msg[0]){ ?>
                <form method="POST">
                    <input type="hidden" name="username" value="<?php echo $username; ?>">
                    <input type="hidden" name="msgid" value="<?php echo $msg[0]; ?>">
                    <input type="text" name="editmess" value="<?php echo $msg[1];?>" >
                    <button type="submit" >Ok</button>
                </form>
                <?php } else{ ?>
                <p class="msg"><?php echo $msg[1];?></p>
                <?php }?>
                </div>
                <div><img src="https://i.imgur.com/HpF4BFG.jpg" width="30" class="img1" /></div>
            </div>
            <?php } }?>  
        </div>
        <form method="POST" id="msg">
        <nav class="navbar bg-white navbar-expand-sm d-flex justify-content-between">
            <input type="hidden" name="username" value="<?php echo $username; ?>">
             <input type="text" name="message" class="form-control" placeholder="Type a message...">
            <div class="icondiv d-flex justify-content-end align-content-center text-center ml-2">
                 <i class="fa fa-paperclip icon1"></i> 
                 <i onclick="document.getElementById('msg').submit()" class="fa fa-arrow-circle-right icon2"></i> </div>
        </nav>
        </form>
    </div>
</div>
<?php 

include("footer.php");

?>