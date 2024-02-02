<?php

  //----------------------------------------------//
 //      CODE LIÊN QUAN ĐẾN XỬ LÝ HỆ THỐNG       //
//----------------------------------------------// 

// Người dùng không được vô
function isnt_user(){
    if($_SESSION['user'] != ""){
        require '././pages/layout/NotFound.php';
        require '././pages/layout/Footer.php';
        // header("Location:/");
        exit();
    }    
}

// Chỉ người dùng mới vô được
function is_user(){
    if($_SESSION['user'] == ""){
        require '././pages/layout/NotFound.php';
        require '././pages/layout/Footer.php';
        // header("Location:/");
        exit();
    }    
}
// Kiểm tra xem người dùng có quyền admin hay không
function is_admin($data_user){
    return $data_user['role'] == 1;
}



/// chống hack / sqli & xss


function check_input($str, $db){
   return htmlspecialchars($db->escape_string(strip_tags(trim($str))));
}

  //------------------------------------------//
 //      CODE LIÊN QUAN ĐẾN XỬ LÝ CHUỖI      //
//------------------------------------------//

// Hàm chuyển đổi chuỗi tiếng việt có dấu $str, trả về chuỗi không dấu
function convert_vn2latin($str)
{
    // Mảng các ký tự tiếng việt không dấu theo mã unicode tổ hợp
    $tv_unicode_tohop  =
        [
            "à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă", "ằ","ắ","ặ","ẳ","ẵ",
            "è","é","ẹ","ẻ","ẽ","ê","ề" ,"ế","ệ","ể","ễ",
            "ì","í","ị","ỉ","ĩ",
            "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ" ,"ò","ớ","ợ","ở","õ",
            "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
            "ỳ","ý","ỵ","ỷ","ỹ",
            "đ",
            "À","À","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă" ,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
            "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
            "Ì","Í","Ị","Ỉ","Ĩ",
            "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ" ,"Ờ","Ớ","Ợ","Ở","Ỡ",
            "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
            "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
            "Đ"
        ];
    // Mảng các ký tự tiếng việt không dấu theo mã unicode dựng sẵn   
    $tv_unicode_dungsan  =
        [
            "à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ","ặ","ẳ","ẵ",
            "è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ",
            "ì","í","ị","ỉ","ĩ",
            "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ","ờ","ớ","ợ","ở","ỡ",
            "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
            "ỳ","ý","ỵ","ỷ","ỹ",
            "đ",
            "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă","Ằ","Ắ","Ặ","Ẳ","Ẵ",
            "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
            "Ì","Í","Ị","Ỉ","Ĩ",
            "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ","Ờ","Ớ","Ợ","Ở","Ỡ",
            "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
            "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
            "Đ"
        ];
    // Mảng các ký không dấu sẽ thay thế cho ký tự có dấu
    $tv_khongdau =
        [
            "a","a","a","a","a","a","a","a","a","a","a" ,"a","a","a","a","a","a",
            "e","e","e","e","e","e","e","e","e","e","e",
            "i","i","i","i","i",
            "o","o","o","o","o","o","o","o","o","o","o","o" ,"o","o","o","o","o",
            "u","u","u","u","u","u","u","u","u","u","u",
            "y","y","y","y","y",
            "d",
            "A","A","A","A","A","A","A","A","A","A","A","A" ,"A","A","A","A","A",
            "E","E","E","E","E","E","E","E","E","E","E",
            "I","I","I","I","I",
            "O","O","O","O","O","O","O","O","O","O","O","O" ,"O","O","O","O","O",
            "U","U","U","U","U","U","U","U","U","U","U",
            "Y","Y","Y","Y","Y",
            "D"
        ];

    $str = str_replace($tv_unicode_dungsan, $tv_khongdau, $str);
    $str = str_replace($tv_unicode_tohop,   $tv_khongdau, $str);
    return $str;
}

function UrlNormal($str)
{
    // Chuyển tiếng việt không dấu
    $str = convert_vn2latin($str);
    // chuyển sang in thường
    $str = mb_strtolower($str);
    // Giữ lại các ký tự chữ a - z và số 0 - 9 còn lại thay bằng -
    $str = preg_replace('/[^a-z0-9]/', '-', ($str));
    $str = preg_replace('/[--]+/', '-', $str);
    $str = trim($str, '-');
    return $str;
}

//  Giống trên nhưng ngắn hơn
function convert_vi_to_en($str) {
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", "i", $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str);
    $str = preg_replace("/(đ)/", "d", $str);
    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str);
    $str = preg_replace("/(Đ)/", "D", $str);
    $str = str_replace(" ", "-", str_replace("&*#39;","",$str));
    return $str;
}

// Kiểm tra một chuỗi có chứa chuỗi con hoặc chuỗi khác hay không
// Cách 1
// if (strlen(strstr($chuoi_ban_dau, $chuoi_con)) > 0) {
//     // Tìm thấy
// }
// Cách 2
// $pos = strpos($chuoi_ban_dau, $chuoi_con);
// if ($pos !== false) {
// //Tìm thấy
// } else {
// // Không tìm thấy
// }




  //----------------------------------------------//
 //      CODE LIÊN QUAN ĐẾN XỬ LÝ THỜI GIAN      //
//----------------------------------------------//


// Lấy thời gian hiện tại và định dạng d/m/Y
function nowTime(){
	return date('H:i:s d/m/Y', time());
}


// Lấy số tuần từ ngày tháng
function getWeekNumber($ddate){
	$date = new DateTime($ddate);
	return $date->format("W");
}

// Chuyển đổi phút sang giờ và phút
function convertToHoursMins($time, $format = '%02d:%02d') {
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}

// Lấy khoảng thời gian giữa 2 ngày
function dateDiff($date1, $date2){
    $datetime1 = new DateTime($date1);
    $datetime2 = new DateTime($date2);
    $interval = $datetime1->diff($datetime2);
    return $interval->format('%H:%I');
}

// Kiểm tra ngày được chỉ định là quá khứ hay tương lai
// if(strtotime(dateString) > time()) {
//     # Tương lai
// }

// if(strtotime(dateString) < time()) {
//     # Quá khứ
// }

// if(strtotime(dateString) == time()) {
//     #  Hiện tại
// }

// So sánh ngày tháng
// $today = date("Y-m-d");
// $another_date = "2011-08-16";
// if (strtotime($today) > strtotime($another_date)) {
// echo "Yesterday";
// } else {
// echo "Tomorrow";
// }

// Cộng trừ ngày tháng
// $today = date('Y-m-d');
// echo "Today is ". $today;
// // Cộng thêm 1 tuần
// $week = strtotime(date("Y-m-d", strtotime($today)) . " +1 week");
// $week = strftime("%Y-%m-%d", $week);
// echo "A week later is ". $week;
// // Cộng thêm 1 tháng
// $month = strtotime(date("Y-m-d", strtotime($today)) . " +1 month");
// $month = strftime("%Y-%m-%d", $month);
// echo "A month later is ". $month; 

// Tính tuổi
function age($date){
    $time = strtotime($date);
    if($time === false){
      return '';
    }
 
    $year_diff = '';
    $date = date('Y-m-d', $time);
    list($year,$month,$day) = explode('-',$date);
    $year_diff = date('Y') - $year;
    $month_diff = date('m') - $month;
    $day_diff = date('d') - $day;
    if ($day_diff < 0 || $month_diff < 0) $year_diff;
 
    return $year_diff;
}

// Hiển thị thời gian dưới dạng "time ago"
// hiển thị thời gian đẹp mắt hơn như là "1 giờ trước" (1 hour ago) hay "2 ngày trước" (2 days ago) giống các mạng xã hội hiện nay đang sử dụng
function ago($tm,$rcs = 0) {
    $cur_tm = time(); $dif = $cur_tm-$tm;
    $pds = array('second','minute','hour','day','week','month','year','decade');
    $lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
    for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);
 
    $no = floor($no); if($no <> 1) $pds[$v] .='s'; $x=sprintf("%d %s ",$no,$pds[$v]);
    if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
    return $x;
}

// Đếm ngược đến ngày nào đó
// $dt_end = new DateTime('December 3, 2016 2:00 PM');
// $remain = $dt_end->diff(new DateTime());
// echo $remain->d . ' days and ' . $remain->h . ' hours';

/*
// Lấy thứ từ ngày bất kỳ
function DayOfWeek($datetime = new DateTime(), $type = null){
    if($type == "long"){
        $week = array("Chủ Nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư ", "Thứ Năm ", "Thứ Sáu ", "Thứ Bảy ");
    }elseif($type == "normal"){
        $week = array("Chủ Nhật", "Thứ 2", "Thứ 3", "Thứ 4 ", "Thứ 5 ", "Thứ 6 ", "Thứ 7 ");
    }else{
        $week = array("CN", "T2", "T3", "T4 ", "T5 ", "T6 ", "T7 ");
    }
    $w = (int)$datetime->format('w');
    $day_of_week = $week[$w];
    return $day_of_week;
}

// Xem ngày thuộc tuần thứ mấy trong năm ?
function WeeksOfYear($date = new DateTime()){
    // $date = date('Y-m-d');
    while (date('w', strtotime($date)) != 1) {
    $tmp = strtotime('-1 day', strtotime($date));
    $date = date('Y-m-d', $tmp);
    }
    $week = date('W', strtotime($date));
    return $week ;
}
*/

  //----------------------------------------------//
 //      CODE LIÊN QUAN ĐẾN XỬ LÝ THIẾT BỊ       //
//----------------------------------------------//
// Thì khi sử dụng biến $_SERVER, chúng ta sẽ thu được các kết quả tương ứng như sau
// $_SERVER['HTTP_HOST'] => tên miền
// $_SERVER['PHP_SELF'] => /@forum/showthread.php ( path sau tên miền)
// $_SERVER['REQUEST_TIME'] => Thời gian mà client gửi request ở dạng TIME _STAMP
// $_SERVER['QUERY_STRING'] => t = 2053  ( ALL VALUE GET )
// $_SERVER['DOCUMENT_ROOT'] = Thư mục gốc chứa mã nguồn. VD: /home/domain/public_html (đối với Linux) hay C:\www (đối với windows)
// $_SERVER['HTTP_REFERER'] = Cái này bạn đang trên http://www.google.com.vn/search?q=domain mà click vào link tới domain thì nó có giá trị http://www.google.com.vn/search?q=domain
// $_SERVER['REMOTE_HOST'] = Hostname của người truy cập
// $_SERVER['REMOTE_PORT'] = Port mà trình duyệt mở ra để kết nối tới server
// $_SERVER['REQUEST_URI'] => /@forum/showthread.php?t=2053
// $_SERVER['SERVER_NAME'] = Tên của server (Gần giống với computer-name) ở máy PC của mình. Ví dụ KHOIPC
// $_SERVER['SERVER_ADDR'] = IP của server
// $_SERVER['REMOTE_ADDR'] = IP của người truy cập
// $_SERVER['HTTP_USER_AGENT'] = Thông tin về trình duyệt của người truy cập

// Kiểm tra người dùng sử dụng điện thoại hay máy tính
function check_isMobile() {
    $is_mobile = '0';
    if(preg_match('/(android|iphone|ipad|up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
    $is_mobile=1;
    if((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE']))))
    $is_mobile=1;
    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
    $mobile_agents = array('w3c ','acs-','alav','alca','amoi','andr','audi','avan','benq','bird','blac','blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno','ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-','maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-','newt','noki','oper','palm','pana','pant','phil','play','port','prox','qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar','sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-','tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp','wapr','webc','winw','winw','xda','xda-');
    
    if(in_array($mobile_ua,$mobile_agents))
    $is_mobile=1;
    
    if (isset($_SERVER['ALL_HTTP'])) {
    if (strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini')>0)
    $is_mobile=1;
    }
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows')>0)
    $is_mobile=0;
    return $is_mobile;
}

// Lấy đường dẫn URL của trang hiện tại
function getCurrentPageURL() {
    $pageURL = 'http';
    if (!empty($_SERVER['HTTPS'])) {
    if ($_SERVER['HTTPS'] == 'on') {
    $pageURL .= "s";
    }
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
    $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
    $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}
