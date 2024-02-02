<div class="row">
    <div class="col col-12">
        <!-- Chổ này hiện thị thông báo nè -->
        <?php
        $id = $_GET['id'];
        $sql = "SELECT * FROM tbl_posts WHERE id = $id";

        foreach($db->fetch_assoc($sql, 0) as $row) ?>
            
    <div id="result" class="mb-3"></div>
    <!-- Hết thông báo -->
        <div class="card">
            <div class="card-header">
                Cập nhật bài Viết
            </div>
            <div class="card-body">
                <form id="update_form">
                <div class="mb-3">
                     
                        <input type="hidden"  id="id" value="<?php echo $row['id'] ?>" placeholder="Nhập tiêu đề">
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Tên bài viết</label>
                        <input type="text" class="form-control" id="title" value="<?php echo $row['title'] ?>" placeholder="Nhập tiêu đề">
                    </div>
                   
                    
                    <div class="mb-3">
                        <label for="content" class="form-label">Nội dung</label>
                        <textarea class="form-control" id="content" rows="3" placeholder="Nhập nội dung"><?php echo $row['content']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Hình ảnh: (*) </label>
                        <input type="text" class="form-control" id="img" readonly value="<?php echo $row['img'] ?>">
                    </div>
                    
                    <div class="row">
                        <div class="col col-6">
                            <div class="mb-3">
                                <label for="categories" class="form-label">Chuyên mục</label>
                                <input type="text" class="form-control" id="categories" placeholder="Nhập chuyên mục" value="<?php echo $row['categories'];?>">
                            </div>
                        </div>
                        <div class="col col-6">
                            <div class="mb-3">
                                <label for="tags" class="form-label">Tags</label>
                                <input type="text" class="form-control" id="tags" placeholder="Nhập Tags: abc, xyz, hello,...." value="<?php echo $row['tags'];?>">
                            </div>
                        </div>
                    
                    </div>
                
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary me-md-2" type="button" id="cancel">Hủy</button>
                        <button class="btn btn-primary" type="button" id="update">Cập nhật</button>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label" style="color: #3333333; font-size: 14px;">(*) Không được phép chỉnh sửa</label>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function () {
    // Lưu lại giá trị ban đầu của các trường
    const initialData = {
        id : $('#id').val(),
        title: $('#title').val(),
        content: $('#content').val(),
        categories: $('#categories').val(),
        tags: $('#tags').val()
    };

    $('#cancel').click(function (e) {
        window.setTimeout(function () {
            //Chuyển trang qua trang chủ
            window.location.href = "index.php";
        }, 1500);
    });

    $('#update').click(function (e) {
        e.preventDefault();
        let  id = $('#id').val(),
            title = $('#title').val(),
            content = $('#content').val(),
            categories = $('#categories').val(),
            tags = $('#tags').val();

        // Kiểm tra xem dữ liệu có thay đổi so với giá trị ban đầu hay không
        if (title !== initialData.title || content !== initialData.content || categories !== initialData.categories || tags !== initialData.tags) {
            $.ajax({
                url: 'pages/blog/Action.php?act=edit',
                type: 'POST',
                data: {
                    id,
                    title,
                    content,
                    categories,
                    tags
                },
                success: function (response) {
                    let res = JSON.parse(response);
                    $('#result').html(`<div class="alert alert-${res.type}" role="alert">${res.message}</div>`);
                    $('#result').fadeIn('slow', function () {
                        $('#result').delay(5000).fadeOut();
                    });
                    if (res.type === "success") {
                       
                        window.setTimeout(function () {
                            // Chuyển trang qua trang chủ
                            window.location.href = "index.php";
                        }, 1500);
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        } else {
            // Hiển thị thông báo cho người dùng rằng không có thay đổi để cập nhật
            $('#result').html(`<div class="alert alert-info" role="alert">Không có thay đổi để cập nhật</div>`);
            $('#result').fadeIn('slow', function () {
                $('#result').delay(2000).fadeOut();
            });
        }
    });
});
</script>