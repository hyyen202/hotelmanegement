<div class="row">
    <div class="col col-12">
        <!-- Chỗ này hiển thị thông báo nè -->
        <div id="result" class="mb-3"></div>
        <!-- Hết thông báo -->
        <div class="card">
            <div class="card-header">
                Đặt phòng
            </div>

            <div class="card-body">
                <?php
                $id = $_GET['id'];
                $sql = "SELECT * FROM tbl_room WHERE id = '$id'";
                $re = $db->fetch_assoc($sql, 0);
                foreach ($re as $row) { ?>
                    <form id="new_form">
                        <div class="mb-3">
                            <label class="form-label">Tên Phòng</label>
                            <input type="text" class="form-control" id="room" value="<?php echo $row['id'] ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Loại phòng</label>
                            <input type="text" class="form-control" id="type" value="<?php echo $row['type'] ?>" readonly>
                        </div>

                        <div class="row">
                            <div class="col col-6">
                                <div class="mb-3">
                                    <label class="form-label">Giá phòng cho một đêm</label>
                                    <input type="number" class="form-control" id="price" value="<?php echo $row['price'] ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">CCCD/CMND</label>
                                    <input type="number" class="form-control" id="id" name="id" placeholder="Nhập cccd/cmnd khách hàng...">
                                </div>
                            </div>
                            <div class="col col-6">
                                <div class="mb-3">
                                    <label class="form-label">Ngày thuê</label>
                                    <input type="date" class="form-control" id="dateIN" name="dateIN" min="<?php echo date('Y-m-d'); ?>"
                                     <?php  
                                     /*
                                        if(isset($query['dateIn']&$query['monthIn'])or($query['dateOut']&$query['monthOut'])){
                                                  echo 'readonly';  
                                        } */
                                    ?>>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ngày trả</label>
                                    <input type="date" class="form-control" id="dateOut" name="dateOut" min="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                           
                            <button class="btn btn-primary" type="button" id="posts">Đặt phòng</button>
                        </div>
                    </form>
                <?php }
                   

                ?>
            </div>
        </div>
    </div>
</div>

<script>
   $(document).ready(function () {
    $('#dateIN').change(function () {
    var selectedDateIN = new Date($('#dateIN').val());

   // Kiểm tra xem selectedDateIN có hợp lệ không
        if (!isNaN(selectedDateIN.getTime())) {
            // Tạo một bản sao của ngày thuê và cộng thêm 1 ngày
            var minDateOut = new Date(selectedDateIN);
            minDateOut.setDate(minDateOut.getDate() + 1);

            // Định dạng ngày và gán cho trường Ngày trả
            var formattedMinDateOut = minDateOut.toISOString().slice(0, 10);
            $('#dateOut').attr('min', formattedMinDateOut);
            
            // Tạo một bản sao khác của ngày thuê và cộng thêm một số ngày khác
            var maxDateOut = new Date(selectedDateIN);
            maxDateOut.setDate(maxDateOut.getDate() + 60);  // số ngày tối đa bạn muốn cho phép

            // Định dạng ngày và gán cho trường Ngày trả
            var formattedMaxDateOut = maxDateOut.toISOString().slice(0, 10);
            $('#dateOut').attr('max', formattedMaxDateOut);
        } else {
            console.error('Ngày thuê không hợp lệ');
        }

    });

    $('#posts').click(function (e) {
        e.preventDefault();

        let room = $('#room').val(),
            type = $('#type').val(),
            price = $('#price').val(),
            id = $('#id').val(),
            dateOut = $('#dateOut').val(),
            dateIN = $('#dateIN').val();

        let formData = new FormData();
        formData.append('room', room);
        formData.append('type', type);
        formData.append('price', price);
        formData.append('id', id);
        formData.append('dateOut', dateOut);
        formData.append('dateIN', dateIN);

        $.ajax({
            url: 'pages/quanlyvanhanh/Action.php?act=booking',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                try {
                    let res = JSON.parse(response);
                    $('#result').html(`<div class="alert alert-${res.type}" role="alert">${res.message}</div>`);
                    $('#result').fadeIn('slow', function () {
                        $('#result').delay(5000).fadeOut();
                    });
                    if (res.type == "success") {
                        window.setTimeout(function() {
                            window.location.href="index.php?controller=quanlyvanhanh&act=list";
                        }, 1500);
                    }
                } catch (e) {
                    console.log('Lỗi phân tích JSON:', e);
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
});

</script>
