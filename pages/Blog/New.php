<div class="row">
    <div class="col col-12">
        <!-- Chổ này hiện thị thông báo nè -->
    <div id="result" class="mb-3"></div>
    <!-- Hết thông báo -->
        <div class="card">
            <div class="card-header">
                Đăng bài Viết
            </div>
            <div class="card-body">
                <form id="new_form">
                    <div class="mb-3">
                        <label for="title" class="form-label">Tên bài viết</label>
                        <input type="text" class="form-control" id="title" placeholder="Nhập tên bài viết">
                    </div>
                    <div class="mb-3">
                            <div class="col-lg-6 ">
                                <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                                    <input id="img" type="file" name ="img"  class="form-control border-0">
                                    <div class="input-group-append">
                                        <label for="upload" class="btn btn-light m-0 rounded-pill px-4">
                                            <i class="fa fa-cloud-upload mr-2 text-muted"></i>
                                            
                                            <small class="text-uppercase font-weight-bold text-muted">Chọn Hình Ảnh</small>
                                           
                                        </label>
                                    </div>
                                    
                                </div>

                            </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="content" class="form-label">Nội dung</label>
                        <textarea class="form-control" id="nd" rows="3" placeholder="Nhập nội dung"></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col col-6">
                            <div class="mb-3">
                                <label for="categories" class="form-label">Chuyên mục</label>
                                <input type="text" class="form-control" id="categories" placeholder="Nhập chuyên mục">
                            </div>
                        </div>
                        <div class="col col-6">
                            <div class="mb-3">
                                <label for="tags" class="form-label">Tags</label>
                                <input type="text" class="form-control" id="tags" placeholder="Nhập Tags: abc, xyz, hello,....">
                            </div>
                        </div>
                    
                    </div>
                
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary me-md-2" type="button" id="clear_now">Nhập lại</button>
                        <button class="btn btn-primary" type="button" id="posts">Đăng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#posts').click(function (e) {
    e.preventDefault();

    let title = $('#title').val(),
        nd = $('#nd').val(),
        categories = $('#categories').val(),
        tags = $('#tags').val();
    let img = $('#img')[0].files[0];

    if (img) { // Kiểm tra xem có tệp hình ảnh đã chọn hay chưa
        let formData = new FormData();
        formData.append('title', title);
        formData.append('nd', nd);
        formData.append('categories', categories);
        formData.append('tags', tags);
        formData.append('img', img);

        $.ajax({
            url: 'pages/blog/Action.php?act=new',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                // Xử lý kết quả
            },
            error: function (error) {
                console.log(error);
            },
            success: function (response) {
                let res = JSON.parse(response);

                $('#result').html(`<div class="alert alert-${res.type}" role="alert">${res.message}</div>`);
                $('#result').fadeIn('slow', function () {
                    $('#result').delay(5000).fadeOut();
                });
                if (res.type == "success") {
                    $("#new_form")[0].reset();
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    } else {
        // Hiển thị thông báo lỗi khi không có hình ảnh được chọn
        $('#result').html('<div class="alert alert-danger" role="alert">Vui lòng chọn một hình ảnh!</div>');
        $('#result').fadeIn('slow', function () {
            $('#result').delay(5000).fadeOut();
        });
    }
});

</script>
