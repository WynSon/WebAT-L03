<?php
session_start();
include("../header.php");
require "../controller.php";
require "../validate.php";
$validate = new Validator();
$validate->is_access();
if($_SESSION['role'] == 1){
  $user  = get_customers();
}else{
  $user  = get_customers_staff($_SESSION['uid']);
}

?>
<body style="background: white;">

<br>
<center><h2>Customers List</h2></center>
<br>
<table class="table">
  <thead class="thead-dark">
  <tr>
      <th scope="col">STT</th>
      <th scope="col">Username</th>
      <th scope="col">Full Name</th>
      <th scope="col">Email</th>
      <th scope="col">Phone Number</th>
      <th scope="col">Role</th>
      <th scope="col">Is Active</th>
      <th scope="col">Support Staff</th>
      <th scope="col">Action</th>    
    </tr>
  </thead>
  <tbody>
  <?php $stt=1; foreach ($user as $item){ ?>
    <tr>
      <th scope="row"><?php echo $stt; $stt++;?></th>
      <td><?php echo $item[1]; ?></td>
      <td><a href="../user/profile.php?username=<?php echo $item[1]; ?>"><?php echo $item[3]; ?> </a></td>
      <td><?php echo $item[4]; ?></td>
      <td><?php echo $item[5]; ?></td>
      <td><?php if($item[7] == 0)echo "<h5>Admin</h5>"; elseif ($item[7] == 1)echo "<h5>Sale Manager</h5>"; elseif($item[7] == 2) echo "<h5>Sale Staff</h5>"; elseif($item[7] == 3)echo "<h5>Customer</h5>"; else echo "Student"; ?></td>
      <td><?php echo $item[8]; ?></td>
      <td><?php if(isset($item[9])){ echo get_support($item[9])['fullname'] ;}else { ?> 
      <form action="./add_support.php" >
      <div style="display: table;">
      <div style="display: table-cell;"> <!-- This is the wrapper div around the text input -->
        <input type="text" name="staff" placeholder="Staff's username" />
        <input type="hidden" name="cid" value="<?php echo $item[0]; ?>" />
      </div>
      <button type="submit"  class="btn-outline-dark">Assign</button>
</div>
      </form>
       <?php } ?></td>
      <?php if($_SESSION['role'] == 2){?>
        <td>
                <div class="dropdown show">
                    <a class="btn btn-secondary dropdown-toggle"  role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                    
                    </a>
                    <div class="dropdown-menu" >
                        <a class="dropdown-item" href="../user/profile.php?username=<?php echo $item[1]; ?>">Chi tiết</a>
                        <a class="dropdown-item" href="../user/edit.php?username=<?php echo $item[1]; ?>">Sửa</a>
                        <a class="dropdown-item" onclick="return confirm('Bạn có chắc muốn xóa không?');" href="./delete.php?username=<?php echo $item[1]; ?>">Xóa</a>
                    </div>
                </div>               
      </td><?php }
      if($_SESSION['role'] == 1){?>
        <td>
                <div class="dropdown show">
                    <a class="btn btn-secondary dropdown-toggle"  role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                    
                    </a>
                    <div class="dropdown-menu" >
                        <a class="dropdown-item" href="../user/profile.php?username=<?php echo $item[1]; ?>">Chi tiết</a>
                        <a class="dropdown-item" href="../user/support.php?username=<?php echo $item[1]; ?>">Support</a>
                    </div>
                </div>               
        </td> 
    <?php } ?>     
    </tr>
    <?php } ?>
  </tbody>
</table>
<br>
<br>
<?php if ($_SESSION['role'] == 2){ ?>
  <div class="col-md-12 text-center">
  <button type="button" onclick="window.location = '../admin/add.php'" class="btn  btn-outline-dark">Add User</button>
  </div>
<?php }?>
</body>
<?php
include("../footer.php");
?>