<?php
session_start();
include("header.php");
require "./controller.php";
require "./validate.php";
$validate = new Validator();
$validate->is_login();
$user  = get_all_user();
$role = $_SESSION['role'];
?>
<br>
<center><h2>Danh Sách User Trên Hệ Thống</h2></center>
<br>
<table class="table">
  <thead class="thead-dark">
  <tr>
      <th scope="col">STT</th>
      <th scope="col">Username</th>
      <th scope="col">Full Name</th>
      <th scope="col">Email</th>
      <th scope="col">Phone Number</th>
      <th scope="col">Profession</th>
      <?php if($role){?>
      <th scope="col">Action</th>
      <?php } ?>
    </tr>
  </thead>
  <tbody>
  <?php $stt=1; foreach ($user as $item){ ?>
    <tr>
      <th scope="row"><?php echo $stt; $stt++;?></th>
      <td><?php echo $item[1]; ?></td>
      <td><a href="./user/profile.php?username=<?php echo $item[1]; ?>"><?php echo $item[3]; ?> </a></td>
      <td><?php echo $item[4]; ?></td>
      <td><?php echo $item[5]; ?></td>
      <td><?php if($item[6])echo "<h5>Teacher</h5>"; else echo "Student"; ?></td>
      <?php if($role && !$item[6]){?>
        <td>
                <div class="dropdown show">
                    <a class="btn btn-secondary dropdown-toggle"  role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                    
                    </a>
                    <div class="dropdown-menu" >
                        <a class="dropdown-item" href="./user/profile.php?username=<?php echo $item[1]; ?>">Chi tiết</a>
                        <a class="dropdown-item" href="./user/edit.php?username=<?php echo $item[1]; ?>">Sửa</a>
                        <a class="dropdown-item" onclick="return confirm('Bạn có chắc muốn xóa không?');" href="./user/delete.php?username=<?php echo $item[1]; ?>">Xóa</a>
                    </div>
                </div>               
      </td><?php } ?>
    </tr>
    <?php } ?>
  </tbody>
</table>
<br>
<br>
<div class="col-md-12 text-center">
<?php if($role){?><button type="button" onclick="window.location = './user/add.php'" class="btn  btn-outline-dark">Add User</button><?php } ?>
</div>
<?php
  
include("footer.php");

?>