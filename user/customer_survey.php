<?php
session_start();
include("../header.php");
require "../controller.php";
require "../validate.php";
$validate = new Validator();
$validate->is_staff();
  $survey  = get_pending_survey();

?>
<body style="background: white;">

<br>
<center><h2>Pending Surveys List</h2></center>
<br>
<table class="table">
  <thead class="thead-dark">
  <tr>
      <th scope="col">STT</th>
      <th scope="col">Username</th>
      <th scope="col">Title</th>
      <th scope="col">Question</th>
      <th scope="col">Participants</th>
      <th scope="col">Is Approve</th>
      <th scope="col" class="text-center">To do</th>     
    </tr>
  </thead>
  <tbody>
  <?php $stt=1; foreach ($survey as $item){ ?>
    <tr>
      <th scope="row"><?php echo $stt; $stt++;?></th>
      <td><?php echo get_support($item[1])['username']; ?></td>
      <td><a href="./survey.php?id=<?php echo $item[0]; ?>"><?php echo $item[2]; ?> </a></td>
      <td><?php echo $item[3]; ?></td>
      <td><?php echo $item[4]; ?></td>
      <td><?php echo $item[5]; ?></td>
        <td>
        <div class="col-md-12 text-center">
        <button type="button" onclick="window.location = '../user/approve.php?sid=<?php echo $item[0]; ?>'" class="btn  btn-outline-dark">Approve</button>
        <button type="button" onclick="confirm('Bạn có chắc reject không?');window.location = '../user/reject.php?sid=<?php echo $item[0] ?>'" class="btn  btn-outline-dark">Reject</button>
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