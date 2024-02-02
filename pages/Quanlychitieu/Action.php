<?php
include('../../include/init.php');

$act = $_GET['act'];
switch ($act) {
    case 'add':
        $result = array();
        // Thêm phòng mới ở đây
        $name = check_input($_POST['name'], $db);
        $price = check_input($_POST['price'], $db);
        $number = check_input($_POST['number'], $db);
        $time = CUR_DATE;
        $id = $data_user['id'];
            if (!$name || !$number || !$price) {
                $result['type'] = "danger";
                $result['message'] = "<b>Thất bại!</b> Vui lòng điền đầy đủ thông tin!!";
            } 
             else {
                $result['type'] = "success";
                $result['message'] = "<b>Thành công!</b> Bạn đã thêm thành công";
                $time = date('Y/m/d');
                
                $db->query("INSERT INTO `tbl_spend`( `product`, `price`, `dateSpend`, `idEmloyee`,  `number`) VALUES ('$name','$price','$time','$id', '$number')");
            }
        
        echo json_encode($result);
        break;
    case 'update':
        $result = array();
        // Thêm phòng mới ở đây
        $name = check_input($_POST['name'], $db);
        $id = check_input($_POST['id'], $db);
        $price = check_input($_POST['price'], $db);
        $number = check_input($_POST['number'], $db);
        $timeUpdate = CUR_DATE;
            if (!$name || !$number || !$price) {
                $result['type'] = "danger";
                $result['message'] = "<b>Thất bại!</b> Vui lòng điền đầy đủ thông tin!!";
            } 
             else {
                $result['type'] = "success";
                $result['message'] = "<b>Thành công!</b> Bạn đã cập nhật thành công";
                $time = date('Y/m/d');
                
                $db->query("UPDATE `tbl_spend` SET `product`='$name',`price`='$price',`number`='$number',`dateUpdate`=' $timeUpdate' WHERE id = $id");
            }
        
        echo json_encode($result);
        break;
}
?>
