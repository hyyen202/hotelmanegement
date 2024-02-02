<?php

$act = $_GET['page'];
switch ($act) {
    case 'new':
        // Thêm bài viết mới ở đây  
        include 'New.php';
        break;
    case 'features':
       //danh sách bài viết nổi bật
       include 'Features.php';
        break;
    case 'list':
    //   Đếm
        include 'List.php';
        break;
    case 'list_edit':
        //hiển thị danhh sách các bài biêts cần hiển thị
        include 'List_edit.php';
        break;
    case 'Booking':
        //hiển thị danhh sách các bài biêts cần hiển thị
        include 'Booking.php';
        break;
    case 'edit':
        // Sửa bài viết
        include 'Edit.php';
        break;

    case 'delete':
        // Xóa bài viết
        include 'Delete.php';
        break;
    default:
        // Báo lỗi
        break;
}
