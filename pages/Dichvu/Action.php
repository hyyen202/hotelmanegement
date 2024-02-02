<?php
include('../../include/init.php');

$act = $_GET['act'];
switch ($act) {
    case 'add':
        $result = array();
        $name = check_input($_POST['name'], $db);
        $price = check_input($_POST['price'], $db);
        $qty = check_input($_POST['qty'], $db);
        $time = CUR_DATE;
        $id = $data_user['id'];
            // Kiểm tra bài viết đã tồn tại chưa
            $check = $db->num_rows("SELECT * FROM `tbl_product` WHERE name = '$name'");
                
            if (!$name || !$qty || !$price) {
                $result['type'] = "danger";
                $result['message'] = "<b>Thất bại!</b> Vui lòng điền đầy đủ thông tin!!";
            } elseif ($check > 0) {
                $result['type'] = "danger";
                $result['message'] = "<b>Thất bại!</b> Sản phẩm đã tồn tại !!";
            }else {
                $result['type'] = "success";
                $result['message'] = "<b>Thành công!</b> Bạn đã thêm thành công";
                $db->query("INSERT INTO `tbl_product`( `name`, `price`, `create_date`,  `qty`,  `status`,  `type`) 
                            VALUES ('$name','$price','$time', '$qty', 'Còn hàng', 0)");
            }
            echo json_encode($result);
        break;
    case 'update':
            $result = array();
            $id = check_input($_POST['idPro'], $db);
            $name = check_input($_POST['name'], $db);
            $price = check_input($_POST['price'], $db);
            $status = check_input($_POST['status'], $db);
            $qty = check_input($_POST['qty'], $db);
            $timeUpdate = CUR_DATE;
                if (!$name || !$qty || !$price) {
                    $result['type'] = "danger";
                    $result['message'] = "<b>Thất bại!</b> Vui lòng điền đầy đủ thông tin!!";
                } 
             else {
                $result['type'] = "success";
                $result['message'] = "<b>Thành công!</b> Bạn đã cập nhật thành công";
                $db->query("UPDATE `tbl_product` SET `name`='$name',`price`='$price',`qty`='$qty',`dateUpdate`=' $timeUpdate', 
                            `status`='$status' WHERE id = $id");
            }
        
        echo json_encode($result);
        break;
}
?>
