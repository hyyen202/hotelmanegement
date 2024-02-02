
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div id="result" class="mb-3"></div>
        <div class="card">
            <div class="card-header">
                <center>Đăng ký tài khoản nhân viên</center>
            </div>
            <div class="card-body">
                <form id="register_form">
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Địa chỉ Email</label>
                        <input type="email" class="form-control" id="email" placeholder="name@example.com" maxlength="32">
                    </div>
                    <div class="form-group mb-3">
                        <label for="username" class="form-label">Họ & Tên</label>
                        <input type="text" class="form-control" id="fullname" placeholder="Nhập họ & tên" maxlength="32">
                    </div>
                    <div class="form-group mb-3">
                        <label for="username" class="form-label">Tên đăng nhập</label>
                        <input type="text" class="form-control" id="username" placeholder="Nhập tên đăng nhập" maxlength="8">
                    </div>

                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" placeholder="Nhập mật khẩu" maxlength="14">
                    </div>

                    <div class="form-group mb-3">
                        <label for="re-password" class="form-label">Xác nhận mật khẩu</label>
                        <input type="password" class="form-control" id="re-password" placeholder="Xác nhận mật khẩu" maxlength="14">
                    </div>

                    <div class="form-group mb-3 text-center">
                    <button class="btn btn-primary" name="submit" id="register"> Đăng ký</button>
                    </div>
                    
                </form>
               
            </div>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>



<script>
    document.title = "Đăng ký tài khoản | <?=SITE_NAME?>" ;
</script>
<script>
        $(document).ready(function () {
            // Bắt sự kiện khi người dùng click vào button
             $('#register').click(function (e) {
                 // Ngăn không cho load lại trang
                 e.preventDefault();
                 //Lấy giá trị của 2 ô input
                 let email = $('#email').val(),
                     fullname = $('#fullname').val(),
                     username = $('#username').val(),
                     password = $('#password').val(),
                     repassword = $('#re-password').val();
                 // Gửi request
                 $.ajax({
                    url: 'pages/authenticate/Action.php?act=register',
                     type: 'POST',
                    data: {
                        email,
                        fullname,
                        username,
                        password,
                        repassword
                    },
                     // Nếu thành công thì hiển thị kết quả ra trình duyệt
                     success: function (response) {
                        let res = JSON.parse(response);
                        $('#result').html(`<div class="alert alert-${res.type}" role="alert">${res.message}</div>`);
                        $('#result').fadeIn('slow', function(){
                            $('#result').delay(5000).fadeOut();
                        });
                        if(res.type == "success"){
                            $("#register_form")[0].reset();
                            
                        }
                     },
                     error: function (error) {
                        console.log(error);
                     }
                 });
             });
        });
    </script>