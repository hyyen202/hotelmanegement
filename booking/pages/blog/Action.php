<?php
include('../../include/init.php');

$act = $_GET['act'];
switch ($act) {
    case 'new':
            $user_id    = $data_user['id'];
            // Thêm bài viết mới ở đây
            $title      = check_input($_POST['title'], $db);
            $content    = check_input($_POST['content'], $db);
            $categories = check_input($_POST['categories'], $db);
            $tags       = check_input($_POST['tags'], $db);   
            $img = $_FILES['img']['name']; // Tên tệp hình ảnh
            $img_tmp = $_FILES['img']['tmp_name']; // Đường dẫn tạm thời của tệp
            
            // Xử lý và lưu tệp hình ảnh vào thư mục cần lưu
            $target_dir = "../assets/images/"; // Thư mục đích
            $target_file = $target_dir . basename($img);
             $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            // Kiểm tra định dạng tệp ảnh
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo "Chỉ cho phép tệp JPG, JPEG, PNG, GIF.";
                $uploadOk = 0;
            }
            // Di chuyển tệp từ thư mục tạm thời đến thư mục đích
             move_uploaded_file($img_tmp, $target_file);
            
        
            //  Check bài viết đã tồn tại hay chưa
            $check      = $db->num_rows("SELECT * FROM `tbl_posts` WHERE title = '$title'");
            //  Check rỗng dùng !$tile hoặc empty($title) hoặc !(isset($title)) hoặc strlen($title) hoặc $title !=''
            if(!$title || !$content || !$categories){
                $result['type']     = "danger";
                $result['message']  = "<b>Thất bại!</b> Vui lòng điền đầy đủ thông tin!!";
            }elseif($check > 0){ 
                $result['type']     = "danger";
                $result['message']  = "<b>Thất bại!</b> Bài viết đã tồn tại !!";
            }else{
                $result['type']     = "success";
                $result['message']  = "<b>Thành công!</b> Bạn đã đăng thành công";
                $time = time();
                
                $db->query("INSERT INTO `tbl_posts`(`id_user`, `title`, `content`, `categories`, `tags`, `time`, `img`) VALUES ('$user_id', '$title', '$content', '$categories', '$tags', '$time', '$img')");
            }
            echo json_encode($result);
        break;
    case 'load':
       // Load danh sách bài viét
        break;
    case 'edit':
            $user_id = $data_user['id'];
            $id = $_POST['id'];
            $title = $_POST['title'];
            $content = $_POST['content'];
            $categories = $_POST['categories'];
            $tags = $_POST['tags'];
    
            if (!$title || !$content || !$categories) {
                $result['type'] = "danger";
                $result['message'] = "<b>Thất bại!</b> Vui lòng điền đầy đủ thông tin!!";
            } else {
                $time = time();
                $db->query("UPDATE `tbl_posts` SET `id_user`='$user_id',`title`='$title',`content`='$content',`categories`='$categories',`tags`='$tags',`time`='$time' WHERE id = '$id'");
                $result['type'] = "success";
                $result['message'] = "<b>Thành công!</b> Bạn đã cập nhật bài viết thành công";
            }
    
            echo json_encode($result); // Trả về kết quả
         break;
         case 'del':
            // Xóa bài viết
            $id = $_POST['id'];
            $db->query("DELETE FROM `tbl_posts` WHERE id = $id");
            $result['type'] = "success";
            $result['message'] = "<b>Thành công!</b> Bạn đã xóa bài viết thành công";
            echo json_encode($result); // Trả về kết quả
            break;

    
    default:
        // Báo lỗi
        // Trường hợp không xác định, có thể trả về thông báo lỗi
        $result['type'] = "danger";
        $result['message'] = "Hành động không xác định";

        echo json_encode($result); // Trả về kết quả
        break;
        break;
}
