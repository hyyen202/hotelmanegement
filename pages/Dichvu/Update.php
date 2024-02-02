<div class="card shadow mb-4">
            <div class="row">
                <div class="col col-12">
                
                <div id="result" class="mb-3"></div>
                <!-- Hết thông báo -->
                    <div class="card">
                        <div class="card-header">
                            Cập nhật sản phẩm
                        </div>
                        <div class="card-body">
                            <form id="spend_form">
                                <?php 
                                if(isset($_GET['id'])){
                                    $id = $_GET['id'];
                                    $sql = "SELECT * FROM tbl_product WHERE id = '$id'";
                                    $re = $db->fetch_assoc($sql, 1);

                                }

                                ?>
                                
                                <div class="mb-3">
                                    <label class="form-label">Sản phẩm</label>
                                    <input type="text" class="form-control" id="name" name = "name" value="<?php echo $re['name']?>">
                                    <input type="text" class="form-control" id="idPro" name = "idPro" value="<?php echo $re['id']?>" hidden>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Số lượng</label>
                                    <input type="number" class="form-control" id="qty" name="qty" min = "1" value="<?php echo $re['qty']?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Giá</label>
                                    <input type="number" class="form-control" id="price" name="price" value="<?php echo $re['price']?>">
                                </div>
                                <div class="mb-3">
                                    <label for="role" class="form-label">Trạng thái</label>
                                    <select id="status" name="status" class="form-control">
                                        <option value="Còn hàng" <?php if($re['status'] == 'Còn hàng') echo 'selected'; ?>>Còn hàng</option>
                                        <option value="Hết hàng" <?php if($re['status'] == 'Hết hàng') echo 'selected'; ?>>Hết hàng</option>
                                    </select>
                                </div>
                
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button class="btn btn-primary" type="button" id="clear_now">Nhập lại</button>
                                    <button class="btn btn-primary" type="button" id="update">Thêm</button>
                                </div>
                            </form>
                        </div>
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
    $('#update').click(function (e) {
        e.preventDefault();

        let name = $('#name').val(),
            price = $('#price').val(), 
            idPro = $('#idPro').val(), 
            status = $('#status').val(), 
            qty = $('#qty').val();
          
       
        let formData = new FormData();
        formData.append('name', name);
        formData.append('price', price);
        formData.append('status', status);
        formData.append('qty', qty);
        formData.append('idPro', idPro);

        $.ajax({
            url: 'pages/Dichvu/Action.php?act=update',
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
                    window.setTimeout(function() {
                            window.location.href="index.php?controller=service";
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
