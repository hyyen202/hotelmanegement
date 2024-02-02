<div class="row">
    <div class="col col-12">
        <!-- Chỗ này hiển thị thông báo nè -->
        <div id="result" class="mb-3"></div>
        <!-- Hết thông báo -->
        <div class="card">
            <div class="card-header">
               Cập nhật ngày trả phòng
            </div>

            <div class="card-body">
                <?php
                $id = $_GET['id'];
                $sql = "SELECT bk.*, type, price FROM tbl_booking bk, tbl_room r WHERE bk. id = '$id' and bk.idRoom = r.id";
                $re = $db->fetch_assoc($sql, 0);
                foreach ($re as $row) { ?>
                    <form id="new_form">
                        <div class="mb-3">
                            <label class="form-label">Tên Phòng</label>
                            <input type="text" class="form-control" id="room" value="<?php echo $row['idRoom'] ?>" readonly>
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
                                    <input type="number" class="form-control" id="id" name="id" value="<?php echo $row['id'] ?>" readonly>
                                </div>
                            </div>
                            <div class="col col-6">
                                <div class="mb-3">
                                    <label class="form-label">Ngày thuê</label>
                                    <input type="date" class="form-control" id="dateIN" name="dateIN" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $row['dateIn'] ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ngày trả</label>
                                    <input type="date" class="form-control" id="dateOut" name="dateOut" min="<?php echo date('Y-m-d'); ?> " value="<?php echo $row['dateOut'] ?>">
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-primary" type="button" id="update">Cập nhật</button>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#update').click(function (e) {
            e.preventDefault();

            let dateOut = $('#dateOut').val();
            let id = '<?php echo $_GET['id'];?>';

            // Gửi request
            $.ajax({
                url: 'pages/Quanlyvanhanh/Action.php?act=update&id='+ id,
                type: 'POST',
                data: {
                    dateOut: dateOut // Phải đặt tên key khi gửi dữ liệu
                },
                success: function (response) {
                    try {
                        let res = JSON.parse(response);
                        $('#result').html(`<div class="alert alert-${res.type}" role="alert">${res.message}</div>`);
                        $('#result').fadeIn('slow', function () {
                            $('#result').delay(5000).fadeOut();
                        });
                        if (res.type == "success") {
                            window.setTimeout(function() {
                            window.location.href="index.php";
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
