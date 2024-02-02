<?php
include('../../include/init.php');
    if (isset($_GET['act'])) {
        $act = $_GET['act'];
       
        switch ($act) {
            case 'revenue':
                if (is_admin($data_user)) {
                    include 'pages/Thongke/TKDoanhthu.php'; } 
                else {
                    include 'pages/layout/NotFound.php';
                }
                break;
            case 'spend':
                if (is_admin($data_user)) {
                    include 'pages/Thongke/TKChitieu.php';
                }else {
                    include 'pages/layout/NotFound.php';
                }
                break;
            case 'room':
                if (is_admin($data_user)) {
                    include 'pages/Thongke/TKPhong.php';
                }else {
                    include 'pages/layout/NotFound.php';
                }
                break;
            default:
                    include 'pages/layout/NotFound.php';
                break;
        }
    }

?>