<?php
session_start();
include("../header.php");
require "../controller.php";
require "../validate.php";

$validate = new Validator();
$validate->is_customer();
try{ 
// Get account id of user to display detail information
$id = $_SESSION['supporter_id'];

if ($id){   
        $data = get_support($id);
}else{
    die("<center><br><h1>You don't have supporter, please contact manager to help!</center></h1>");
}
}catch(Exception $e){
    echo $e->getMessage();}


if($data){
    $conn =null;
?>
<!------ Include the above in your HEAD tag ---------->

<div class="container emp-profile">
            <form method="get">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                            <img src="https://cf.shopee.vn/file/1796da3035abc7745b039a388257b4a6_tn" alt=""/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h2>
                                    <?php echo $data['fullname']; ?>
                                    </h2>
                                    <h5>
                                    <?php if($data['role'] == 0)echo "Admin"; elseif ($data['role'] == 1)echo "Sale Manager"; elseif($data['role'] == 2) echo "Sale Staff"; elseif($data['role'] == 3)echo "Customer"; else echo "Student"; ?>
                                    </h5>
                                    <p class="proile-rating">RANKINGS : <span>8/10</span></p>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Timeline</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-work">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $data['fullname']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $data['email']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Phone</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $data['phone']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Role</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php if($data['role'] == 0)echo "Admin"; elseif ($data['role'] == 1)echo "Sale Manager"; elseif($data['role'] == 2) echo "Sale Staff"; elseif($data['role'] == 3)echo "Customer"; else echo "Student"; ?></p>
                                            </div>
                                        </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">                           
                            </div>
                        </div>
                    </div>
                </div>
            </form>
 <button class="nut-mo-chatbox" onclick="moForm()">Chat</button>
 <div class="Chatbox" id="myForm">
   <form action="../chat.php" class="form-container" method="post">
     <h1>Chatbox</h1>
    <label for="msg"><b>Lời Nhắn</b></label>
     <textarea placeholder="Bạn hãy nhập lời nhắn.." name="message" required></textarea>
     <input type="hidden" name="username" value="<?php echo $data['username'];?>">
    <button type="submit" class="btn">Gửi</button>
     <button type="button" class="btn nut-dong-chatbox" onclick="dongForm()">Đóng</button>
   </form>
 </div>           
</div>
<script>
       /*Hàm Mở Form*/
 function moForm() {
   document.getElementById("myForm").style.display = "block";
 }
 /*Hàm Đóng Form*/
 function dongForm() {
   document.getElementById("myForm").style.display = "none";
 }
   </script>
<?php
}
include("../footer.php");
?>