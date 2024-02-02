<div class="row">
    <div class="col col-12">
      
    <div id="result" class="mb-3"></div>
    <!-- Hết thông báo -->
        <div class="card">
            <div class="card-header">
                Thêm chi tiêu
            </div>
            <div class="card-body">
                <form id="spend_form">
                    <div class="mb-3">
                        <label  class="form-label">Mã số nhân viên</label>
                        <input type="text" class="form-control" id="id" value="<?php echo $data_user['id'].' - '.$data_user['fullname'];?>" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Sản phẩm đã chi:</label>
                        <input type="text" class="form-control" id="name" placeholder="Nhập tên sản phẩm">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số lượng</label>
                        <input type="number" class="form-control" id="number" name="number" min = "1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giá</label>
                        <input type="number" class="form-control" id="price" name="price">
                    </div>
    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary" type="button" id="clear_now">Nhập lại</button>
                        <button class="btn btn-primary" type="button" id="add">Thêm</button>
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
        $("#spend_form")[0].reset();
    });

    // Bắt sự kiện khi người dùng click vào button
    $('#add').click(function (e) {
        e.preventDefault();

        let name = $('#name').val(),
            price = $('#price').val(), // Xóa dấu phẩy ngăn cách hàng nghìn nếu có
            number = $('#number').val();
          
       
        let formData = new FormData();
        formData.append('name', name);
        formData.append('price', price);
        formData.append('number', number);

        $.ajax({
            url: 'pages/Quanlychitieu/Action.php?act=add',
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
                    $("#spend_form")[0].reset();
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
});

</script>
