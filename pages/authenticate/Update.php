<div class="col-md-6" style="margin:auto">
    <div class="card">
        <?php
            $id = $_GET['id'];
            $sql = "SELECT * FROM tbl_user WHERE id = '$id'";
            $re = $db->fetch_assoc($sql, 1);
        ?>
        <div class="card-header">
            <center>Cập nhật thông tin</center>
        </div>
       
        <div class="card-body">
            <div id="result"></div>
            <form id="change-form">
                <div class="form-group mb-3">
                    <label for="username" class="form-label">Tên đăng nhập</label>
                    <input type="text" class="form-control" id="username" value="<?=$re['username']?>" disabled>
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Địa chỉ Email</label>
                    <input type="text" class="form-control" id="email" value="<?=$re['email']?>" disabled>
                </div>
                <div class="form-group mb-3">
                    <label for="fullname" class="form-label">Họ & tên</label>
                    <input type="text" class="form-control" id="fullname" value="<?=$re['fullname']?>">
                </div>
                <div class="form-group mb-3">
                    <label for="role" class="form-label">Trạng thái</label>
                    <select id="role" name="role" class="form-control">
                        <option value="0" <?php if($re['role'] == 0) echo 'selected'; ?>>Nhân viên</option>
                        <option value="1" <?php if($re['role'] == 1) echo 'selected'; ?>>Admin</option>
                        <option value="2" <?php if($re['role'] == 2) echo 'selected'; ?>>Nghỉ làm</option>
                    </select>
                </div>
                <div class="form-group mb-3 text-center">
                    <button class="btn btn-primary" name="submit" id="update"> Cập nhật</button>
                </div>
            </form>
            
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Bắt sự kiện khi người dùng click vào button
        $('#update').click(function (e) {
            e.preventDefault();

            let fullname = $('#fullname').val();
            let role = $('#role').val();
            let id = <?php echo $_GET['id'];?>;

            let formData = new FormData();
            formData.append('fullname', fullname);
            formData.append('id', id);
            formData.append('role', role);

            $.ajax({
                url: 'pages/authenticate/Action.php?act=change_info',
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
                    if (res.type == "success") {  
                        window.setTimeout(function () {
                        // Chuyển trang qua trang cập nhật danh sách phòng
                        window.location.href = "index.php?controller=user";
                    }, 1500);
                
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    });
</script>
