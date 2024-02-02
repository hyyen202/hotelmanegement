<?php
$id = $_GET['id'];

$sql = "SELECT tbl_room.* FROM tbl_room WHERE tbl_room.id = '$id'";
$re = $db->fetch_assoc($sql, 1);

$sqli="SELECT count(idRoom) as count FROM tbl_room , tbl_booking bk WHERE tbl_room.id = '$id' and tbl_room.id = bk.idRoom";
$row = $db->fetch_assoc($sqli, 1);

$sql = "SELECT COUNT(rate.idRoom) as count, AVG(rating) as avRate,  rate.* FROM tbl_rate rate, tbl_room r WHERE r.id = rate.idRoom and r.id = '$id'";
$result = $db->fetch_assoc($sql, 1);
$countRate = $result['count'];
if(isset($result['avRate'])){

    $avRate = $result['avRate'];
}
else {
    $avRate = 0;
}
if ($re) {  // Check if there's a result
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card father" style = "height:100%;">
                <img src="../assets/images/<?php echo $re['img']; ?>" class="card-img-top frm-img" alt="Ảnh phòng">
                <div class="card-body">
                    <h4 class="card-title">Phòng: <?php echo $re['id']; ?></h4>
                    <div class="card-text row">
                        <div class ="col-6">
                            <div class ="hy"><strong>Loại phòng:</strong> <?php echo $re['type']; ?><br></div>
                            <div class ="hy"><strong>Tiện ích:</strong> <?php echo $re['note']; ?></div>
                        </div>
                        <div class ="col-6">
                            <div class ="hy"><strong>Lượt thuê:</strong> <?php echo $row['count']; ?> <br></div>
                                <div class ="hy"><strong>Đánh giá:</strong> <?php echo round($avRate, 2)."/5"; ?>
                                    <div style="display: inline-flex;">
                                        <div class="rateYo" id="rated" data-id="numrate"></div>
                                        <div style="margin-top: -3px;"><?php echo "(".$countRate.")"; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="card-text">
                        <strong>Giá:</strong> <span class="text-danger font-weight-bold price"><?php echo number_format($re['price']).'đ'; ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6" >
            <div class="father" >
                <div class="title"><h5>Thông Tin Khách Hàng</h5></div>
                    <div id="result"></div>
                <form id="form" method="post">
                    <input type="text" id="idRoom" value="<?php echo $re['id']; ?>" hidden>
                        <div class="form-group">
                            <label>Họ và Tên:</label>
                            <input type="text" id="name" name="name" placeholder ="Nhập họ tên..." required>
                        </div>
                        <div class="form-group">
                            <label >CCCD/CMND:</label>
                            <input type="text" class="cccd" name="id" placeholder ="+Nhập CCCD/CMND..." required>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label >SĐT:</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder ="+84" required>
                            </div>
                            <div class="form-group col-6">
                                <label class="form-label">Ngày sinh:</label>
                                <?php
                                    // Tính toán ngày 18 tuổi trước ngày hiện tại
                                    $maxBirthday = date('Y-m-d', strtotime('-18 years'));
                                ?>
                                <input type="date" class="form-control" id="birthday" name="birthday" max="<?php echo $maxBirthday; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="email" id="email" name="mail" placeholder ="name@Example.com" required>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label class="form-label">Ngày thuê</label>
                                <input type="date" class="form-control dateIN" name="dateIN" min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="form-group col-6">
                                <label class="form-label">Ngày trả</label>
                                <input type="date" class="form-control dateOut" name="dateOut" min="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>  
                        <button class="btn btn-danger" type="button" id="booking"><i class="fa fa-shopping-cart"></i> Đặt Phòng</button>
                                <a  id = "exist">Bạn đã có tài khoản?</a>
                </form>
                <!--form 2-->

                <form id="exist_form" method="post"  style="display: none;">
                    <div class="form-group">
                        <label >CCCD/CMND:</label>
                        <input type="text"  id="cccd" name="cccd" placeholder ="+Nhập CCCD/CMND..."required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Ngày thuê</label>
                        <input type="date" class="form-control dateIN" name="dateIN" min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ngày trả</label>
                        <input type="date" class="form-control dateOut" name="dateOut" min="<?php echo date('Y-m-d'); ?>">
                    </div>

                                    
                    <button class="btn btn-danger" type="button" id="booking_exist"><i class="fa fa-shopping-cart"></i> Đặt Phòng</button>
                    <a  id = "none-exist">Bạn chưa có tài khoản?</a>
                </form>
            </div>
        </div>
    </div>
    <hr>
    <?php include 'Rate.php';?>
</div>

<?php
} else {
    echo "Không tìm thấy dữ liệu.";
}
?>

<script>
    $(document).ready(function () {
        var avRate = <?php echo $avRate; ?>; // Use PHP to echo the PHP variable
        $(".rateYo").rateYo({
            rating: avRate,
            starWidth: "18px",
            readOnly: true,
            onSet: function (rating, rateYoInstance) {
                avRate = rating;
                $("#numrate").val(avRate);
            }
        });
        $('#exist_form .dateIN').change(function () {
        var selectedDateIN = new Date($('#exist_form .dateIN').val());

    // Kiểm tra xem selectedDateIN có hợp lệ không
            if (!isNaN(selectedDateIN.getTime())) {
                // Tạo một bản sao của ngày thuê và cộng thêm 1 ngày
                var minDateOut = new Date(selectedDateIN);
                minDateOut.setDate(minDateOut.getDate() + 1);

                // Định dạng ngày và gán cho trường Ngày trả
                var formattedMinDateOut = minDateOut.toISOString().slice(0, 10);
                $('#exist_form .dateOut').attr('min', formattedMinDateOut);
                
                // Tạo một bản sao khác của ngày thuê và cộng thêm một số ngày khác
                var maxDateOut = new Date(selectedDateIN);
                maxDateOut.setDate(maxDateOut.getDate() + 60);  // số ngày tối đa bạn muốn cho phép

                // Định dạng ngày và gán cho trường Ngày trả
                var formattedMaxDateOut = maxDateOut.toISOString().slice(0, 10);
                $('#exist_form .dateOut').attr('max', formattedMaxDateOut);
            } else {
                console.error('Ngày thuê không hợp lệ');
            }

        });
        $('#form .dateIN').change(function () {
        var selectedDateIN = new Date($(' #form .dateIN').val());

    // Kiểm tra xem selectedDateIN có hợp lệ không
            if (!isNaN(selectedDateIN.getTime())) {
                // Tạo một bản sao của ngày thuê và cộng thêm 1 ngày
                var minDateOut = new Date(selectedDateIN);
                minDateOut.setDate(minDateOut.getDate() + 1);

                // Định dạng ngày và gán cho trường Ngày trả
                var formattedMinDateOut = minDateOut.toISOString().slice(0, 10);
                $('#form .dateOut').attr('min', formattedMinDateOut);
                
                // Tạo một bản sao khác của ngày thuê và cộng thêm một số ngày khác
                var maxDateOut = new Date(selectedDateIN);
                maxDateOut.setDate(maxDateOut.getDate() + 60);  // số ngày tối đa bạn muốn cho phép

                // Định dạng ngày và gán cho trường Ngày trả
                var formattedMaxDateOut = maxDateOut.toISOString().slice(0, 10);
                $('#form .dateOut').attr('max', formattedMaxDateOut);
            } else {
                console.error('Ngày thuê không hợp lệ');
            }

        });
        $('#exist').click(function(e){
                e.preventDefault();
                $('#form').hide();
                $('#exist_form').show();
            });
        $('#none-exist').click(function(e){
                e.preventDefault();
                $('#form').show();
                $('#exist_form').hide();
            });
            
        $('#booking').click(function (e) {
            e.preventDefault();

            // Get input values
            let name = $('#name').val(),
                cccd = $('.cccd').val(),
                phone = $('#phone').val(),
                birthday = $('#birthday').val(),
                email = $('#email').val(),
                idRoom = $('#idRoom').val(),
                dateIN = $('#form .dateIN').val(), 
                dateOut = $('#form .dateOut').val();

            // Create form data object
            let formData = new FormData();
            formData.append('name', name);
            formData.append('cccd', cccd);
            formData.append('phone', phone);
            formData.append('birthday', birthday);
            formData.append('email', email);
            formData.append('idRoom', idRoom);
            formData.append('dateIN', dateIN);
            formData.append('dateOut', dateOut);


            // Send AJAX request
            $.ajax({
                url: 'pages/booking/Action.php?act=booking',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    
                        const res = JSON.parse(response);
                        $('#result').html(`<div class="alert alert-${res.type}" role="alert">${res.message}</div>`);
                        $('#result').fadeIn('slow', function () {
                            $('#result').delay(6000).fadeOut();
                        });
                        if (res.type === "success") {
                            window.setTimeout(function() {
                                window.location.href="index.php";
                            }, 1500);
                        }
                    
                },
                error: function (error) {
                    console.error('AJAX error:', error);
                }
            });
        });
        // Booking for the form in exist_form
        $('#booking_exist').click(function (e) {
            e.preventDefault();
            let cccd = $('#cccd').val(),
                idRoom = $('#idRoom').val(),
                dateIN = $('#exist_form .dateIN').val(), 
                dateOut = $('#exist_form .dateOut').val(); 
            formData = new FormData();
            formData.append('cccd', cccd);
            formData.append('idRoom', idRoom);
            formData.append('dateIN', dateIN);
            formData.append('dateOut', dateOut);
            // Send AJAX request
            $.ajax({
                url: 'pages/booking/Action.php?act=booking_exist',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                        const res = JSON.parse(response);
                        $('#result').html(`<div class="alert alert-${res.type}" role="alert">${res.message}</div>`);
                        $('#result').fadeIn('slow', function () {
                            $('#result').delay(6000).fadeOut();
                        });
                        if (res.type === "success") {
                            window.setTimeout(function() {
                                window.location.href="index.php";
                            }, 1500);
                        }
                    
                },
                error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
            });
        });
    });

</script>


