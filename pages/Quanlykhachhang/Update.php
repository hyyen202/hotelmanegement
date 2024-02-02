<div class="row">
    <div class="col col-12">
    <div id="result" class="mb-3"></div>
        <div class="card">
            <div class="card-header">
                Cập nhật thông tin khách hàng
            </div>
            <?php
                $id = $_GET['id'];
                $sql = "SELECT * FROM tbl_customers WHERE id = '$id'";
                foreach($db->fetch_assoc($sql,0) as $row){
             ?>
            <div class="card-body">
                <form id="new_form">
                    <div class="mb-3">
                        <label  class="form-label">Tên khách hàng</label>
                        <input type="text" class="form-control" id="name" value="<?php echo $row['name']; ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" id="phone" value="<?php echo $row['phone']; ?>">
                    </div>
                    
                    <div class="row">
                        <div class="col col-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="mail" value="<?php echo $row['email']; ?>" placeholder = "abc@gmai.com">
                            </div>
                        </div>
                        <div class="col col-6">
                            <div class="mb-3">
                                <label  class="form-label">Ngày sinh</label>
                                <?php
                                    // Tính toán ngày 18 tuổi trước ngày hiện tại
                                    $maxBirthday = date('Y-m-d', strtotime('-18 years'));
                                ?>
                                <input type="date" class="form-control" id="birthday" name="birthday" max="<?php echo $maxBirthday; ?>"
                                                    value="<?php echo $row['birthday']; ?>" required>
                            </div>
                        </div>
                    
                    </div>
                
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary" type="button" id="update">Cập nhật</button>
                    </div>
                </form>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<script>
  $(document).ready(function () {
   

    // Bắt sự kiện khi người dùng click vào button
    $('#update').click(function (e) {
        e.preventDefault();

        let name = $('#name').val(),
            phone = $('#phone').val(),
            email = $('#mail').val(),
            id = <?php echo $_GET['id'];?>,
            birthday = $('#birthday').val();

        let formData = new FormData();
        formData.append('name', name);
        formData.append('phone', phone);
        formData.append('email', email);
        formData.append('birthday', birthday);
        formData.append('id', id);

        $.ajax({
            url: 'pages/Quanlykhachhang/Action.php?act=update',
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
