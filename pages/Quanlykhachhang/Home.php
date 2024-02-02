<?php
include('../../include/init.php');
    if (isset($_GET['act'])) {
        $act = $_GET['act'];
       
        switch ($act) {
            case 'add':
                    include 'pages/Quanlykhachhang/Add.php';
                break;
            case 'list':
                    include 'pages/Quanlykhachhang/List.php';
                break;
            case 'update':
                    include 'pages/Quanlykhachhang/Update.php';
                break;
            case 'history':
                if (!isset($_GET['id'])) {
                    include 'pages/Quanlykhachhang/List.php';
                } else if(isset($_GET['id'])) {
                    include 'pages/Quanlykhachhang/History.php';
                } else {
                    include 'pages/layout/NotFound.php';
                }
                break;
            case 'bill':
                    include 'pages/Quanlykhachhang/Bill.php';
                break;
            case '':
                    include 'pages/layout/NotFound.php';
                break;
            default:
                include include 'pages/layout/NotFound.php';
                break;
        }
    }                  

?>