<?php
include('../../include/init.php');
    if (isset($_GET['act'])) {
        $act = $_GET['act'];
       
        switch ($act) {
            
            case 'add':
                if (is_admin($data_user)) {
                    include 'pages/Quanlyphong/Add.php';
                } else {
                    include 'pages/layout/NotFound.php';
                }
                break;
            case 'update':
                if (is_admin($data_user)) {
                    include 'pages/Quanlyphong/List.php';
                } else {
                    include 'pages/layout/NotFound.php';
                }
                break;
            case 'edit':
                if (is_admin($data_user)) {
                    include 'pages/Quanlyphong/Edit.php';
                } else {
                    include 'pages/layout/NotFound.php';
                }
                break;
            
             default:
                    include 'pages/layout/NotFound.php';
                break;
    
            
        }
    }

?>