<?php
session_start();
include("../header.php");
require "../controller.php";
require "../validate.php";
$validate = new Validator();
$validate->survey_access();
$surveys  = get_surveys($_SESSION['uid']);
?>
<body style="background: white;">

<br>
<center><h2>Surveys List</h2></center>
<br>
<table class="table">
  <thead class="thead-dark">
  <tr>
      <th scope="col">STT</th>
      <th scope="col">Title</th>
      <th scope="col">Question</th>
      <th scope="col">Participants</th>
      <th scope="col">Is Active</th>
      <th scope="col">Action</th>    
    </tr>
  </thead>
  <tbody>
  <?php $stt=1; foreach ($surveys as $item){ ?>
    <tr>
      <th scope="row"><?php echo $stt; $stt++;?></th>
      <td><a href="../user/answer.php?id=<?php echo $item[0]; ?>"><?php echo $item[2]; ?> </a></td>
      <td><?php echo $item[3]; ?></td>
      <td><?php echo $item[4]; ?></td>
      <td><?php if($item[5] == 0)echo "<h5>Pending</h5>"; elseif ($item[5] == 1)echo "<h5>Approved</h5>"; else echo "Pending"; ?></td>
        <td>
                <div class="dropdown show">
                    <a class="btn btn-secondary dropdown-toggle"  role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                    
                    </a>
                    <div class="dropdown-menu" >
                        <a class="dropdown-item" href="./survey.php?id=<?php echo $item[0]; ?>">Chi tiết</a>
                        <a class="dropdown-item" href="./survey_edit.php?id=<?php echo $item[0]; ?>">Sửa</a>
                        <a class="dropdown-item" onclick="return confirm('Bạn có chắc muốn xóa không?');" href="./survey_delete.php?id=<?php echo $item[0]; ?>">Xóa</a>
                    </div>
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
<button type="button" onclick="window.location = '../user/survey_add.php'" class="btn  btn-outline-dark">Add Survey</button>
</div>
</body>
<?php
  
include("../footer.php");

?>