<?php
include('../../include/init.php');

$act = $_GET['act'];
switch ($act) {
    case 'detail':
        include 'pages/content/detail.php';
        break;
    case 'load':
       // Load danh sách bài viét
        break;
    case 'count':
    //   Đếm
        break;
    case 'get':
        // Lấy danh sách
        break;
    case 'del':
        // Xóa bài viết
        break;

    case 'test':
        // Xóa bài viết
        break;
    default:
        // Báo lỗi
        break;
}
