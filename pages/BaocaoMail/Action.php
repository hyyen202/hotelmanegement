<?php
include('../../include/init.php');

$act = $_GET['act'];


switch ($act) {
    case 'report':
        $result = array();
        $content = $_POST['ct'];
        $employee = $data_user['id'];

        if (!$content){  
            $result['type'] = "danger";
            $result['message'] = "<b>Thất bại!</b> Vui lòng điền đầy đủ nội dung." ;
        } else{
            // Lưu dữ liệu vào cơ sở dữ liệu
            $time = CUR_DATE;
            $db->query("INSERT INTO `tbl_report` (`idEmployee`, `content`, `date_report`, `status`) VALUES ('$employee', '$content', '$time', 0)");

            // Trả về thông báo thành công
            $result['type'] = "success";
            $result['message'] = "<b>Thành công!</b> Báo cáo đã được gửi.";
        }

            echo json_encode($result);
        break;

    case 'notice':
            $result = array();
            $id = check_input($_POST['report_id'], $db);
            $db->query("UPDATE `tbl_report` SET `status`= 1 WHERE id = '$id'");
            $result['type'] = "success";
            echo json_encode($result);
        break;

}
?>
