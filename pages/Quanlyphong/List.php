<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <p class="mb-4">Danh sách phòng</p>
    <!-- DataTales Example -->
    <div id="result" class="mb-3"></div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary" >Danh sách phòng</h6>
        </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered"  id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Phòng</th>
                                <th>Loại</th>
                                <th>Giá</th>
                                <th>Ghi chú</th>
                                <th>Trạng thái</th>
                                <th>Tùy biến</th>
                                <th>Tùy biến</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM tbl_room";
                            $re = $db->fetch_assoc($sql, 0);
                            $i = 1;
                            foreach ($re as $row) {
                            ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['type']; ?></td>
                                    <td><?php echo number_format($row['price']).'đ'; ?></td>
                                    <td><?php echo $row['note']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td>
                                        <a href="index.php?controller=quanlyphong&act=edit&id=<?php echo $row['id']; ?>">Cập nhật</a>
                                    </td>
                                    <td>
                                        <?php 
                                            if($row['status']==="Hoạt động"){
                                        ?>
                                        <button class="btn btn-outline-secondary btn-block btn-off" data-id="<?php echo $row['id']; ?> "
                                                         data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">Tắt</button>
                                        <?php 
                                        }else if($row['status']==="Ngưng hoạt động"){ 
                                        ?>
                                        <button class="btn btn-outline-secondary btn-block btn-on" data-id="<?php echo $row['id']; ?> "
                                                         data-bs-toggle="modal" data-bs-target="#confirmOnModal">Bật</button>
                                        <?php }
                                        ?>
                                    </td>
                                </tr>

                            <?php
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

    </div>
</div>
<!--Ngưng hoạt động-->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xác nhận ngừng hoạt động</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn tắt phòng này?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
<!--Hoạt động lại-->
    <div class="modal fade" id="confirmOnModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xác nhận bật hoạt động</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn bật lại phòng này?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="confirmOnButton">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>


    <script>
$(document).ready(function () {
    let room; // Biến để lưu ID phòng cần thực hiện tắt hoặc bật lại

    // Xử lý khi nút tắt được nhấn
    $('.btn-off').click(function () {
        room = $(this).data('id');
        $('#confirmDeleteModal').modal('show'); // Hiển thị modal tắt
    });

    // Xử lý khi nút bật lại được nhấn
    $('.btn-on').click(function () {
        room = $(this).data('id');
        $('#confirmOnModal').modal('show'); // Hiển thị modal bật lại
    });

    // Xử lý khi nút xác nhận tắt trong modal tắt được nhấn
    $('#confirmDeleteButton').click(function () {
        $.ajax({
            url: 'pages/Quanlyphong/Action.php?act=off',
            type: 'POST',
            data: {
                id: room
            },
            success: function (response) {
                let res = JSON.parse(response);
                // Sử dụng console.error để in lỗi vào bảng điều khiển trình duyệt
                console.error("Error message: " + res.message);
                $('#result').html(`<div class="alert alert-${res.type}" role="alert">${res.message}</div>`);
                $('#result').fadeIn('slow', function () {
                    $('#result').delay(5000).fadeOut();
                });
                if (res.type === "success") {
                    window.setTimeout(function () {
                        // Chuyển trang qua trang cập nhật danh sách phòng
                        window.location.href = "index.php?controller=quanlyphong&act=update";
                    }, 1500);
                }
            },
            error: function (error) {
                // Sử dụng console.error để in lỗi vào bảng điều khiển trình duyệt
                console.error("AJAX Error: " + error);
            }
        });

        $('#confirmDeleteModal').modal('hide'); // Ẩn modal tắt
    });

    // Xử lý khi nút xác nhận bật lại trong modal bật lại được nhấn
    $('#confirmOnButton').click(function () {
        $.ajax({
            url: 'pages/Quanlyphong/Action.php?act=on',
            type: 'POST',
            data: {
                id: room
            },
            success: function (response) {
                let res = JSON.parse(response);
                // Sử dụng console.error để in lỗi vào bảng điều khiển trình duyệt
                console.error("Error message: " + res.message);
                $('#result').html(`<div class="alert alert-${res.type}" role="alert">${res.message}</div>`);
                $('#result').fadeIn('slow', function () {
                    $('#result').delay(5000).fadeOut();
                });
                if (res.type === "success") {
                    window.setTimeout(function () {
                        // Chuyển trang qua trang cập nhật danh sách phòng
                        window.location.href = "index.php?controller=quanlyphong&act=update";
                    }, 1500);
                }
            },
            error: function (error) {
                // Sử dụng console.error để in lỗi vào bảng điều khiển trình duyệt
                console.error("AJAX Error: " + error);
            }
        });

        $('#confirmOnModal').modal('hide'); // Ẩn modal bật lại
    });
});
</script>
