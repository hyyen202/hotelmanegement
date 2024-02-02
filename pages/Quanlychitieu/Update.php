<div class="row">
    <div class="col col-12">
      
    <div id="result" class="mb-3"></div>
    <!-- Hết thông báo -->
        <div class="card">
            <div class="card-header">
                Cập nhật chi tiêu
            </div>
            <?php 
                $id = $_GET['id'];
                $sql = "SELECT * FROM tbl_spend WHERE id = $id";
                foreach($db->fetch_assoc($sql,0) as $row)
                {

                ?>
            <div class="card-body">
                <form id="new_form">
                    <div class="mb-3">
                        <label  class="form-label">Mã số nhân viên</label>
                        <input type="text" class="form-control" id="id" value="<?php echo $data_user['id'].' - '.$data_user['fullname'];?>" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Sản phẩm đã chi:</label>
                        <input type="text" class="form-control" id="name" value="<?php echo $row['product'];?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số lượng</label>
                        <input type="number" class="form-control" id="number" name="number" value="<?php echo $row['number'];?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giá</label>
                        <input type="number" class="form-control" id="price" name="price" value="<?php echo $row['price'];?>">
                    </div>
    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary" type="button" id="clear_now_btn">Nhập lại</button>
                        <button class="btn btn-primary" type="button" id="posts">Thêm</button>
                    </div>
                </form>
            </div> <?php }?>
        </div>
    </div>
</div>

<script>
  $(document).ready(function () {
    $('#clear_now_btn').click(function (e) {
        // Ngăn không cho load lại trang
        e.preventDefault();
        // reset form
        $("#new_form")[0].reset();
    });

    // Bắt sự kiện khi người dùng click vào button
    $('#posts').click(function (e) {
        e.preventDefault();

        let name = $('#name').val(),
            price = $('#price').val(),
            number = $('#number').val();
            id = <?php echo $_GET['id'];?>
          
       
        let formData = new FormData();
        formData.append('name', name);
        formData.append('price', price);
        formData.append('number', number);
        formData.append('id', id);

        $.ajax({
            url: 'pages/Quanlychitieu/Action.php?act=update',
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
