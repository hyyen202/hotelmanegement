<div class="row">
    <div class="col col-12">
        <!-- Chổ này hiện thị thông báo nè -->
    <div id="result" class="mb-3"></div>
    <!-- Hết thông báo -->
        <div class="card">
            <div class="card-header">
                Thêm phòng
            </div>
            <div class="card-body">
                <form id="new_form">
                    <div class="mb-3">
                        <label  class="form-label">Tên Phòng</label>
                        <input type="text" class="form-control" id="name" placeholder="Nhập tên">
                    </div>
                    <div class="mb-3">
                            <div class="col-lg-6 ">
                                <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                                    <input id="img" type="file"  class="form-control border-0">
                                    <div class="input-group-append">
                                        <label  class="btn btn-light m-0 rounded-pill px-4">
                                            <i class="fa fa-cloud-upload mr-2 text-muted"></i>
                                            <small class="text-uppercase font-weight-bold text-muted">Chọn Hình Ảnh</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Loại phòng</label>
                                <input type="text" class="form-control" id="type" placeholder="Nhập loại phòng...">
                    </div>
                    
                    <div class="row">
                        <div class="col col-6">
                            <div class="mb-3">
                                <label class="form-label">Giá</label>
                                <input type="number" class="form-control" id="price" placeholder="Nhập giá...">
                            </div>
                        </div>
                        <div class="col col-6">
                            <div class="mb-3">
                                <label  class="form-label">Ghi chú</label>
                                <input type="text" class="form-control" id="note" placeholder="Nhập ghi chú...">
                            </div>
                        </div>
                    
                    </div>
                
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary" type="button" id="posts">Đăng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
  $(document).ready(function () {
    $('#clear_now').click(function (e) {
        // Ngăn không cho load lại trang
        e.preventDefault();
        // reset form
        $("#new_form")[0].reset();
    });

    // Bắt sự kiện khi người dùng click vào button
    $('#posts').click(function (e) {
        e.preventDefault();

        let name = $('#name').val(),
            type = $('#type').val(),
            price = parseFloat($('#price').val()),
            note = $('#note').val();
        let formData = new FormData();
        formData.append('name', name);
        formData.append('type', type);
        formData.append('price', price);
        formData.append('note', note);
        formData.append('img', $('#img')[0].files[0]); // Lấy tệp hình ảnh
        $.ajax({
            url: 'pages/Quanlyphong/Action.php?act=add',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                let res = JSON.parse(response);
                $('#result').html(`<div class="alert alert-${res.type}" role="alert">${res.message}</div>`);
                $('#result').fadeIn('slow', function(){
                    $('#result').delay(5000).fadeOut();
                });
                if(res.type == "success"){
                    $("#new_form")[0].reset();
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
});

</script>
