<div class="row">
    <div class="col col-12">
      
    <div id="result" class="mb-3"></div>
    <!-- Hết thông báo -->
        <div class="card">
            <div class="card-header">
                Thêm khách hàng
            </div>
            <div class="card-body">
                <form id="new_form">
                    <div class="mb-3">
                        <label  class="form-label">Tên khách hàng</label>
                        <input type="text" class="form-control" id="name" placeholder="Nhập tên">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">CCCD/CMND</label>
                        <input type="text" class="form-control" id="id" placeholder="Nhập CCCD hoặc CMND">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" id="birthday" name="birthday">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="name@example.com" maxlength="32">
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary" type="button" id="clear_now">Nhập lại</button>
                        <button class="btn btn-primary" type="button" id="posts">Thêm</button>
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
            id = $('#id').val(),
            birthday = $('#birthday').val(),
            email = $('#email').val(),
            phone = $('#phone').val();

        let formData = new FormData();
        formData.append('name', name);
        formData.append('id', id);
        formData.append('birthday', birthday);
        formData.append('email', email);
        formData.append('phone', phone);

        $.ajax({
            url: 'pages/Quanlykhachhang/Action.php?act=add',
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
