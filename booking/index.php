<?php
require_once('../include/init.php');
  $title = SITE_NAME;

include 'pages/layout/Header.php';
$Controller = $_GET['controller'];
switch ($Controller) {
    
    case '':
        include 'pages/Home.php';
        break;
    case 'blog':
        include 'pages/blog/Home.php';
        break;
    case 'content':
        include 'pages/Content/detail.php';
        break;
    case 'booking':
        include 'pages/booking/Home.php';          
        break;
    default:
            include '../pages/layout/NotFound.php';
        break;
}

include '../pages/layout/Footer.php';

