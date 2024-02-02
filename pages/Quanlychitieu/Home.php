<?php
include('../../include/init.php');
    if (isset($_GET['act'])) {
        $act = $_GET['act'];
       
        switch ($act) {
            
            case 'add':
                    include 'pages/Quanlychitieu/Add.php';
                    break;
                
            case 'list':
                    include 'pages/Quanlychitieu/List.php';
                break;
            case 'update':
                if (is_admin($data_user)) {
                    include 'pages/Quanlychitieu/Update.php';
                } else {
                    include 'pages/layout/NotFound.php';
                }
                break;
            default:
                include 'pages/Quanlyvanhanh/Action.php';
                break;
        }
    }

?>