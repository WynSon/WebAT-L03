<?php
session_start();
include("../header.php");
require "../controller.php";
require "../validate.php";
$validate = new Validator();
$validate->survey_access();
$surveys  = get_surveys_answer($_SESSION['username']);
?>
<body style="background: white;">

<br>
<center><h2>Surveys List</h2></center>
<br>
<table class="table">
  <thead class="thead-dark">
  <tr>
      <th scope="col"></th>
      <th scope="col"></th>
      <th scope="col"></th>
      <th scope="col">STT</th>
      <th scope="col">Title</th>
      <th scope="col">Question</th>  
    </tr>
  </thead>
  <tbody>
  <?php $stt=1; foreach ($surveys as $item){ ?>
    <tr>
      <th scope="row">   </th>
      <th scope="row"></th>
      <th scope="row"></th>
      <th scope="row"><?php echo $stt; $stt++;?></th>
      <td><a href="../user/survey.php?id=<?php echo $item[0]; ?>"><?php echo $item[2]; ?> </a></td>
      <td><?php echo $item[3]; ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<br>
<br>
<div class="col-md-12 text-center">
<button type="button" onclick="history.back()" class="btn  btn-outline-dark">Back</button>
</div>
<div class="col-md-12 text-center">
</div>
</body>
<?php
  
include("../footer.php");

?>