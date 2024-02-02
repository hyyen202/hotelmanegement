<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
class Mail{
public function booking($emailKH, $title, $message){

  $mail = new PHPMailer(true);
  $mail->CharSet ="UTF-8";

  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username='nttan2100400@student.ctuet.edu.vn';//your mail
  $mail->Password='uifygbwtldkjomsw'; //Your gmail
  $mail->SMTPSecure = 'ssl';
  $mail->Port=465;

  $mail->setFrom('nttan2100400@student.ctuet.edu.vn'); // Your gmail

  $mail->addAddress($emailKH);

  $mail->isHTML(true);

  $mail->Subject = $title;
  $mail->Body = $message;
  
  $mail->send();
}
}

if(isset($_POST["send"])){
  $mail = new PHPMailer(true);

  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username='nttan2100400@student.ctuet.edu.vn';//your mail
  $mail->Password='uifygbwtldkjomsw'; //Your gmail
  $mail->SMTPSecure = 'ssl';
  $mail->Port=465;

  $mail->setFrom('nttan2100400@student.ctuet.edu.vn'); // Your gmail

  $mail->addAddress($_POST["email"]);

  $mail->isHTML(true);

  $mail->Subject = $_POST["subject"];
  $mail->Body = $_POST["message"];
  $mail->SMTPDebug = 2; // hoặc 3 để có thêm thông tin
  $mail->Debugoutput = 'html'; // hiển thị thông báo lỗi dưới dạng HTML

  
  $mail->send();
  
  echo
  "
  <script>
     alert('Đã gửi thành công');
     document.location.href = '../../index.php'
  </script>
  
  ";
}
?> 
