<?php
include('../../include/init.php');

$act = $_GET['act'];
switch ($act) {
    case 'register':
        
            $result = array();
            $email      = check_input($_POST['email'], $db);
            $username   = check_input($_POST['username'], $db);
            $fullname   = check_input($_POST['fullname'], $db);
            $password   = md5(md5(trim($_POST['password'])));
            $rePassword = md5(md5(trim($_POST['repassword'])));
            $check      = $db->num_rows("SELECT * FROM `tbl_user` WHERE username = '$username'");
           
            if(!$email || !$username || !$password || !$rePassword || !$fullname){
                $result['type']     = "danger";
                $result['message']  = "<b>Thất bại!</b> Vui lòng điền đầy đủ thông tin.";
                echo json_encode($result);
            }elseif(strlen($username)  > 8 || strlen($username)  < 2){
                $result['type']     = "danger";
                $result['message']  = "<b>Thất bại!</b> Tên đăng nhập giới hạn từ 2 -> 8 ký tự.";
                echo json_encode($result);
            }elseif(strlen($_POST['password'])  > 14 || strlen($_POST['password'])  < 6){
                $result['type']     = "danger";
                $result['message']  = "<b>Thất bại!</b> Mật khẩu giới hạn từ 6 -> 14 ký tự.";
                echo json_encode($result);
            }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $result['type']     = "danger";
                $result['message']  = " <b>Thất bại!</b>Email không đúng định dạng.";
                echo json_encode($result);
            }elseif($password != $rePassword){
                $result['type']     = "danger";
                $result['message']  = " <b>Thất bại!</b> Xác nhận mật khẩu không khớp.";
                echo json_encode($result);
            }elseif($check > 0){
                $result['type']     = "danger";
                $result['message']  = " <b>Thất bại!</b> Người dùng đã tồn tại.";
                echo json_encode($result);
            }else{
                $createAt = CUR_DATE;
                $db->query("INSERT INTO `tbl_user`(`fullname`, `username`, `password`, `email`, `create_at`) VALUES ('$fullname', '$username', '$password', '$email', '$createAt')");
                $result['type']     = "success";
                $result['message']  = "<b>Thành công!</b> Bạn đã đăng ký tài khoản thành công.";
                echo json_encode($result);
            }
        break;
    case 'login':
        
        $result = array();
        $username   = check_input($_POST['username'], $db);
        $password   = md5(md5($_POST['password']));
        $check      = $db->num_rows("SELECT * FROM `tbl_user` WHERE username = '$username' AND password = '$password'");
        if($user != ''){
            $result['type']     = "danger";
            $result['message']  = "<b>Thất bại!</b> Bạn đang đăng nhập.";
            echo json_encode($result);
        }elseif(!$username || !$password){
            $result['type']     = "danger";
            $result['message']  = "<b>Thất bại!</b> Vui lòng điền đầy đủ dữ liệu";
            echo json_encode($result);
        }elseif($check == 0){
            $result['type']     = "danger";
            $result['message']  = "<b>Thất bại!</b> Tên đăng nhập hoặc mật khẩu không chính xác";
            echo json_encode($result);
        }else{
            $result['type']     = "success";
            $result['message']  = "<b>Thành công!</b> Đăng nhập thành công. Hệ thống sẽ chuyển hướng sau vài giây.";
            echo json_encode($result);
            $session->send($username);
            if($_POST['remeber'] == "true"){
                $day_live   = LIVE_COOKIE;
                $params     = session_get_cookie_params();
                setcookie(session_name(), $_COOKIE[session_name()], time() + 60*60*24*$day_live, $params["path"], $params["domain"], $params["secure"], true); //$params["httponly"]
                start();
            }
        }
        break;
    case 'forgot':

            $result = array();
            $username   = check_input($_POST['username'], $db);
            $sql        = "SELECT * FROM `tbl_user` WHERE username = '$username'";
            $check      = $db->num_rows($sql);
            $get        =  $db->fetch_assoc($sql, 1);
            if($user != ''){
                $result['type']     = "danger";
                $result['message']  = "<b>Thất bại!</b> Bạn đang đăng nhập.";
                echo json_encode($result);
            }elseif(!$username){
                $result['type']     = "danger";
                $result['message']  = "<b>Thất bại!</b> Vui lòng nhập tên đăng nhập để tiến hành khôi phục mật khẩu.";
                echo json_encode($result);
            }elseif($check == 0){
                $result['type']     = "danger";
                $result['message']  = "<b>Thất bại!</b> Không tìm thấy tài khoản của bạn trên hệ thống.";
                echo json_encode($result);
            }elseif($get['email'] == ''){
                $result['type']     = "danger";
                $result['message']  = "<b>Thất bại!</b> Tài khoản của bạn chưa cập nhật email. Vui lòng liên hệ hỗ trợ để tiến hành lấy lại mật khẩu.";
                echo json_encode($result);
            }else{
                $result['type']     = "success";
                $result['message']  = "<b>Thành công!</b> Hệ thống vừa gửi Email khôi phục mật khẩu đến bạn. Vui lòng check Email & làm theo hướng dẫn.";
                echo json_encode($result);
            }
            break;
    case 'change_info':
            $result = array();
            $fullname = check_input($_POST['fullname'], $db);
            $role = check_input($_POST['role'], $db);
            $id = $_POST['id'];  // Changed to POST instead of GET
                
            if (empty($fullname)) {
                $result['type'] = "danger";
                $result['message'] = "Vui lòng điền đầy đủ thông tin.";
                echo json_encode($result);
            } else {
                $result['type'] = "success";
                $result['message'] = "Cập nhật thành công.";
            
                // Update the database
                $db->query("UPDATE `tbl_user` SET `fullname`='$fullname', `role`='$role' WHERE id = '$id'");
                echo json_encode($result);
            }
            break;
        
 
    case 'change_password':
        
        $result = array();
        $old_password      = check_input($_POST['old_password'], $db);
        $new_password      = check_input($_POST['new_password'], $db);
        $confirm_password   = check_input($_POST['confirm_password'], $db);
        $old = md5(md5($old_password));
        $new = md5(md5($new_password));
        if($user == ''){
            $result['type']     = "danger";
            $result['message']  = "<b>Thất bại!</b> Bạn chưa đăng nhập.";
            echo json_encode($result);
        }elseif(!$old_password || !$new_password || !$confirm_password){
            $result['type']     = "danger";
            $result['message']  = "<b>Thất bại!</b> Vui lòng nhập đầy đủ thông tin";
            echo json_encode($result);
        }elseif(strlen($new_password)  > 14 || strlen($new_password)  < 6){
            $result['type']     = "danger";
            $result['message']  = "<b>Thất bại!</b> Mật khẩu giới hạn từ 6 -> 14 ký tự.";
            echo json_encode($result);
        }elseif($old != $data_user['password']){
            $result['type']     = "danger";
            $result['message']  = "<b>Thất bại!</b> Mật khẩu cũ không chính xác.";
            echo json_encode($result);
        }elseif($new == $data_user['password']){
            $result['type']     = "danger";
            $result['message']  = "<b>Thất bại!</b> Mật khẩu mới giống mật khẩu cũ.";
            echo json_encode($result);
        }elseif($new_password != $confirm_password){
            $result['type']     = "danger";
            $result['message']  = "<b>Thất bại!</b> Xác nhận mật khẩu mới không chính xác.";
            echo json_encode($result);
        }else{
            $user_id            = $data_user['id'];
            $db->query("UPDATE `tbl_user` SET `password`='$new' WHERE `id`='$user_id' ");
            $result['type']     = "success";
            $result['message']  = "<b>Thành công!</b> Bạn đã đổi mật khẩu thành công.";
            echo json_encode($result);
        }
        break;
        
        
    
    
    
}
?>