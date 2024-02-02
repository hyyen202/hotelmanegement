<?php
include('../../include/init.php');

$act = $_GET['act'];
switch ($act) {
    case 'form':
        include 'pages/booking/Form.php';
        break;
    case 'home':
        include 'pages/booking/Room.php';
        break;
    case 'detail':
        include 'pages/booking/Detail.php';
        break;
}
?>