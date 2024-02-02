<?php
require_once('./include/init.php');
$title = SITE_NAME;

include 'pages/layout/Header.php';
if(isset($data_user)){

include "pages/layout/Menu.php";

$Controller = $_GET['controller'];
//Cần thêm 1 đoạn js để hiển thị cần phải đănng nhập khi muốn thực hiện chức năng
switch ($Controller) {
    
    case '':
        include 'pages/Home.php';
        break;

    case 'register':
          if(is_admin($data_user)){
                include 'pages/authenticate/Register.php';
            }else{
                include 'pages/layout/NotFound.php';
            }
        break;

    case 'login':
            is_user();
            include 'pages/authenticate/Login.php';
        break;

    case 'quanlykhachhang':
            include 'pages/Quanlykhachhang/Home.php';
        break;

    case 'quanlyvanhanh':
           
            include 'pages/Quanlyvanhanh/Home.php';
        break;

    case 'quanlychitieu':
           
            include 'pages/Quanlychitieu/Home.php';
        break;

    case 'quanlyphong':
            is_admin($data_user);
            include 'pages/Quanlyphong/Home.php';
        break;
    case 'update':
            include 'pages/authenticate/Update.php';
        break;

    case 'change':
            is_user();
            include 'pages/authenticate/Change.php';
        break;

    case 'baocaomail':
            include 'pages/BaocaoMail/Home.php';
        break;
    case 'logout':
            is_user();
            include 'pages/authenticate/Logout.php';
        break;

    case 'user':
        if(is_admin($data_user)){
            include 'pages/authenticate/List_User.php';
        }else{
            include 'pages/layout/NotFound.php';
        }
        break;
    case 'update_user':
            is_admin($data_user);
            include 'pages/authenticate/Update.php';
        break;
    case 'thongke':
            is_admin($data_user);
            include 'pages/Thongke/Home.php';
        break;
    case 'revenue':
            is_admin($data_user);
            include 'pages/Revenue/Home.php';
        break;
    case 'service':
        if(is_admin($data_user)){
            include 'pages/Dichvu/Home.php';
        }else{
            include 'pages/layout/NotFound.php';
        }
        break;
    case 'update_service':
            if(is_admin($data_user)){
                include 'pages/Dichvu/Update.php';
            }else{
                include 'pages/layout/NotFound.php';
            }
        break;
    case 'delete_user':
            is_admin($data_user);
            include 'pages/authenticate/Delete.php';
        break;
    case 'blog':
            if(is_admin($data_user)){
                include 'pages/Blog/Home.php';
            }else{
                include 'pages/layout/NotFound.php';
            }
        break;
    /*case 'Bill_Export':
            is_admin($data_user);
            include 'pages/Bill_Export/Export_pdf.php';
        break;
        */

    default:
            include 'pages/layout/NotFound.php';
        break;
}
}
else{
    include 'pages/authenticate/Login.php';
}

include 'pages/layout/Footer.php';

