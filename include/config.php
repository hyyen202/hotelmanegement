<?php
error_reporting(0); // display error : E_ALL
date_default_timezone_set('Asia/Ho_Chi_Minh');
define('BASEURL', 'http://localhost/');
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','quanly');
define('SITE_NAME','Do an');
define('CUR_DATE', date("Y-m-d H:i:s"));
define('LIMIT_ROW', 5);
define('LIVE_COOKIE', 30);
$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
// echo "<script>console.log('Import Config !!')</script>";
