<?php
session_start();
include("../header.php");
require "../controller.php";
require "../validate.php";
$validate = new Validator();
$validate->survey_access();
$id = isset($_GET['id']) ? $_GET['id'] : '' ;
$survey = get_survey($id);
$answers  = get_answer($id);
?>
<body style="background: white;">

<br>
<center><h2><?php if($survey) echo $survey['title']; ?></h2></center>
<br>
<table class="table">
  <thead class="thead-dark">
  <tr>
      <th scope="col">STT</th>
      <th scope="col">Answer</th>
      <th scope="col">User</th>  
    </tr>
  </thead>
  <tbody>
  <?php $stt=1; foreach ($answers as $item){ ?>
    <tr>
      <th scope="row"><?php echo $stt; $stt++;?></th>
      <td><?php echo $item[2]; ?></td>
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
</body>
<?php
  
include("../footer.php");

?>