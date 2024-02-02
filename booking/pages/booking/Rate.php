<div class = "row">
    <div class = "col-md-5 frame">
        <div id="result1"></div>
        <form id = "this_form" method="post">
            <h3>Đánh giá chất lượng dịch vụ</h3>
            <div class="form-group">
                <label class="form-label">Nhập CCCD hoặc CMND</label>
                <input type="text" id="cccd" name="cccd" placeholder="Nhập CCCD/CMND..." required>
            </div>
            <div class="form-group">
                <div class="rateYo" id="rating" data-id="numrate"></div>
            </div>
            <input type="hidden" name="numrate" id="numrate" value="0"> <!-- Thêm trường ẩn để lưu trữ giá trị đánh giá -->

            <!-- Các trường khác -->

            <input type="hidden" name="object_id" value="numrate"> <!-- Thêm trường ẩn để lưu trữ ID đối tượng -->
            <input type="hidden" id="idRoom" value="<?php echo $re['id']; ?>" hidden>
            <div class="form-group">
                <input type="text" id="ct" name="ct" placeholder="Nhập nội dung đánh giá">
            </div>
            <button class="btn btn-danger" type="submit" id="rate" name="rate"><i class="fa fa-shopping-cart"></i>Gửi đánh giá</button>
        </form>
    </div>
    <div class="col-md-5 frame">
        <h3>Các đánh giá(<?php echo $countRate; ?>)</h3>
        <?php 
            $sql = "SELECT tbl_rate.*, name FROM tbl_rate, tbl_customers, tbl_room 
                    WHERE tbl_rate.idCustomer = tbl_customers.id AND tbl_rate.idRoom = tbl_room.id and tbl_room.id = '$id'
                    ORDER BY id DESC ";
            $rates = $db->fetch_assoc($sql, 0);
            if($countRate != 0) {
                $index = 0;
                foreach($rates as $item) {
                    $time = date('H:i:s d/m/Y', strtotime($item['dateRating']));
        ?>
                    <div class="form-group <?php echo ($index >= 3) ? 'hidden-review' : ''; ?>">
                        <div class="small text-gray-500"><?php echo $time; ?></div> 
                        <label class="form-label"><?php echo $item['name']; ?></label>
                        <div class="rateYoo" id="rated_<?php echo $index; ?>" data-rating="<?php echo $item['rating']; ?>"></div> 
                        <div><?php echo $item['content']; ?></div> 
                    </div> 
        <?php 
                    $index++;
                }
                if ($countRate > 3) {
                    echo '<a id="seemore" class="see-more-reviews">Xem thêm </a>';
                }
            } 
        ?>
    </div>

</div>
<br>
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script>
    $(document).ready(function () {
        $('.rateYoo').each(function () {
            var rating = $(this).data('rating');
            $(this).rateYo({
                rating: rating,
                starWidth: "18px",
                readOnly: true,
                onSet: function (rating, rateYoInstance) {
                    // This won't be triggered because readOnly is set to true
                }
            });
        });
        $('.form-group.hidden-review').hide();
        // Track the current state
            var isHidden = true;

        // Toggle visibility of additional reviews when "Xem thêm" is clicked
        $('.see-more-reviews').click(function () {
            // Toggle the visibility of hidden reviews
            $('.form-group.hidden-review').toggle();

            // Update the text based on the current state
            if (isHidden) {
                $(this).text("Ẩn bớt");
            } else {
                $(this).text("Xem thêm");
            }

            // Invert the current state
            isHidden = !isHidden;
        });
        var numrate = 0; // Khởi tạo giá trị mặc định cho numrate
        $("#rating").rateYo({
            rating: numrate, // Sử dụng giá trị của numrate
            precision: 0, 
            starWidth: "23px",// Chỉ hiển thị số nguyên
            onSet: function (rating, rateYoInstance) {
                numrate = rating; // Cập nhật giá trị của numrate khi đánh giá thay đổi
                $("#numrate").val(numrate); // Gán giá trị của numrate cho trường ẩn
            }
        });

        // Booking for the form in exist_form
        $(' #rate').click(function (e) {
            e.preventDefault();
            let cccd = $('#this_form #cccd').val(),
                idRoom = $('#idRoom').val(),
                ct = $('#ct').val(), 
                numrate = $('#numrate').val(); 
            formData = new FormData();
            formData.append('cccd', cccd);
            formData.append('idRoom', idRoom);
            formData.append('ct', ct);
            formData.append('numrate', numrate);
            // Send AJAX request
            console.log(cccd);
            $.ajax({
                url: 'pages/booking/Action.php?act=rate',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    
                        const res = JSON.parse(response);
                        $('#result1').html(`<div class="alert alert-${res.type}" role="alert">${res.message}</div>`);
                        $('#result1').fadeIn('slow', function () {
                            $('#result1').delay(6000).fadeOut();
                        });
                        if (res.type === "success") {
                            window.setTimeout(function() {
                                window.location.reload(); // Reload trang hiện tại
                            }, 2500);
                        }
                    
                },
                error: function (error) {
                    console.error('AJAX error:', error);
                }
            });
        });
    });

</script>
