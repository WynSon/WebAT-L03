<?php

function is_valid_passwd($pass){
    return (!preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $pass)) ? FALSE : TRUE;
}
$pass = "1234567";
var_dump(is_valid_passwd($pass));
?>