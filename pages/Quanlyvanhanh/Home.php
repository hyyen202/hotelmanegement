<?php
include('../../include/init.php');
    if (isset($_GET['act'])) {
        $act = $_GET['act'];
       
        switch ($act) {
            case 'status':
                include 'pages/Quanlyvanhanh/Status.php';
                break;
            case 'total':
                include 'pages/Quanlyvanhanh/Total.php';
                break;
            case 'list':
                include 'pages/Quanlyvanhanh/List.php';
                break;
            case 'product':
                include 'pages/Quanlyvanhanh/AddProduct.php';
                break;
            case 'add':
                if (is_admin($data_user)) {
                    include 'pages/Quanlyvanhanh/Add.php';
                } else {
                    include 'pages/layout/NotFound.php';
                }
                break;
            case 'booking':
                    include 'pages/Quanlyvanhanh/Booking.php';
               
                break;
            case 'del':
                if (is_admin($data_user)) {
                    include 'pages/Quanlyvanhanh/List_UD.php';
                } else {
                    include 'pages/layout/NotFound.php';
                }
                break;
            case 'update':
                include 'pages/Quanlyvanhanh/UpdateRoom.php';
                break;
            case 'accept':
                include 'pages/Quanlyvanhanh/Accept.php';
                break;
            default:
                include 'pages/Quanlyvanhanh/Action.php';
                break;
        }
    }

?>