<?php
include('../../include/init.php');

$act = $_GET['act'];
switch ($act) {
    case 'add':
        $result = array();
        
        // Thêm KH mới ở đây
        $name = check_input($_POST['name'], $db);
        $id = check_input($_POST['id'], $db);
        $birthday = check_input($_POST['birthday'], $db);
        $phone = check_input($_POST['phone'], $db);
        $email = check_input($_POST['email'], $db);
        
            // Kiểm tra bài viết đã tồn tại chưa
            $check = $db->num_rows("SELECT * FROM `tbl_customers` WHERE id = '$id'");
            
            if (!$name || !$id ) {
                $result['type'] = "danger";
                $result['message'] = "<b>Thất bại!</b> Vui lòng điền đầy đủ thông tin!!";
            } elseif ($check > 0) {
                $result['type'] = "danger";
                $result['message'] = "<b>Thất bại!</b> Khách hàng đã tồn tại !!";
            } else {
                $result['type'] = "success";
                $result['message'] = "<b>Thành công!</b> Bạn đã thêm thành công";
                
                $db->query("INSERT INTO `tbl_customers`(`id`, `name`, `phone`, `birthday`,`email`) VALUES ('$id','$name','$phone','$birthday','$email')");
            }
        
        
            echo json_encode($result);
        break;
    case 'update':
            $result = array();
    
            // Thêm KH mới ở đây
            $name = check_input($_POST['name'], $db);
            $id = check_input($_POST['id'], $db);
            $birthday = check_input($_POST['birthday'], $db);
            $phone = check_input($_POST['phone'], $db);
            $email = check_input($_POST['email'], $db);
    
            // Kiểm tra bài viết đã tồn tại chưa
            $check = $db->num_rows("SELECT * FROM `tbl_customers` WHERE id = '$id'");
    
            // Validate email and phone formats
            $phoneRegex = '/^[0-9]{10}$/'; // Assuming 10-digit phone number
            $emailRegex = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';
    
            if (!$name  || !$phone || !$email || !$birthday) {
                $result['type'] = "danger";
                $result['message'] = "<b>Thất bại!</b> Vui lòng điền đầy đủ thông tin!!";
            } elseif (!preg_match($phoneRegex, $phone)) {
                $result['type'] = "danger";
                $result['message'] = "<b>Thất bại!</b> Số điện thoại không hợp lệ!! ";
            } elseif (!preg_match($emailRegex, $email)) {
                $result['type'] = "danger";
                $result['message'] = "<b>Thất bại!</b> Địa chỉ email không hợp lệ!!";
            } else {
                $result['type'] = "success";
                $result['message'] = "<b>Thành công!</b> Bạn đã cập nhật thành công";
                $db->query("UPDATE `tbl_customers` SET `name`='$name',`phone`='$phone',`birthday`='$birthday',`email`='$email' WHERE `id`= '$id'");
            }
    
            // Output the result as JSON
                echo json_encode($result);
            break;
}

?>
