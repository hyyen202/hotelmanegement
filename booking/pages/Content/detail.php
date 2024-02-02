<?php
$id = $_GET['id'];
if(isset($id)){
    $db->query("UPDATE `tbl_posts` SET `views`=`views`+ 1 WHERE id = $id");
}
$sql = "SELECT * FROM tbl_posts WHERE id = $id";
$re = $db->fetch_assoc($sql, 1);

if ($re) {
    // Lấy nội dung bài viết
    $content = $re['content'];
    // Tách thành từng từ
    $words = explode(" ", $content);
    // Lấy chữ cái đầu tiên của từ đầu tiên
    $firstWord = substr($words[0], 0, 1);
    // Chữ cái đầu tiên được in đậm
    $words[0] = "<span class='first-letter-bold'>$firstWord</span>" . substr($words[0], 1);
    // Gán nội dung sau khi thay đổi lại
    $content = implode(" ", $words);
?>

<div class="jumbotron p-0 text-white bg-dark position-relative d-flex justify-content-center align-items-center h-100" style="margin: auto;">
    <img src="../assets/images/<?php echo $re['img']; ?>" alt="Ảnh bài viết" class="w-100 wallpaper">
    <div class="jumbotron-text position-absolute top-0 start-0 p-3" >
        <h1 class="display-4 " style="background-color: #ffffff99; color: #333; font-weight: bold; font-size: 3rem; white-space: normal; margin: 4%; margin-right: 5%; padding: 1rem;"><?php echo $re['title']; ?></h1>
    </div>
</div>
<div class="content-container" style="border: 1px solid #ccc; padding: 20px;">
    <div class="content row">
        <div class="col-8" style="ont-family:Verdana, Geneva, Tahoma, sans-serif; box-sizing: border-box; font-size:18px; border: 1px solid #ccc;
                                    border-radius: 4px;"> <?php echo $content; ?> </div>

        <div class="product_meta col-4" >
            <div style="ont-family:Verdana, Geneva, Tahoma, sans-serif; box-sizing: border-box; font-size:18px;">Type: <?php echo $re['categories']; ?> </div>
            <div  style="ont-family:Verdana, Geneva, Tahoma, sans-serif; box-sizing: border-box; font-size:18px;">Hashtag: <?php echo $re['tags']; ?> </div>
            <div  style="ont-family:Verdana, Geneva, Tahoma, sans-serif; box-sizing: border-box; font-size:18px;">View: <?php echo $re['views']; ?> </div>
            <div  style="ont-family:Verdana, Geneva, Tahoma, sans-serif; box-sizing: border-box; font-size:18px;">Time: <?php echo date(' d/m/Y', strtotime($re['time'])); ?> </div>
        </div>

     
    </div>
</div>

<?php
} else {
    echo "Không tìm thấy dữ liệu.";
}
?>
