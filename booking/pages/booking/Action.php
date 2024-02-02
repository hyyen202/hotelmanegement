<?php
include('../../../include/init.php');
require('../../../pages/BaocaoMail/Send.php');
$act = $_GET['act'];

switch ($act) {
    case 'booking':
        $result = array();

        // Validate and sanitize input data
        $email = check_input($_POST['email'], $db);
        $name = check_input($_POST['name'], $db);
        $phone = check_input($_POST['phone'], $db);
        $birthday = check_input($_POST['birthday'], $db);
        $cccd = check_input($_POST['cccd'], $db);
        $room = check_input($_POST['idRoom'], $db);
        $dateIN = check_input($_POST['dateIN'], $db);
        $dateOut = check_input($_POST['dateOut'], $db);

        // Check for missing required fields
        if (empty($cccd) || empty($name) || empty($phone) || empty($birthday) || empty($dateIN) || empty($dateOut)) {
            $result['type'] = "danger";
            $result['message'] = "<b>Thất bại!</b> Vui lòng điền đầy đủ thông tin";
        } else {
            // Check if the customer already exists
            $check = $db->num_rows("SELECT * FROM `tbl_customers` WHERE id = '$cccd'");
            $checkdate = $db->num_rows("SELECT * FROM tbl_booking
                            WHERE status = 'Chưa thanh toán'
                            AND idRoom = '$room'
                            AND ('$dateIN' BETWEEN dateIn AND dateOut
                            OR '$dateOut' BETWEEN dateIn AND dateOut)");

            if ($check > 0) {
                $result['type'] = "danger";
                $result['message'] = "<b>Đã tồn tại thông tin!</b> Vui lòng chọn đã có tài khoản";
            } elseif ($checkdate >= 1) {
                $result['type'] = "danger";
                $result['message'] = "<b>Thất bại!</b> Phòng đã có người đặt vào khoảng thời gian này! Vui lòng chọn ngày khác!";
            } else {
                // Successful booking
                $result['type'] = "success";
                $result['message'] = "<b>Thành công!</b> Vui lòng kiểm tra mail để biết thêm chi tiết";
                $time = CUR_DATE;

                // Insert customer information
                $db->query("INSERT INTO `tbl_customers`(`id`, `name`, `phone`, `birthday`, `email`)
                            VALUES ('$cccd','$name','$phone','$birthday','$email')");
                // Retrieve price for the room
                $sqli = "SELECT price FROM tbl_room WHERE id = '$room'";
                $re = $db->fetch_assoc($sqli, 1);
                $priceRoom = $re['price'];

                // Insert booking information
                $db->query("INSERT INTO `tbl_rebooking`(`idCustomer`, `idRoom`, `dateIn`, `dateOut`, `status`, `timebook`, `priceRoom`)
                            VALUES ('$cccd','$room','$dateIN','$dateOut', 'Chưa duyệt','$time', '$priceRoom')");

                // Retrieve price for the room
                $sql = "SELECT re.priceRoom as price, DATEDIFF(dateOut, dateIn)  as day  FROM tbl_room r, tbl_rebooking re 
                        WHERE re.idRoom = r.id AND re.idCustomer = '$cccd' AND re.status = 'Chưa duyệt'";
                $row = $db->fetch_assoc($sql, 1);

                    $day = $row['day'];
                    $deal = (($row['price']*$day) * 50) / 100;
                
                    $title = "Xác nhận đặt phòng - NIKKO Hotel";
                    $message = "<div>Cảm ơn bạn đã đặt phòng online tại NIKKO Hotel. Đây là thông tin về đơn đặt phòng của bạn:
                                <br>Mã khách hàng: " . $cccd . "
                                <br>Ngày nhận phòng: " . $dateIN . "
                                <br>Ngày trả phòng: " . $dateOut . "
                                <br>Tên phòng: " . $room . "
                                <br>Giá phòng: " . number_format($row['price']) . "đ/ngày
                                <br>Xin vui lòng chuyển khoản trước số tiền " . $deal . "(50% số tiền tính theo ngày trả và ngày nhận phòng) 
                                    tới tài khoản sau để xác nhận:
                                <br>Tên ngân hàng: JneBank
                                <br>Tên tài khoản: NIKKO Hotel
                                <br>Số tài khoản:  6868686868
                                <br>Nội dung chuyển: Khach hang " . $cccd . "- phong " . $room . " " . date(' d/m', strtotime($dateIN)) . " " . date(' d/m', strtotime($dateOut)) . "
                                <br>Xin vui lòng thực hiện chuyển khoản trong vòng 24h kể từ ngày nhận email này để đảm bảo đơn đặt phòng của bạn được xác nhận.
                                <br>Thông tin liên hệ
                                <br>Nếu bạn có bất kỳ câu hỏi hoặc cần thêm thông tin, vui lòng liên hệ chúng tôi qua:
                                <br>Điện thoại: 0987654321
                                <br>Địa chỉ: 235 Đ. Nguyễn Văn Cừ, Phường Nguyễn Cư Trinh, Quận 1, Thành phố Hồ Chí Minh
                                <br>Chân thành cảm ơn!
                                </div> ";
                    $mail = new Mail();
                    $mail->booking($email, $title, $message);

            }
        }

        // Return JSON response
        echo json_encode($result);
        break;

    case 'booking_exist':
        $result = array();
        $cccd = check_input($_POST['cccd'], $db);
        $room = check_input($_POST['idRoom'], $db);
        $dateIN = check_input($_POST['dateIN'], $db);
        $dateOut = check_input($_POST['dateOut'], $db);

        if (empty($cccd) || empty($dateIN) || empty($dateOut)) {
            $result['type'] = "danger";
            $result['message'] = "<b>Thất bại!</b> Vui lòng điền đầy đủ thông tin";
        } else {
            $check = $db->num_rows("SELECT * FROM `tbl_customers` WHERE id = '$cccd'");
            $checkdate = $db->num_rows("SELECT * FROM tbl_booking
                            WHERE status = 'Chưa thanh toán'
                            AND idRoom = '$room'
                            AND ('$dateIN' BETWEEN dateIn AND dateOut
                            OR '$dateOut' BETWEEN dateIn AND dateOut)");

            $checkScam = $db->num_rows("SELECT * FROM `tbl_customers` WHERE scam >= 3 AND id = '$cccd'");

            if ($check == 0) {
                $result['type'] = "danger";
                $result['message'] = "<b>Thất bại!</b> Tài khoản không tồn tại vui lòng chuyển sang chưa có tài khoản";
            } elseif ($checkScam) {
                $result['type'] = "danger";
                $result['message'] = "<b>Cảnh báo!</b> Bạn đã bị cấm do không nhận phòng quá nhiều lần! Vui lòng liên hệ nhân viên để giải quyết";
            } else {
                $result['type'] = "success";
                $result['message'] = "<b>Thành công!</b> Vui lòng kiểm tra mail để biết thêm chi tiết";
                $time = CUR_DATE;
                 // Retrieve price for the room
                 $sqli = "SELECT price FROM tbl_room WHERE id = '$room'";
                 $re = $db->fetch_assoc($sqli, 1);
                 $priceRoom = $re['price'];
 
                 // Insert booking information
                $db->query("INSERT INTO `tbl_rebooking`(`idCustomer`, `idRoom`, `dateIn`, `dateOut`, `status`, `timebook`, `priceRoom`)
                             VALUES ('$cccd','$room','$dateIN','$dateOut', 'Chưa duyệt','$time', '$priceRoom')");

                $sql = "SELECT re.priceRoom as price, email, DATEDIFF(dateOut, dateIn)  as day FROM tbl_room r, tbl_rebooking re, tbl_customers c
                        WHERE re.idRoom = r.id and re.idCustomer = '$cccd' and re.status = 'Chưa duyệt' and c.id = re.idCustomer";

                $row = $db->fetch_assoc($sql, 1);
               
                $price = $row['price'];
                $email = $row['email'];
                $day = $row['day'];
                $deal = (($price*$day)*50)/100;
                $title = "Xác nhận đặt phòng - NIKKO Hotel";
                $message = "<div>Cảm ơn bạn đã đặt phòng online tại NIKKO Hotel. Đây là thông tin về đơn đặt phòng của bạn:
                            <br>Mã khách hàng: " . $cccd . "
                            <br>Ngày nhận phòng: " . $dateIN . "
                            <br>Ngày trả phòng: " . $dateOut . "
                            <br>Tên phòng: " . $room . "
                            <br>Giá phòng: " . number_format($price) . "đ/ngày
                            <br>Xin vui lòng chuyển khoản trước số tiền ".$deal."(50% số tiền tính theo ngày trả và ngày nhận phòng) 
                                tới tài khoản sau để xác nhận:
                            <br>Tên ngân hàng: JneBank
                            <br>Tên tài khoản: NIKKO Hotel
                            <br>Số tài khoản:  6868686868
                            <br>Nội dung chuyển: Khach hang " . $cccd . "- phong " . $room . " " . date(' d/m', strtotime($dateIN)) . " " . date(' d/m', strtotime($dateOut)) . "
                            <br>Xin vui lòng thực hiện chuyển khoản trong vòng 24h kể từ ngày nhận email này để đảm bảo đơn đặt phòng của bạn được xác nhận.
                            <br>Thông tin liên hệ
                            <br>Nếu bạn có bất kỳ câu hỏi hoặc cần thêm thông tin, vui lòng liên hệ chúng tôi qua:
                            <br>Điện thoại: 0987654321
                            <br>Địa chỉ: 235 Đ. Nguyễn Văn Cừ, Phường Nguyễn Cư Trinh, Quận 1, Thành phố Hồ Chí Minh
                            <br>Chân thành cảm ơn!
                            </div> ";
                $mail = new Mail();
                $mail->booking($email, $title, $message);
              
            }
        }
        // Return JSON response
        echo json_encode($result);
        break;

    case 'rate':
        $result = array();
        $cccd = check_input($_POST['cccd'], $db);
        $room = check_input($_POST['idRoom'], $db);
        $ct = check_input($_POST['ct'], $db);
        $numrate = check_input($_POST['numrate'], $db);

        if (empty($cccd)) {
            $result['type'] = "danger";
            $result['message'] = "<b>Thất bại!</b> Vui lòng điền thông tin CCCD/CMND";
        } else {
            // Fetching the results of the first query
            $check ="SELECT  COUNT(*) as pay
                                 FROM tbl_customers ctm
                                 JOIN tbl_booking bk ON ctm.id = bk.idCustomer
                                 JOIN tbl_room r ON r.id = bk.idRoom
                                 JOIN tbl_bill bill ON bill.idBooking = bk.id
                                 WHERE ctm.id = '$cccd' AND r.id = '$room'
                                 GROUP BY ctm.id";
            $checkResult = $db->fetch_assoc($check, 1);

            // Fetching the results of the second query
            $checkRate = $db->num_rows("SELECT rate.* FROM tbl_customers ctm, tbl_room r, tbl_rate rate
                                        WHERE ctm.id = rate.idCustomer and r.id = rate.idRoom and
                                         ctm.id = '$cccd' AND r.id = '$room' AND rate.id");

            // Adjust the condition based on the actual structure of your data
            if ($checkResult['pay'] <= 0 || $checkRate >= $checkResult['pay']) {
                $result['type'] = "danger";
                $result['message'] = "<b>Thất bại!</b> Tài khoản chưa đủ quyền để đánh giá phòng này";
            }  else {
                $time = CUR_DATE;
                $db->query("INSERT INTO `tbl_rate`(`idCustomer`, `idRoom`, `content`, `rating`, `dateRating`) VALUES ('$cccd','$room','$ct','$numrate', '$time')");
                $result['type'] = "success";
                $result['message'] = "<b>Đánh giá thành công!</b> Cảm ơn bạn đã cho Nikko Hotel biết được trải nghiệm của bạn. \nXin chân thành cảm ơn!";
            }
        }

        // Return JSON response
        echo json_encode($result);
        break;
}
?>
