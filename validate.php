<?php
class Validator{


    // Check Logged in. If not-> redirect to Login page
    public function is_login(){
        if(!isset($_SESSION['username'])) {
            header('Location: http://localhost/PHP-Security/Login.php');
            exit;
        }
    }
    //Reject if not have role Teacher
    public function is_admin(){
        $this->is_login();
        $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
        if($role > 0){
            http_response_code(403);
            die('Forbidden');
          }
        }

    public function is_staff(){
        $this->is_login();
        $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
        if($role != 2){
            http_response_code(403);
            die('Forbidden');
            }
        }
    public function is_manager(){
        $this->is_login();
        $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
        if($role != 1){
            http_response_code(403);
            die('Forbidden');
            }
        }
    public function is_customer(){
        $this->is_login();
        $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
        if($role != 3){
            http_response_code(403);
            die('Forbidden');
          }
        }

    public function survey_access(){
        $this->is_login();
        $role = $_SESSION['role'];
        if($role < 3){
            http_response_code(403);
            die('Forbidden');
          }
        }
    public function is_access(){
            $this->is_login();
            $role = $_SESSION['role'];
            if($role < 1 && $role > 2){
                http_response_code(403);
                die('Forbidden');
              }
            }
    // Validate when edit profile, Reject If not teacher or not owner of account
    public function is_permission($currentuser){
        $this->is_login();
        $check = $_SESSION['role'];
        $username = $_SESSION['username'];
        if($username!==$currentuser){       
            http_response_code(403);  
            die("<center><h1>Forbidden</h1.</center>");
            }
        }
    

    // Validate Login form, 
    public function login_form(){
          
            global $data;
            $data['username']    = isset($_POST['username']) ? htmlspecialchars( $_POST['username']): '';
            $data['password']    = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
            
            $errors = array();
            if (empty($data['username'])){
                $errors['username'] = 'Chưa nhập Account hoặc sai định dạng';
            }
            if (empty($data['password'])){
                $errors['password'] = 'Chưa nhập mật khẩu hoặc sai định dạng';
            }


        return $errors;
    }
    public function password_form(){
          
        global $data;
        $data['username'] =  isset($_POST['username']) ? htmlspecialchars( $_POST['username']): '';
        $data['oldpassword']    = isset($_POST['oldpassword']) ? htmlspecialchars( $_POST['oldpassword']): '';
        $data['newpassword']    = isset($_POST['newpassword']) ? htmlspecialchars($_POST['newpassword']) : '';
        $data['repassword']    = isset($_POST['repassword']) ? htmlspecialchars($_POST['repassword']) : '';
        $profile = get_profile($data['username']);
        if(!$profile){
            echo "<script>alert('There is an error, Try again!')</script>";
        }
        $errors = array();
        if($_SESSION['username']==$_GET['username'] ){
            if(!password_verify($data['oldpassword'], $profile['password'])){
            $errors['oldpassword'] = 'Mật khẩu cũ không trùng khớp';
            }
        
        if (empty($data['oldpassword'])){
            $errors['oldpassword'] = 'Vui lòng nhập mật khẩu cũ';



            
            }
        }
        if (empty($data['newpassword'])){
            $errors['newpassword'] = 'Chưa nhập mật khẩu mới';
        }
        if(!$this->is_valid_passwd($data['newpassword'])){
            $errors['newpassword'] = 'Password require at least 8 character combine digits,upper and lower key';
        }
        if (empty($data['repassword'])){
            $errors['repassword'] = 'Vui lòng nhập lại mật khẩu mới';
        }
        if ($data['repassword']!==$data['newpassword']){
            $errors['repassword'] = 'Mật khẩu mới bạn vừa nhập không trùng khớp';
        }


    return $errors;
}

public function password_reset(){
          
    global $data;
    $data['email'] =  isset($_POST['email']) ? htmlspecialchars( $_POST['email']): '';
    $data['newpassword']    = isset($_POST['newpassword']) ? htmlspecialchars($_POST['newpassword']) : '';
    $data['repassword']    = isset($_POST['repassword']) ? htmlspecialchars($_POST['repassword']) : '';
    $profile = get_email($data['email']);
    if(!$profile){
        echo "<script>alert('There is an error, Try again!')</script>";
    }
    $errors = array();

    if (empty($data['newpassword'])){
        $errors['newpassword'] = 'Chưa nhập mật khẩu mới';
    }
    if(!$this->is_valid_passwd($data['newpassword'])){
        $errors['newpassword'] = 'Password require at least 8 character combine digits,upper and lower key';
    }
    if (empty($data['repassword'])){
        $errors['repassword'] = 'Vui lòng nhập lại mật khẩu mới';
    }
    if ($data['repassword']!==$data['newpassword']){
        $errors['repassword'] = 'Mật khẩu mới bạn vừa nhập không trùng khớp';
    }
return $errors;
}


    // validate Register form
    public function register_form(){

        global $data;
        $data['fullname']    = isset($_POST['fullname']) ? htmlspecialchars( $_POST['fullname']): '';
        $data['username']    = isset($_POST['username']) ? htmlspecialchars( $_POST['username']): '';
        $data['password']    = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
        $data['repassword']  = isset($_POST['repassword']) ?  htmlspecialchars($_POST['repassword']) : '';
        $data['phone']       = isset($_POST['phone']) ?  htmlspecialchars($_POST['phone']) : '';
        $data['email']       = isset($_POST['email']) ?  htmlspecialchars($_POST['email']) : '';
        $data['address']       = isset($_POST['address']) ?  htmlspecialchars($_POST['address']) : '';
        $data['role']        = 0;
        
        // Validate form
        $errors = array();
        if(get_profile($data['username']) || check_exist($data['username'])){
            $errors['username'] = "Username đã tồn tại";
        }
        if(get_email($data['email'])){
            $errors['email'] = "Email already associated with another user";
        }
        $invalid_username = array("administrator", "support", "root", "postmaster", "abuse", "webmaster", "security");
        if (empty($data['username']) || strlen($data['username']) < 3 || strlen($data['username']) >25 || in_array($data['username'], $invalid_username)){
            $errors['username'] = 'Chưa nhập Account hoặc sai định dạng, username must from 3 to 25 characters and not include those words: administrator, support, root, postmaster, abuse, webmaster, security';
        }
        if (empty($data['password'])){
            $errors['password'] = 'Chưa nhập mật khẩu hoặc sai định dạng';
        }
        if(!$this->is_valid_passwd($data['password'])){
            $errors['password'] = 'Password phải chứa ít nhất 8 kí tự bao gồm số, chữ viết hoa, viết thường và kí tự đặc biệt';
        }
        if (empty($data['phone']) || !$this->is_sdt($data['phone'])){
            $errors['phone'] = 'Vui lòng nhập một số điện thoại hợp lệ';
        }
        if (empty($data['email']) || !$this->is_email($data['email'])){
            $errors['email'] = 'Chưa nhập email hoặc sai định dạng';
        }
        if ($data['password']!==$data['repassword']){
            $errors['repassword'] = 'Mật khẩu bạn vừa nhập không trùng khớp';
        }

        return $errors;
}

    //Validate add form
    public function add_form(){

        global $data;
        $data['username']    = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
        $data['password']    = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
        $data['fullname']    = isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : '';
        $data['phone']       = isset($_POST['phone'])    ? htmlspecialchars($_POST['phone']) : '';
        $data['email']       = isset($_POST['email'])    ? htmlspecialchars($_POST['email']) : '';
        $data['role']        = isset($_POST['role'])    ? htmlspecialchars($_POST['role']) : '';
        $data['address']    = isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '';
        
        $errors = array();
        if(get_profile($data['username'])){
            $errors['username'] = "Username already exists";
        }
        if(get_email($data['email'])){
            $errors['email'] = "Email already exists";
        }
        if (empty($data['username'])){
            $errors['username'] = 'Chưa nhập Account hoặc sai định dạng';
        }
        if (empty($data['password'])){
            $errors['password'] = 'Chưa nhập mật khẩu hoặc sai định dạng';
        }
        if(!$this->is_valid_passwd($data['password'])){
            $errors['password'] = 'Password require at least 8 character combine digits,up and lower key';
        }
        if (empty($data['fullname'])){
            $errors['fullname'] = 'Chưa nhập tên hoặc sai định dạng';
        }
        if (empty($data['phone']) || !$this->is_sdt($data['phone'])){
            $errors['phone'] = 'Chưa nhập SĐT hoặc sai định dạng';
        }
        if (empty($data['email']) || !$this->is_email($data['email'])){
            $errors['email'] = 'Chưa nhập email hoặc sai định dạng';
        }
        return $errors;
    }

    public function add_survey_form(){

        global $data;
        $data['id']    = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : '';
        $data['title']    = isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '';
        $data['question']    = isset($_POST['question']) ? htmlspecialchars($_POST['question']) : '';
        $data['participants'] = isset($_POST['participants']) ? htmlspecialchars($_POST['participants']) : '' ;
        $errors = array();
        if (empty($data['title'])){
            $errors['title'] = 'Chưa nhập tiêu đề hoặc sai định dạng';
        }
        if (empty($data['question'])){
            $errors['question'] = 'Chưa nhập nội dung hoặc sai định dạng';
        }
        if (empty($data['participants'])){
            $errors['participants'] = 'Vui lòng nhập người tham gia khảo sát';
        }
        return $errors;
    }

    public function answer_submit(){

        global $data;
        $data['sid'] = isset($_POST['sid']) ? htmlspecialchars($_POST['sid']) : '';
        $data['user'] = isset($_POST['user']) ? htmlspecialchars($_POST['user']) : '';
        $data['answer']    = isset($_POST['answer']) ? htmlspecialchars($_POST['answer']) : '';
        $errors = array();
        if (empty($data['answer'])){
            $errors['answer'] = 'Vui lòng nhập câu trả lời';
        }
        return $errors;
    }

    // Validate Edit form
    public function admin_edit(){
        global $data;
        // Get data from form
        $data['id']       = isset($_POST['id']) ? $_POST['id'] : '';
        $data['username']        = isset($_POST['username'] ) ? $_POST['username']  : '';
        $data['fullname']    = isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : '';
        $data['phone']       = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
        $data['email']       = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
        $data['address']       = isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '';
        $data['role']       = isset($_POST['role']) ? htmlspecialchars($_POST['role']) : '';
        $data['is_active']       = isset($_POST['is_active']) ? htmlspecialchars($_POST['is_active']) : '';
        // Validate form
        $errors = array();
        if($data['email']){
            $user_pf = get_email($data['email']);
            if($user_pf && $data['email'] !== $user_pf['email']){
                $errors['email'] = "Email already exists";
            }
        }        
        if(!filter_var($data['id'], FILTER_VALIDATE_INT)){
            $errors['id'] = 'This field do not accept to change';
        }
        if (empty($data['username'])){
            $errors['username'] = 'Chưa nhập Account hoặc sai định dạng';
        }
        if (empty($data['fullname'])){
            $errors['fullname'] = 'Chưa nhập tên hoặc sai định dạng';
        }
        if (empty($data['phone']) || !$this->is_sdt($data['phone'])){
            $errors['phone'] = 'Chưa nhập SĐT hoặc sai định dạng';
        }
        if (empty($data['email']) || !$this->is_email($data['email'])){
            $errors['email'] = 'Chưa nhập email hoặc sai định dạng';
        }
        return $errors;
    }


    // Validate Edit form
    public function edit_form_user(){
        global $data;
        // Get data from form
        $data['id']          = isset($_POST['id']) ? $_POST['id'] : '';
        $data['phone']       = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
        $data['email']       = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
        $origin = isset($_POST['originuser']) ? htmlspecialchars($_POST['originuser']) : '';   
        // Validate form
        $errors = array();
        if($data['username']!==$origin){
            if(get_profile($data['username'])){
                $errors['duplicate'] = "Username already exists";
            }
        }
        if(!filter_var($data['id'], FILTER_VALIDATE_INT)){
            $errors['id'] = 'This field do not accept to change';
        }
        if (empty($data['phone']) || !$this->is_sdt($data['phone'])){
            $errors['phone'] = 'Chưa nhập SĐT hoặc sai định dạng';
        }
        if (empty($data['email']) || !$this->is_email($data['email'])){
            $errors['email'] = 'Chưa nhập email hoặc sai định dạng';
        }
        return $errors;
    }

    function valid_filename(string $filename){
        if (strlen($filename) > 255) { // no mb_* since we check bytes
            return false;
            }
        $invalidCharacters = "/[\'\\?*&<%\";:>+[]=]/";
        if (strpbrk($filename, $invalidCharacters)) {
            return false;
            }
            return true;
    }

    function check_allowed_file_download($path){

        if(!allowed_file($path)){
            echo "<center><br><h1>404. File doesn't exists or you don't have permission.</center></h1>";
            exit;
        }
    }

    function is_ass($assname){
        if(!is_ass($assname)){
            echo "<center><h1> 404 Not found, don't edit anything. Please !</center></h1>";
            exit;
        }
    }

    function is_challenge($assname){
        if(!is_challenge($assname)){
            echo "<center><h1> 404 Not found, don't edit anything. Please !</center></h1>";
            exit;
        }
    }

    function check_csrf($formtoken, $servertoken){
        if($formtoken!==$servertoken){
            return true;
        }
        else{
            return false;
        }
    }




    public function is_valid_passwd($pass){
        return (!preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $pass)) ? FALSE : TRUE;
    }

    public function is_email($str) {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }
    public function is_sdt($str) {
        return (!preg_match("/^[0-9]{10,11}$/x", $str)) ? FALSE : TRUE;
    }
}
?>