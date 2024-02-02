
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div id="result" class="mb-3"></div>
        <div class="card">
            <div class="card-header">
                <center>Quên mật khẩu</center>
            </div>
            <div class="card-body">
                <form id="forgot_form">
                    <div class="form-group mb-3">
                        <label for="username" class="form-label">Tên đăng nhập</label>
                        <input type="text" class="form-control" id="username" placeholder="Nhập tên đăng nhập">
                    </div>
                    <div class="form-group mb-3 text-center">
                        <button class="btn btn-primary" name="submit" id="forgot"> Khôi phục</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>
<script>
    document.title = "Đăng nhập | <?=SITE_NAME?>" ;
</script>
<script>
        $(document).ready(function () {
            // Bắt sự kiện khi người dùng click vào button
             $('#forgot').click(function (e) {
                 // Ngăn không cho load lại trang
                 e.preventDefault();
                 //Lấy giá trị của 2 ô input
                 let username = $('#username').val();
                 $.ajax({
                    url: 'pages/authenticate/Action.php?act=forgot',
                    type: 'POST',
                    data: {
                        username
                    },
                     // Nếu thành công thì hiển thị kết quả ra trình duyệt
                     success: function (response) {
                        let res = JSON.parse(response);
                        $('#result').html(`<div class="alert alert-${res.type}" role="alert">${res.message}</div>`);
                        $('#result').fadeIn('slow', function(){
                            $('#result').delay(5000).fadeOut();
                        });
                        if(res.type == "success"){
                            $("#forgot_form")[0].reset();
                            window.setTimeout(function(){
                                //Chuyển trang qua trang chủ
                                window.location.href = "/";
                            }, 4500);
                        }
                     },
                     error: function (error) {
                        console.log(error);
                     }
                 });
             });
        });
    </script>