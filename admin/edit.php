<?php
session_start();
include("../header.php");
require "../controller.php";
require_once "../validate.php";

$validate = new Validator();
$validate->is_admin();
$username = isset($_GET['username']) ? htmlspecialchars($_GET['username'])  : '';
if ($username){
    $data = get_profile($username);
}

if (!empty($_POST['save'])){
    $errors = $validate->admin_edit();
    var_dump($errors);
    // If don't have erro -> insert  new student
    if (!$errors){
            admin_edit($data['id'], $data['fullname'], $data['email'], $data['phone'], $data['address'], $data['role'], $data['is_active']);
// Show detail infor   
        $page= $data['username'];
        header("location: ../user/profile.php?username=$page");
    }
}
?>

<div class="container emp-profile">
            <form method="POST">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                            <img src="https://cf.shopee.vn/file/1796da3035abc7745b039a388257b4a6_tn" alt=""/>
                            <div class="file btn btn-lg btn-primary">
                                Change Photo
                                <input type="file" name="file"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h2>
                                    <?php echo $data['fullname']; ?>
                                    </h2>
                                    <h5>
                                    <?php if($data['role']) echo "Sale Staff"; else echo "Student";  ?>
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
                    <div class="col-md-2">
                        <input type="hidden" name="username" value="<?php echo $data['username']; ?>"/>
                        <a href="./delete.php?username=<?php echo $data['username']; ?>"><input class="profile-edit-btn" onclick="return confirm('Bạn có chắc muốn xóa không?');" type="button"  value="Delete"/></a>
                        <br><br>
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
                                                <label>User Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $data['username']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name ="fullname" value="<?php echo $data['fullname']; ?>">
                                                <p class="text-muted"><?php if (!empty($errors['fullname'])) echo $errors['fullname']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name ="email" value="<?php echo $data['email']; ?>">
                                                <p class="text-muted"><?php if (!empty($errors['email'])) echo $errors['email']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Phone</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name ="phone" value="<?php echo $data['phone']; ?>">
                                                <p class="text-muted"><?php if (!empty($errors['phone'])) echo $errors['phone']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Address</label>
                                            </div>
                                            <div class="col-md-6">
                                            <input type="text" class="form-control" name ="address" value="<?php echo $data['address']; ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                            <label>Role</label>
                                            </div>
                                        <div class="col-md-6">
                                            <div class="custom-control custom-radio custom-control-inline text-muted">
                                                <input type="radio" id="customRadioInline1" name="role" class="custom-control-input" value="2" <?php if($data['role'] == 2) echo'checked="checked"'?>>
                                                <label class="custom-control-label" for="customRadioInline1">Customer</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline text-muted">
                                                <input type="radio" id="customRadioInline2" name="role" class="custom-control-input" value="1" <?php if($data['role'] == 1) echo'checked="checked"'?>>
                                                <label class="custom-control-label" for="customRadioInline2">Sale Staff</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline text-muted">
                                                <input type="radio" id="customRadioInline2" name="role" class="custom-control-input" value="1" <?php if($data['role'] == 1) echo'checked="checked"'?>>
                                                <label class="custom-control-label" for="customRadioInline2">Sale Manager</label>
                                            </div>
                                        </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Is Active</label>
                                            </div>
                                            <div class="col-md-6">
                                            <select class="text-muted" name="is_active">
                                                <?php if($data['is_active']){?>
                                                    <option value="1" selected>Active</option>
                                                    <option value="2">Inactive</option>
                                                <?php }else{ ?>
                                                    <option value="1">Active</option>
                                                    <option value="2" selected>Inactive</option>
                                                <?php } ?>
                                            </select>
                                            </div>
                                        </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            </div>
                        </div>
                    </div>
                </div>
                <center>
                <div class="col-md-2">
                        <input type="hidden" name="id" value="<?php echo $data['id']; ?>"/>
                        <input type="submit" class="profile-edit-btn" name="save" value="Save" />
                </div>
                </center>
            </form> 
                      
        </div>
<?php

include("../footer.php");
?>