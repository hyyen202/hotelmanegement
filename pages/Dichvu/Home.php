 <!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Dịch vụ</h1>
<!-- DataTales Example -->
<div class="row">
        <div class="card shadow mb-4 col-8">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Sản phẩm</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                                <th>STT</th>
                                <th>ID</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Trạng thái</th>
                                <th>Tùy biến</th>
                               

                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sql = "SELECT * FROM tbl_product ";
                                $re = $db->fetch_assoc($sql,0);
                                $i = 1;
                                foreach($re as $row){
                            
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['price']; ?></td>
                                <td><?php echo $row['qty']; ?></td>
                                <td><?php
                                        if($row['qty']<1){
                                            echo 'Tạm hết';
                                        }else
                                        {
                                            echo $row['status']; 
                                        }
                                    ?>
                                 </td>
                                <td><a href="index.php?controller=update_service&id=<?php echo $row['id'];?>">Cập nhật</a></td>
                                
                            </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card shadow mb-4 col-4">
            <div class="row">
                <div class="col col-12">
                
                <div id="result" class="mb-3"></div>
                <!-- Hết thông báo -->
                    <div class="card">
                        <div class="card-header">
                            Thêm sản phẩm
                        </div>
                        <div class="card-body">
                            <form id="spend_form">
                                
                                <div class="mb-3">
                                    <label class="form-label">Sản phẩm</label>
                                    <input type="text" class="form-control" id="name" placeholder="Nhập tên sản phẩm">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Số lượng</label>
                                    <input type="number" class="form-control" id="qty" name="qty" min = "1">
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
        </div>
</div>
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
<i class="fas fa-angle-up"></i>
</a>

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
            price = $('#price').val(), 
            qty = $('#qty').val();
          
       
        let formData = new FormData();
        formData.append('name', name);
        formData.append('price', price);
        formData.append('qty', qty);

        $.ajax({
            url: 'pages/Dichvu/Action.php?act=add',
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
