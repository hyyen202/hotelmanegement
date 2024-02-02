 <!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<p class="mb-4">Danh sách phòng </p>

<?php
    include "pages/Quanlyvanhanh/Filter.php";
?> 

<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách phòng của NIKKO Hotel</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Phòng</th>
                        <th>Loại</th>
                        <th>Giá</th>
                        <th>Ghi chú</th>
                        <th>Trạng thái</th>
                        <th>Tùy biến</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>STT</th>
                        <th>Phòng</th>
                        <th>Loại</th>
                        <th>Giá</th>
                        <th>Ghi chú</th>
                        <th>Trạng thái</th>
                        <th>Tùy biến</th>
                    </tr>
                </tfoot>
                <tbody id ="myRoom">
            <?php
            $i = 1;
                $sql = "SELECT * FROM tbl_room";
                $rooms = $db->fetch_assoc($sql, 0);
                foreach($rooms as $row)
                { 
            ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        
                        <td><?php echo $row['id'] ?></td>
                        <td><?php echo $row['type'] ?></td>
                        <td><?php echo number_format($row['price']).'đ' ?></td>
                        <td><?php echo $row['note'] ?></td>
                        <td>
                        <?php echo $row['status'] ?>
                        </td>
                        <td>
                            <a href="index.php?controller=quanlyvanhanh&act=booking&id=<?php echo $row['id']?>" class="btn-update">Đặt phòng</a>
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

<!-- Search -->
<script>
$(document).ready(function(){
    $('#filterIn').change(function () {
        var selectedDateIN = new Date($('#filterIn').val());
        var minDateOut = new Date(selectedDateIN);
        minDateOut.setDate(minDateOut.getDate() + 1);
        $('#filterOut').attr('min', minDateOut.toISOString().slice(0, 10));
    });
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
            url: 'index.php?controller=quanlyvanhanh&act=list', // Đảm bảo rằng URL của bạn đã sửa đúng
            data: {
                filterIn: filterIn,
                filterOut: filterOut,
                typeRoom: typeRoom
            },
            success: function (data) {
                // Cập nhật danh sách phòng với dữ liệu trả về từ máy chủ
                // data chứa danh sách phòng đã được lọc
                $('#myRoom').html(data);
            },
            error: function (error) {
                console.error(error);
            }
        });
    });
});


});
</script>