<?php
$sqli = "SELECT DISTINCT type FROM tbl_room  ";
$re = $db->fetch_assoc($sqli, 0);
?>
<h3>BỘ LỌC</h3>
<p>Vui lòng nhập ngày mà bạn muốn thuê</p>
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
</div>
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
        $sql = "SELECT * FROM tbl_room WHERE tbl_room.status = N'Trống'";
    }

    $rooms = $db->fetch_assoc($sql, 0);