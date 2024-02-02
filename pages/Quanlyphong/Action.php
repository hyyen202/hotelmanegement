<?php
include('../../include/init.php');

$act = $_GET['act'];
switch ($act) {
    
    case 'add':
        $result = array();
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        $name = check_input($_POST['name'], $db);
        $type = check_input($_POST['type'], $db);
        $price = check_input($_POST['price'], $db);
        $addtime = round(floatval($price) * 0.1);
        $note = check_input($_POST['note'], $db);

        // Kiểm tra xem có file ảnh được chọn không
        if (isset($_FILES['img']) && $_FILES['img']['error'] == UPLOAD_ERR_OK) {
            $img = $_FILES['img']['name'];
            $img_tmp = $_FILES['img']['tmp_name'];
            $target_dir = "../../assets/images/";
            $target_file = $target_dir . basename($img);
            
            // Kiểm tra xem upload có thành công không
            if (move_uploaded_file($img_tmp, $target_file)) {
                // Upload thành công, tiếp tục xử lý
                $result['type'] = "success";
                $result['message'] = "Upload tệp thành công";
                
                $productName = "Thêm giờ cho phòng " . $name;
                
                // Kiểm tra bài viết đã tồn tại chưa
                $check = $db->num_rows("SELECT * FROM `tbl_room` WHERE id = '$name'");
                
                if (!$name || !$price || !$note || !$type || !$img) {
                    $result['type'] = "danger";
                    $result['message'] = "<b>Thất bại!</b> Vui lòng điền đầy đủ thông tin!!";
                } elseif ($check > 0) {
                    $result['type'] = "danger";
                    $result['message'] = "<b>Thất bại!</b> Phòng này đã tồn tại !!";
                } else {
                    $result['type'] = "success";
                    $result['message'] = "<b>Thành công!</b> Bạn đã thêm phòng thành công";
                    $time = CUR_DATE;
                    $db->query("INSERT INTO `tbl_room`(`id`, `type`, `price`, `note`, `status`, `img`)
                                VALUES ('$name', '$type', '$price', '$note', 'Hoạt động', '$img')");
                    $db->query("INSERT INTO `tbl_product`( `name`, `price`, `create_date`,  `qty`,  `status`,  `type`) 
                                VALUES ('$productName','$addtime','$time', 1, 'Còn hàng', 1)");
                }
            } else {
                // Upload thất bại
                $result['type'] = "danger";
                $result['message'] = "Upload tệp thất bại";
            }
        } else {
            // Không có tệp tin được chọn hoặc có lỗi khi upload
            $result['type'] = "danger";
            $result['message'] = "Vui lòng chọn một tệp tin hình ảnh";
        }
        
        echo json_encode($result);
        break;
    case 'update':
        $result = array();
        $name = check_input($_POST['name'], $db);
        $type = check_input($_POST['type'], $db);
        $price = check_input($_POST['price'], $db);
        $note = check_input($_POST['note'], $db);
        $productName = "Thêm giờ cho phòng ".$name;
        $img = $_FILES['img']['name']; // Tên tệp hình ảnh
        $img_tmp = $_FILES['img']['tmp_name']; // Đường dẫn tạm thời của tệp
        
        
        // Xử lý và lưu tệp hình ảnh vào thư mục cần lưu
        $target_dir = "assets/images/"; // Thư mục đích
        $target_file = $target_dir . basename($img);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        
            // Di chuyển tệp từ thư mục tạm thời đến thư mục đích
            move_uploaded_file($img_tmp, $target_file);
            
            // Kiểm tra bài viết đã tồn tại chưa
            $check = $db->num_rows("SELECT * FROM `tbl_room` WHERE id = '$name'");
            
            if (!$name || !$price) {
                $result['type'] = "danger";
                $result['message'] = "<b>Thất bại!</b> Vui lòng điền đầy đủ thông tin!!";
            } else {
                $result['type'] = "success";
                $result['message'] = "<b>Thành công!</b> Bạn đã cập nhật thành công";
                $time = CUR_DATE;
                $addtime = round($price * 0.2);
                $db->query("UPDATE `tbl_room` SET `img`='$img',`type`='$type',`price`='$price',`note`='$note' WHERE id = '$name'");
                $db->query("UPDATE `tbl_product` SET `price` = $addtime WHERE `name`='$productName'");
                 
            }
        
            echo json_encode($result);
        break; 
        
    case 'off':
            $result = array();
            $id = $_POST['id'];
                $db->query("UPDATE `tbl_room` SET `status`= 'Ngưng hoạt động' WHERE id = '$id'");
                $db->query("UPDATE `tbl_product` SET `status`= 'Tạm hết' WHERE name = 'Thêm 2 giờ cho phòng $id'");
                $result['type'] = "success";
                $result['message'] = "<b>Thành công!</b> Phòng $id đã cập nhật thành công";
            echo json_encode($result);
        break;

    case 'on':
            $result = array();
            $id = $_POST['id'];

                $db->query("UPDATE `tbl_room` SET `status`= 'Hoạt động' WHERE id = '$id'");
                $db->query("UPDATE `tbl_product` SET `status`= 'Còn hàng' WHERE name = 'Thêm 2 giờ cho phòng $id'");
                $result['type'] = "success";
                $result['message'] = "<b>Thành công!</b> Phòng $id đã cập nhật thành công";
            
            echo json_encode($result);
        break;
}
?>
