<?php
session_start();
include("../header.php");
require "../controller.php";
require "../validate.php";
$validate = new Validator();
$validate->is_access();
if($_SESSION['role'] == 1){
  $user  = get_staff_request_manager();
}else{
  $user  = get_customers_request();
}

?>
<body style="background: white;">

<br>
<center><h2>In Comming Requests</h2></center>
<br>
<table class="table">
  <thead class="thead-dark">
  <tr>
      <th scope="col">STT</th>
      <th scope="col">Username</th>
      <th scope="col">Full Name</th>
      <th scope="col">Email</th>
      <th scope="col">Phone Number</th>
      <th scope="col">Is Approve</th>
      <th scope="col">Create Time</th>
      <th scope="col">Action</th>
      <th scope="col" class="text-center">To do</th>     
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
      <td><?php echo $item[7]; ?></td>
      <td><?php echo $item[9]; ?></td>
      <td><?php if($item[10] == 'add')echo "<h5>Register</h5>"; elseif ($item[10] == 'create')echo "<h5>Create Survey</h5>"; elseif($item[10] == 'edit') echo "<h5>Edit</h5>"; elseif($item[10] == 'delete') echo "<h5>Delete</h5>" ?></td>
        <td>
        <div class="col-md-12 text-center">
        <button type="button" onclick="window.location = '../user/approve.php?id=<?php echo $item[0]; ?>&action=<?php echo $item[10]; ?>'" class="btn  btn-outline-dark">Approve</button>
        <button type="button" onclick="confirm('Bạn có chắc reject không?');window.location = '../user/reject.php?id=<?php echo $item[0] ?>'" class="btn  btn-outline-dark">Reject</button>
        </div>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<br>
<br>
<div class="col-md-12 text-center">
<button type="button" onclick="history.back()" class="btn  btn-outline-dark">Back</button>
</div>
</body>
<?php
  
include("../footer.php");

?>