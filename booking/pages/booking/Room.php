<?php
$sqli = "SELECT DISTINCT type FROM tbl_room  ";
$re = $db->fetch_assoc($sqli, 0);
?>
<h3 style=" font-family: fangsong;color: #7a7a10;">HOTEL IN AMERICA</h3>
<p style=" font-family: math; font-size: 85%; font-weight: 380;padding-bottom: 7px;"> A contemporary space for work or leisure</p>
<form class="row" method="Post">
    <div class="col-3 form-group mb-3">
        <div style="font-family: system-ui; font-size: 70%; font-weight: 380; padding-bottom: 7px; color: #858526;">NGÀY THUÊ PHÒNG </div>
        <input type="date" id="filterIn" name="filterIn" min="<?php echo date('Y-m-d'); ?>" style=" padding: 5px; width: 100%;">
    </div>
    <div class="col-3 form-group mb-3">
        <div style=" font-family: system-ui; font-size: 70%; font-weight: 380; padding-bottom: 7px; color: #858526;">NGÀY TRẢ PHÒNG</div>
        <input type="date" id="filterOut" name="filterOut" min="<?php echo date('Y-m-d'); ?>" style=" padding: 5px;width: 100%; ">
    </div>
    <div class="col-3 form-group mb-3">
        <div style=" font-family: system-ui;font-size: 70%;font-weight: 380; padding-bottom: 7px; color: #858526;">LOẠI PHÒNG</div>
        <select id="typeRoom" name="typeRoom"  style=" padding: 7px; width: 100%; ">
            <option value="0">Chọn loại phòng</option>
            <?php
            foreach ($re as $row) {
                echo "<option value='" . $row['type'] . "'>" . $row['type'] . "</option>";
            }
            ?>
        </select>
    </div>
    <div class="col-3 form-group mb-3">
        <button type="submit" id="filterButton" name="submit" style = "margin-top:23px; font-family: math; font-size: 85%; font-weight: 380;
                                                                        padding-bottom: 7px; background-color: #9d9d3ae3 ">LỌC</button>
    </div>
    <div class="col-3 form-group mb-3">
        <a href="index.php?controller=booking&act=home" class="btn btn-outline-secondary btn-block" style="font-family: math; font-size: 85%;
                                                                                                            font-weight: 380; padding-bottom: 7px;
                                                                                                            background-color: #9d9d3ae3">LÀM MỚI</a>
    </div>
</form>


<div class="row" style="padding-top: 3%; border: 1px solid #ccc; margin:auto">
    <?php
    if (isset($_POST['filterIn']) && isset($_POST['filterOut'])) {
        $filterIn = ($_POST['filterIn']);
        $filterOut = ($_POST['filterOut']);
        $type = ($_POST['typeRoom']);
        
        $sql = "SELECT *
                FROM tbl_room
                WHERE id NOT IN (
                    SELECT DISTINCT tbl_room.id
                    FROM tbl_booking
                    JOIN tbl_room ON tbl_booking.idRoom = tbl_room.id
                    WHERE ('$filterIn' BETWEEN dateIn AND dateOut
                        OR '$filterOut' BETWEEN dateIn AND dateOut ) and tbl_booking.status='Chưa thanh toán'";

        // Kiểm tra nếu không chọn loại phòng thì loại bỏ điều kiện về loại phòng
        if (!empty($type)) {
            $sql .= " ) AND type = '$type'";
        }
        else if($type==0){
            $sql .= " )";
        }
    } else {
        $sql = "SELECT tbl_room.* FROM tbl_room 
                WHERE status = N'Hoạt động'";
    }
    

    $rooms = $db->fetch_assoc($sql, 0);

    foreach ($rooms as $row) {
        //đếm lượt thuê phòng
    $count = countLuotThue($db, $row['id']);
    ?>
        <div class="col-md-4 row">
            <a href="index.php?controller=booking&act=detail&id=<?php echo $row['id'] ?>" style="text-decoration: none; color:#333333;">
                <div class="card" style="width: 100%;">
                    <img src="../assets/images/<?php echo $row['img']; ?>" class="card-img-top" alt="..." style="height: 300px;">
                    <div class="card-body">
                        <h5 class="card-title content-1 center"><?php echo "Nikko Hotel - ". $row['id']; ?></h5>
                        <div class="row">
                            <div class = "col-5"> <strong>Lượt thuê:</strong> <?php echo $count; ?></div>
                            <div class = "col-7"> <strong>Loại:</strong> <?php echo $row['type']; ?></div>
                        </div>
                        <div class = "hy card-text content-2 price font-weight-bold">Giá: <?php echo number_format($row['price']).'đ'; ?></div>
                        <div class="d-grid gap-2">
                            <a href="index.php?controller=booking&act=detail&id=<?php echo $row['id'] ?>" class="btn btn-outline-secondary btn-block">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    <?php
    }
    ?>
</div>

<script>
$(document).ready(function () {
    $('#filterIn').change(function () {
        var selectedDateIN = new Date($('#filterIn').val());
        var minDateOut = new Date(selectedDateIN);
        minDateOut.setDate(minDateOut.getDate() + 1);
        $('#filterOut').attr('min', minDateOut.toISOString().slice(0, 10));
    });
    
    $('#filterButton').click(function () {
        // Lấy các giá trị từ các input
        var filterIn = $('#filterIn').val();
        var filterOut = $('#filterOut').val();
        var typeRoom = $('#typeRoom').val();

        // Thực hiện AJAX request để lọc dữ liệu dựa trên các giá trị trên và cập nhật danh sách phòng
        $.ajax({
            type: 'POST',
            url: 'index.php?controller=booking?act=home',
            data: {
                filterIn: filterIn,
                filterOut: filterOut,
                typeroom: typeRoom
            },
            success: function (data) {
            },
            error: function (error) {
                console.error(error);
            }
        });
    });
});
</script>
