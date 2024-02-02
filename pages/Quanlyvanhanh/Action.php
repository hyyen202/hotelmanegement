<?php
include('../../include/init.php');

require('../BaocaoMail/Send.php');

$act = $_GET['act'];
switch ($act) {
    
    case 'booking':
            $result = array();
            
            // Thêm phòng mới ở đây
            $room = check_input($_POST['room'], $db); 
            $type = check_input($_POST['type'], $db);
            $price = check_input($_POST['price'], $db);
            $id = check_input($_POST['id'], $db);
            $dateOut = check_input($_POST['dateOut'], $db);
            $dateIN = check_input($_POST['dateIN'], $db);
            $employee = $data_user['id'];
            $out = new DateTime($dateOut);
            $in = new DateTime($dateIN);
            $interval = $out->diff($in);
            $day = $interval->days;
            $deal = (($price * $day) * 50) / 100;
                // Kiểm tra bài viết đã tồn tại chưa
                $check = $db->num_rows("SELECT * FROM `tbl_customers` WHERE id = '$id'");
                $checkdate = $db->num_rows("SELECT * FROM tbl_booking
                            WHERE status = 'Chưa thanh toán'
                            AND idRoom = '$room'
                            AND ('$dateIN' BETWEEN dateIn AND dateOut
                            OR '$dateOut' BETWEEN dateIn AND dateOut)");

                if (!$id || !$dateOut || !$dateIN) {
                    $result['type'] = "danger";
                    $result['message'] = "<b>Thất bại!</b> Vui lòng điền đầy đủ thông tin!!";
                } elseif ($check == 0) {
                    $result['type'] = "danger";
                    $result['message'] = "<b>Thất bại!</b> Chưa có thông tin khách hàng trên hệ thống!!";
                } elseif ($checkdate >= 1) {
                    $result['type'] = "danger";
                    $result['message'] = "<b>Thất bại!</b> Phòng đã có người đặt vào khoảng thời gian này! Vui lòng chọn ngày khác!";
                } else {
                    $result['type'] = "success";
                    $result['message'] = "<b>Thành công!</b> Bạn đã đặt phòng thành công";

                    $db->query("INSERT INTO `tbl_booking`(`idCustomer`, `idRoom`, `dateIn`, `dateOut`, `status`, `idEmloyee`, `deal`, `priceRoom`)
                                VALUES ('$id','$room','$dateIN','$dateOut', 'Chưa thanh toán','$employee', '$deal', '$price')");
                }

                echo json_encode($result);
        break;
    case 'total':
                $result = array();
                
                $idEmloyeeTT = $data_user['id'];
                $idRoom = check_input($_POST['idRoom'], $db); 
                $idBooking = check_input($_POST['idBooking'], $db); 
                $day = check_input($_POST['day'], $db);
                $total= check_input($_POST['total'], $db);
                $dateCheckout = check_input($_POST['dateCheckout'], $db);
                $cccd = check_input($_POST['cccd'], $db);
                $items = json_decode($_POST['items'], true); 
                foreach ($items as $item) {
                    $qty = $item['qty'];
                    $idItem = $item['id'];
                    $type= $item['type'];
                }
                    $result['type'] = "success";
                    $result['message'] = "<b>Thành công!</b>Đã thanh toán thành công!";
                    $db->query("INSERT INTO `tbl_bill`( `idBooking`, `day`, `dateCheckout`, `total`, `idEmloyeeTT`) VALUES ('$idBooking','$day','$dateCheckout','$total','$idEmloyeeTT')");
                    $db->query("UPDATE `tbl_room` SET `status`='Hoạt động' WHERE id = '$idRoom'");
                    $db->query("UPDATE `tbl_booking` SET `status`='Đã thanh toán' WHERE id = '$idBooking'");
                    $db->query("UPDATE `tbl_service` SET `status`= 1 WHERE id = '$idBooking'");
                    $sql = "SELECT  email,  name FROM  tbl_customers  WHERE id = '$cccd' ";
                    $row = $db->fetch_assoc($sql, 1);
                    $name = $row['name'];
                    $email = $row['email'];
                    $title = "Thanh toán thành công - NIKKO Hotel";
                    $message = "<div>Cảm ơn bạn đã chọn trải nghiệm tại NIKKO Hotel.
                                <br>Khách hàng " . $name. " đã thanh toán thành công số tiền ".number_format($total)."đ 
                                <br>Xin cảm phiền quí khách lên website của NIKKO Hotel và đánh giá trải nghiệm để khách sạn có thể cải thiện tốt hơn
                                <br>Chúc quý khách có một trải nghiệm tuyệt vời.
                                <br>Nếu bạn có bất kỳ câu hỏi hoặc cần thêm thông tin, vui lòng liên hệ chúng tôi qua:
                                <br>Điện thoại: 0987654321
                                <br>Địa chỉ: 235 Đ. Nguyễn Văn Cừ, Phường Nguyễn Cư Trinh, Quận 1, Thành phố Hồ Chí Minh
                                <br>Chân thành cảm ơn!
                                </div> ";
                    $mail = new Mail();
                    $mail->booking($email, $title, $message);
                echo json_encode($result);
        break;
        
    case 'update':
                    $result = array();
                    $idBooking = $_GET['id'];
                    $dateOut = $_POST['dateOut'];
                    // Kiểm tra và cập nhật ngày trả phòng
                    $query = "UPDATE `tbl_booking` SET `dateOut`='$dateOut' WHERE id = '$idBooking'";
                    $success = $db->query($query);
                    $result['type'] = "success";
                    $result['message'] = "<b>Thành công!</b> Cập nhật ngày trả phòng thành công.";
                echo json_encode($result);
        break;
            
    case 'scam':
                    $result = array();
                    $cccd = check_input($_POST['cccd'], $db);
                    $idRe = check_input($_POST['idRe'], $db);
                    $db->query("UPDATE `tbl_rebooking` SET `status`='Đã hủy' WHERE id = '$idRe'");
                    $db->query("UPDATE `tbl_customers` SET `scam`=scam+1 WHERE id = '$cccd'");
                    $result['type'] = "success";
                    $result['message'] = "<b>Đã hủy!</b>";
                echo json_encode($result);
        break;

    case 'accept':
                    $result = array();
                    $cccd = check_input($_POST['cccd'], $db);
                    $idRe = check_input($_POST['idRe'], $db);
                    $dateIn = check_input($_POST['dateIn'], $db);
                    $dateOut = check_input($_POST['dateOut'], $db);
                    $idRoom = check_input($_POST['idRoom'], $db);
                    $priceRoom = check_input($_POST['priceRoom'], $db);
                    $employee = $data_user['id'];
                    $deal = ($priceRoom*50)/100;
                    $check = $db->num_rows("SELECT * FROM tbl_room r, tbl_booking bk 
                                            WHERE bk.status = 'Chưa thanh toán' AND bk.idRoom = r.id AND r.id = '$idRoom' 
                                            AND (dateIn = '$dateIn' OR dateout = '$dateOut') ");
                    if($check == 0){
                        $db->query("UPDATE `tbl_rebooking` SET `status`='Đã xác nhận' WHERE id = '$idRe'");
                        $db->query("INSERT INTO `tbl_booking`(`idCustomer`, `idRoom`, `dateIn`, `dateOut`,`status`,`idEmloyee`, `deal`, `priceRoom`)
                                    VALUES ('$cccd','$idRoom','$dateIn','$dateOut', 'Chưa thanh toán','$employee', '$deal', '$priceRoom')");
                        $result['type'] = "success";
                        $result['message'] = "<b>Đã xác nhận thành công!</b>";
                        $sql = "SELECT  email,  name FROM  tbl_customers  WHERE id = '$cccd' ";
                        $row = $db->fetch_assoc($sql, 1);
                        $name = $row['name'];
                        $email = $row['email'];
                        $title = "Đặt phòng thành - NIKKO Hotel";
                        $message = "<div>Cảm ơn bạn đã đặt phòng online tại NIKKO Hotel.
                                    <br>Chúc mừng khách hàng: " . $name. " đã xác nhận và chuyển khoản tiền cọc thành công!
                                    <br>Xin vui lòng đến nhận phòng đúng hẹn và xuất trình cccd/cmnd để được nhận phòng.
                                    <br>Chúc quý khách có một trải nghiệm tuyệt vời.
                                    <br>Thông tin liên hệ
                                    <br>Nếu bạn có bất kỳ câu hỏi hoặc cần thêm thông tin, vui lòng liên hệ chúng tôi qua:
                                    <br>Điện thoại: 0987654321
                                    <br>Địa chỉ: 235 Đ. Nguyễn Văn Cừ, Phường Nguyễn Cư Trinh, Quận 1, Thành phố Hồ Chí Minh
                                    <br>Chân thành cảm ơn!
                                    </div> ";
                        $mail = new Mail();
                        $mail->booking($email, $title, $message);
                    }
                    else
                    {
                        $result['type'] = "danger";
                        $result['message'] = "<b>Lỗi. </b>Phòng đang ở!";
                    }
                        
                    
                echo json_encode($result);
        break;
        case 'addproduct':
            $result = array();
            $idBooking = check_input($_POST['idBooking'], $db);
            $items = json_decode($_POST['items'], true); // Giải mã chuỗi JSON thành mảng
            $total = check_input($_POST['total'], $db);
            if (!empty($items)) { 
                $validQty = true; // Mặc định, giả sử số lượng hợp lệ
                foreach ($items as $item) {
                    $name = $item['name'];
                    $price = $item['price'];
                    $qty = $item['qty'];
                    $itemTotal = $item['itemTotal'];
                    $idItem = $item['idPro'];
                    $type= $item['type'];
        
                    if(empty($qty) || !is_numeric($qty) || $qty <= 0) {
                        $validQty = false; // Nếu có bất kỳ qty nào không hợp lệ, đặt biến $validQty thành false
                        break; // Dừng vòng lặp ngay khi gặp qty không hợp lệ
                    }
        
                    $check = $db->num_rows("SELECT * FROM `tbl_product` WHERE id = '$idItem' and qty >= $qty");
        
                    if ($check <= 0) {
                        // Nếu có ít nhất một sản phẩm trong danh sách không có đủ số lượng trong kho, đặt $validQty thành false
                        $validQty = false;
                        break; // Dừng vòng lặp ngay khi gặp số lượng không đủ
                    }
                }
        
                if ($validQty) {
                    // Sản phẩm đã được chọn và số lượng là hợp lệ, tiến hành lưu thông tin vào biến session
                    $sql="SELECT status FROM tbl_booking WHERE id = $idBooking";
                    $re = $db->fetch_assoc($sql, 1);
        
                    if($re['status'] =="Chưa thanh toán"){
                        foreach ($items as $item) {
                            $qty = $item['qty'];
                            $idItem = $item['idPro'];
                            $type= $item['type'];
                            $db->query("INSERT INTO `tbl_service`( `idBooking`, `qty`, `idPro`, `status`, `price`) VALUES ('$idBooking','$qty','$idItem', 0, '$price')");
                            if($type != 1){
                                $db->query("UPDATE `tbl_product` SET `qty`=`qty`- $qty  WHERE id = $idItem and status = '0'");
                            }
                        }
        
                        $result['type'] = "success";
                        $result['message'] = "Sản phẩm đã được thêm thành công!";
                    }
                    else{
                        $result['type'] = "danger";
                        $result['message'] = "Hóa đơn đã thanh toán!";
                    }
                } else {
                    $result['type'] = "danger";
                    $result['message'] = "Vui lòng kiểm tra số lượng và đảm bảo rằng có đủ số lượng trong kho!";
                }
            } else {
                $result['type'] = "danger";
                $result['message'] = "Vui lòng chọn ít nhất một sản phẩm!";
            }
            echo json_encode($result);
        break;
        
        
 
}
?>
