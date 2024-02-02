<?php

/// lấy các biến, data
require_once("config.php");
// Kết nối database 
require_once("database.php");

//IMPORT thư viện
require_once ('Session.php');
require_once ('Functions.php');
require_once ('Pagination.php');

// kết nối mới đến database
$db = new DB();
$db->connect();
$db->set_char('utf8mb4');

// Khởi tạo session
$session = new Session();
$session->start();

// Kim tra session
if ($session->get() != '') {
    $user = $session->get();
} else {
    $user = '';
}

/// Get info User 
$sqlu = "SELECT * FROM tbl_user where username = '$user' limit 1";
if ($db->num_rows($sqlu)) {
    $data_user = $db->fetch_assoc($sqlu, 1);
}

//function count booking online
function countBK($db){
    $sql = "SELECT COUNT(*) as count FROM tbl_rebooking WHERE status='Chưa duyệt'";
    $result = $db->fetch_assoc($sql, 1);
    if ($result) {
        return $result['count'];
    } else {
        return 0; 
    }
}
//function count booking online
function countRP($db){
    $sql = "SELECT COUNT(*) as count FROM tbl_report WHERE status=0 ORDER BY id desc limit 6";
    $result = $db->fetch_assoc($sql, 1);
    if ($result) {
        return $result['count'];
    } else {
        return 0; 
    }
}

//function select all
function selectRoom($db){
    $sql="SELECT COUNT(*) as countroom FROM tbl_room";
    $result = $db->fetch_assoc($sql,1);
    if($result){
        return $result['countroom'];
    }
    else{
        return 0;
    }
}
//function sum revenue in month
function selectRevenue($db, $cur_month){
    $sql="SELECT SUM(total) as revenue FROM tbl_bill WHERE month(dateCheckout) = $cur_month ";
    $result = $db->fetch_assoc($sql,1);
    if($result){
        return $result['revenue'];
    }
    else{
        return 0;
    }
}
//funtion count product

function countPro($db){
    $sql="SELECT COUNT(*) as pro FROM tbl_product";
    $result = $db->fetch_assoc($sql,1);
    if($result){
        return $result['pro'];
    }
    else{
        return 0;
    }
}
//funtion count luot thue

function countLuotThue($db, $id){
    $sql="SELECT COUNT(idRoom) as count FROM tbl_booking bk, tbl_room r WHERE r.id = bk.idRoom and r.id = '$id'";
    $result = $db->fetch_assoc($sql,1);
    if($result){
        return $result['count'];
    }
    else{
        return 0;
    }
}
   



   
    


//echo "<script>console.log('Import Init !!')</script>";

?>