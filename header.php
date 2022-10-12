<!DOCTYPE html>
<html lang="en">
<head>

<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../css/chat.css" >
<link rel="stylesheet" href="../css/profile.css" >
</head>
<body>
<nav class="navbar navbar-expand-lg   navbar-dark bg-dark">
  <a class="navbar-brand" href="http://localhost/PHP-Security/home.php">Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto" style="float: right;">
    <li class="nav-item">
        <a class="nav-link " href="http://localhost/PHP-Security/user/profile.php?username=<?php if(isset($_SESSION['username'])) echo $_SESSION['username'];?>">Profile</a>
      </li>
    <?php if (isset($_SESSION['role'])){ if ($_SESSION['role'] == 0){?>
      <li class="nav-item ">
        <a class="nav-link" href="http://localhost/PHP-Security/admin/list.php">Users Managerment</a>
      </li>
         <?php }elseif(($_SESSION['role'] == 1)){ ?>
            <li class="nav-item ">
              <a class="nav-link" href="http://localhost/PHP-Security/user/customers.php">Customers</a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="http://localhost/PHP-Security/user/in_comming.php">In Comming Requests</a>
            </li>

        <?php }elseif(($_SESSION['role'] == 2)){ ?>
          <li class="nav-item ">
            <a class="nav-link" href="http://localhost/PHP-Security/user/customers.php">Customers</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="http://localhost/PHP-Security/user/in_comming.php">In Comming Requests</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="http://localhost/PHP-Security/user/customer_survey.php">Pending Surveys</a>
          </li>
        <?php }else{ ?>
          <li class="nav-item ">
            <a class="nav-link" href="http://localhost/PHP-Security/user/survey_answer.php">Surveys</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="http://localhost/PHP-Security/user/survey_list.php">Surveys Management</a>
          </li>          
          <li class="nav-item ">
            <a class="nav-link" href="http://localhost/PHP-Security/user/support.php">Support</a>
          </li>      
        <?php }} ?>
      <li class="nav-item">
        <a class="nav-link" href="<?php if(isset($_SESSION['username'])) echo "http://localhost/PHP-Security/Logout.php"; else echo "http://localhost/PHP-Security/Login.php";?>"><?php if(isset($_SESSION['username'])) echo "Log out"; else echo "Log in";?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link " style="margin-left: 180px; color:yellow"><?php if(isset($_SESSION['role'])){ if($_SESSION['role'] == 0) echo "Hi Admin, "; elseif($_SESSION['role'] == 1) echo "Hi Sale Manager, "; elseif($_SESSION['role'] == 2) echo "Hi Sale Staff, "; elseif($_SESSION['role'] == 3) echo "Hi Customer, "; echo $_SESSION['username'];}  ?></a>
      </li>
    </ul>
  </div>
</nav>
        </body>
      