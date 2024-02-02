<?php
include('../../include/init.php');
    if (isset($_GET['act'])) {
        $act = $_GET['act'];
       
        switch ($act) {
            
            case 'report':
                    include 'pages/BaocaoMail/Report.php';
                break;
            case 'listreport':
                    include 'pages/BaocaoMail/ListReport.php';
                break;
            case 'mail':
                if (is_admin($data_user)) {
                    include 'pages/BaocaoMail/Mail.php';
                } else {
                    include '../pages/layout/NotFound.php';
                }
                break;
            default:
                include 'pages/Quanlyvanhanh/Action.php';
                break;
        }
    }

?>