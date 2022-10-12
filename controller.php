<?php
require_once "DBconnect.php";

$db = new DBconnect();
$conn = $db->getconn();
function disconn(){
    global $conn;
    $conn = null;
}

function login($username){
    global $conn;

    $sql = "SELECT * from auth_user WHERE username = :username";
    $query = $conn->prepare($sql);
    $query->bindParam(':username',$username);
    $query->execute();

    return $query->fetch(PDO::FETCH_ASSOC);
}

function get_email($email){
    global $conn;

    $sql = "SELECT * from auth_user WHERE email = :email";
    $query = $conn->prepare($sql);
    $query->bindParam(':email',$email);
    $query->execute();

    return $query->fetch(PDO::FETCH_ASSOC);
}
//  "SELECT * FROM `password_reset_temp` WHERE `key`='".$key."' and `email`='".$email."';"
function is_reset($key_temp, $email){
    global $conn;

    $sql = "SELECT * from password_reset_temp WHERE key_temp = :key_temp and email = :email";
    $query = $conn->prepare($sql);
    $query->bindParam(':key_temp',$key_temp);
    $query->bindParam(':email',$email);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

function reset_pass($email, $newpass){
    global $conn;

    $sql = "UPDATE auth_user SET password    = :newpass
                                 WHERE email = :e
                                ";
    $query = $conn->prepare($sql);
    $query->bindParam(':newpass', $newpass);
    $query->bindParam(':e', $email);
    $query->execute();

    $sql2 = "DELETE FROM `password_reset_temp` WHERE email= :email";
    $query = $conn->prepare($sql2);
    $query->bindParam(':email', $email);
    $query->execute();
    return 1;
}

function ass_support($staff_id, $user_id){
    global $conn;

    $sql = "UPDATE auth_user SET supporter_id    = :id
                                 WHERE id = :uid
                                ";
    $query = $conn->prepare($sql);
    $query->bindParam(':id', $staff_id);
    $query->bindParam(':uid', $user_id);
    $query->execute();
}

function add_key($email, $key, $expire){
    global $conn;

    $sql = "INSERT INTO `password_reset_temp` (`email`, `key_temp`, `expire`)
    VALUES (:e,:k,:ex)";
    $query = $conn->prepare($sql);
    $query->bindParam(':e', $email);
    $query->bindParam(':k', $key);
    $query->bindParam(':ex', $expire);
    $query->execute();
}

function get_all_user(){

    global $conn;

    $sql = "SELECT * from auth_user ORDER BY role ASC";

    $query = $conn->prepare($sql);
    $query->execute();
    return $query ->fetchAll();
}
function get_customers(){

    global $conn;

    $sql = "SELECT * from auth_user WHERE role = 3 ORDER BY role ASC";

    $query = $conn->prepare($sql);
    $query->execute();
    return $query ->fetchAll();
}

function get_staff_request_manager(){

    global $conn;

    $sql = "SELECT * from auth_user_temp WHERE is_approve = 1 AND admin_approve = 0 ORDER BY create_time ASC";

    $query = $conn->prepare($sql);
    $query->execute();
    return $query ->fetchAll();
}

function get_customers_request(){

    global $conn;

    $sql = "SELECT * from auth_user_temp WHERE is_approve = 0 ORDER BY create_time ASC";

    $query = $conn->prepare($sql);
    $query->execute();
    return $query ->fetchAll();
}

function get_pending_survey(){

    global $conn;

    $sql = "SELECT * from surveys WHERE is_active = 0";
    $query = $conn->prepare($sql);
    $query->execute();
    return $query ->fetchAll();
}

function get_customers_survey_request(){

    global $conn;

    $sql = "SELECT * from surveys WHERE is_approve = 0 ORDER BY create_time ASC";

    $query = $conn->prepare($sql);
    $query->execute();
    return $query ->fetchAll();
}

function get_customers_staff($id){

    global $conn;

    $sql = "SELECT * from auth_user WHERE role = 3 AND supporter_id = :id ORDER BY role ASC";

    $query = $conn->prepare($sql);
    $query->bindParam(':id', $id);
    $query->execute();
    return $query ->fetchAll();
}

function get_support($id){

    global $conn;

    $sql = "SELECT * from auth_user WHERE id = :id";

    $query = $conn->prepare($sql);
    $query->bindParam(':id', $id);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

function get_profile($username){
    global $conn;

    $sql = "SELECT * from auth_user WHERE username = :username";

    $query = $conn->prepare($sql);
    $query->bindParam(':username', $username);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

function check_exist($username){
    global $conn;

    $sql = "SELECT * from auth_user_temp WHERE username = :username";

    $query = $conn->prepare($sql);
    $query->bindParam(':username', $username);
    $query->execute();
    return $query->fetchAll();
}
function get_temp($id){
    global $conn;

    $sql = "SELECT * from auth_user_temp WHERE id = :id";

    $query = $conn->prepare($sql);
    $query->bindParam(':id', $id);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

function get_survey($id){
    global $conn;

    $sql = "SELECT * from surveys WHERE id = :id";

    $query = $conn->prepare($sql);
    $query->bindParam(':id', $id);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

function get_surveys($user_id){

    global $conn;

    $sql = "SELECT * from surveys WHERE user_id = :uid";

    $query = $conn->prepare($sql);
    $query->bindParam(':uid', $user_id);
    $query->execute();
    return $query ->fetchAll();
}
function get_answer($id){

    global $conn;

    $sql = "SELECT * from answers WHERE survey_id = :id";

    $query = $conn->prepare($sql);
    $query->bindParam(':id', $id);
    $query->execute();
    return $query ->fetchAll();
}

function get_surveys_answer($username){

    global $conn;
    $results = array();
    $sql = "SELECT * from surveys ";

    $query = $conn->prepare($sql);
    $query->execute();
    $surveys = $query ->fetchAll();
    foreach($surveys as $survey){
        $users = explode(',', $survey['participants']);
        foreach($users as $user){
            if($username === trim($user, " ")){
                array_push($results, $survey);
            }
        }
    }
    return $results; 
}

function admin_edit($id, $fullname, $email, $phone, $address, $role, $is_active){
    global $conn;

    $sql = "UPDATE auth_user SET fullname = :f,
                                 email    = :e,
                                 phone    = :ph,
                                 address  = :add,
                                 role     = :role,
                                 is_active= :is
                                WHERE id = :i";
    $query = $conn->prepare($sql);
    $query->bindParam(':f', $fullname);
    $query->bindParam(':e', $email);
    $query->bindParam(':ph', $phone);
    $query->bindParam(':add', $address);
    $query->bindParam(':role', $role);
    $query->bindParam(':is', $is_active);
    $query->bindParam(':i', $id);
    $query->execute();
   
}

function edit_by_user($id, $phone, $email){
    global $conn;

    $sql = "UPDATE auth_user SET email    = :e,
                                 phone    = :ph
                                 WHERE id = :i
                                ";
    $query = $conn->prepare($sql);
    $query->bindParam(':e', $email);
    $query->bindParam(':ph', $phone);
    $query->bindParam(':i', $id);
    $query->execute();
}
function approve($id){
    global $conn;

    $sql = "UPDATE auth_user_temp SET is_approve = 1 WHERE id = :i ";
    $query = $conn->prepare($sql);
    $query->bindParam(':i', $id);
    $query->execute();
}

function approve_survey($id){
    global $conn;

    $sql = "UPDATE surveys SET is_active = 1 WHERE id = :i ";
    $query = $conn->prepare($sql);
    $query->bindParam(':i', $id);
    $query->execute();
}

function changepass($username, $newpass){
    global $conn;

    $sql = "UPDATE auth_user SET password    = :newpass
                                 WHERE username = :u
                                ";
    $query = $conn->prepare($sql);
    $query->bindParam(':newpass', $newpass);
    $query->bindParam(':u', $username);
    $query->execute();
}

function admin_add_user($username, $password, $fullname,  $phone, $email, $address, $role){
    global $conn;

    $sql = "INSERT IGNORE INTO auth_user(username, password, fullname, email, phone, address, role, is_active) VALUES(:u, :pa, :f, :e, :ph, :ad, :r, 1)";
    $query = $conn->prepare($sql);
    $query->bindParam(':u', $username);
    $query->bindParam(':pa', $password);
    $query->bindParam(':f', $fullname);
    $query->bindParam(':e', $email);
    $query->bindParam(':ph', $phone);
    $query->bindParam(':r', $role);
    $query->bindParam(':ad', $address);
    $query->execute();
}

function add_survey($user_id, $title, $question,  $participants, $is_active){
    global $conn;

    $sql = "INSERT IGNORE INTO surveys(user_id, title, question, participants, is_active) VALUES(:u, :ti, :c, :p, :is)";
    $query = $conn->prepare($sql);
    $query->bindParam(':u', $user_id);
    $query->bindParam(':ti', $title);
    $query->bindParam(':c', $question);
    $query->bindParam(':p', $participants);
    $query->bindParam(':is', $is_active);
    $query->execute();
}

function add_answer($survey_id, $answer, $user){
    global $conn;

    $sql = "INSERT IGNORE INTO answers(survey_id, answer, user) VALUES(:sid, :ans, :u)";
    $query = $conn->prepare($sql);
    $query->bindParam(':sid', $survey_id);
    $query->bindParam(':ans', $answer);
    $query->bindParam(':u', $user);
    $query->execute();
}

function edit_survey($id, $title, $content,  $participants){
    global $conn;

    $sql = "UPDATE surveys SET title   = :title,
                                question = :content,
                                participants = :par
                                WHERE id = :id";
                                
    $query = $conn->prepare($sql);
    $query->bindParam(':title', $title);
    $query->bindParam(':content', $content);
    $query->bindParam(':par', $participants);
    $query->bindParam(':id', $id);
    $query->execute();
}

function add_user($username, $password, $fullname,  $phone, $email, $address, $role){
    global $conn;

    $sql = "INSERT IGNORE INTO auth_user(username, password, fullname, email, phone, address, role, is_active) VALUES(:u, :pa, :f, :e, :ph, :ad, :r, 1)";
    $query = $conn->prepare($sql);
    $query->bindParam(':u', $username);
    $query->bindParam(':pa', $password);
    $query->bindParam(':f', $fullname);
    $query->bindParam(':e', $email);
    $query->bindParam(':ph', $phone);
    $query->bindParam(':r', $role);
    $query->bindParam(':ad', $address);
    $query->execute();
}

function register($username, $password, $fullname, $email,  $phone, $address, $is_approve, $action){
    global $conn;

    $sql = "INSERT IGNORE INTO auth_user_temp(username, password, fullname, email, phone, address, is_approve, action) VALUES(:usr, :pass, :ful, :ema, :ph, :add, :is, :acc)";
    $query = $conn->prepare($sql);
    $query->bindParam(':usr', $username);
    $query->bindParam(':pass', $password);
    $query->bindParam(':ful', $fullname);
    $query->bindParam(':ema', $email);
    $query->bindParam(':ph', $phone);
    $query->bindParam(':add', $address);
    $query->bindParam(':is', $is_approve);
    $query->bindParam(':acc', $action);
    $query->execute();
}



function add_message($content, $sentby, $sentto){

    global $conn;
    $sql = "INSERT INTO message(content, sentby, sentto) VALUES (:c, :sb, :st)";
    $query = $conn->prepare($sql);

    $query->bindParam(':c', $content);
    $query->bindParam(':sb', $sentby);
    $query->bindParam(':st', $sentto);
    //$query->bindParam(':cr', $created);
    $query->execute();
}

function get_massage($sentby, $sentto){
    global $conn;
    $sql = "SELECT * from message WHERE (sentby= :sb AND sentto = :st) OR (sentby= :st AND sentto = :sb) ORDER BY id";

    $query = $conn->prepare($sql);
    $query->bindParam(':sb', $sentby);
    $query->bindParam(':st', $sentto);
    $query->execute();
    return $query->fetchAll();
}

function delete_message($messageid){
    global $conn;

    $sql = "DELETE from message WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->bindParam(':id',$messageid);
    $query->execute();
}

function reject($id){
    global $conn;

    $sql = "DELETE from auth_user_temp WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->bindParam(':id',$id);
    $query->execute();
}

function reject_survey($id){
    global $conn;

    $sql = "DELETE from surveys WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->bindParam(':id',$id);
    $query->execute();
}


function edit_message($messageid, $content){
    global $conn;

    $sql = "UPDATE message SET content = :ct WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->bindParam(':id',$messageid);
    $query->bindParam(':ct',$content);
    $query->execute();
}

function check_message($messid, $sentby, $sentto ){
    global $conn;
    $sql = "SELECT * from message WHERE sentby= :sb AND id = :id AND sentto = :st";

    $query = $conn->prepare($sql);
    $query->bindParam(':sb', $sentby);
    $query->bindParam(':st', $sentto);
    $query->bindParam(':id', $messid);
    $query->execute();
    return $query->fetchAll();

}

function add_assignment($assname, $description, $path, $is_ass){

    global $conn;
    $sql = "INSERT INTO assignment(assname, description, path, is_ass) VALUES (:a, :d, :p, :i)";
    $query = $conn->prepare($sql);

    $query->bindParam(':a', $assname);
    $query->bindParam(':d', $description);
    $query->bindParam(':p', $path);
    $query->bindParam(':i', $is_ass);
    $query->execute();
}

function allowed_file($filename){
    global $conn;
    $sql = "SELECT * from assignment WHERE path= :p AND is_ass = 1";
    $query = $conn->prepare($sql);
    $query->bindParam(':p', $filename);
    $query->execute();
    return $query->fetchAll();
}

function is_ass($assname){
    global $conn;
    $sql = "SELECT * from assignment WHERE assname= :ass AND is_ass = 1";
    $query = $conn->prepare($sql);
    $query->bindParam(':ass', $assname);
    $query->execute();
    return $query->fetchAll();
}
function is_challenge($assname){
    global $conn;
    $sql = "SELECT * from assignment WHERE assname= :ass AND is_ass = 0";
    $query = $conn->prepare($sql);
    $query->bindParam(':ass', $assname);
    $query->execute();
    return $query->fetchAll();
}

function get_assignment(){

    global $conn;
    $sql = "SELECT * from assignment WHERE is_ass = 1";
    $query = $conn->prepare($sql);
    $query->execute();
    return $query->fetchAll();
}
function get_challenge(){

    global $conn;
    $sql = "SELECT * from assignment WHERE is_ass = 0";
    $query = $conn->prepare($sql);
    $query->execute();
    return $query->fetchAll();
}


function delete_user($username){
    global $conn;

    $sql = "DELETE from auth_user WHERE username = :u";
    $query = $conn->prepare($sql);
    $query->bindParam(':u',$username);
    $query->execute();
}

function delete_user_temp($username){
    global $conn;

    $sql = "DELETE from auth_user WHERE username = :u";
    $query = $conn->prepare($sql);
    $query->bindParam(':u',$username);
    $query->execute();
}

function admin_delete($id){
    global $conn;

    $sql = "DELETE from auth_user WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->bindParam(':id',$id);
    $query->execute();
}

function survey_delete($id){
    global $conn;

    $sql = "DELETE from surveys WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->bindParam(':id',$id);
    $query->execute();
}



?>