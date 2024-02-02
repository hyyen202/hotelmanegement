<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Thống kê phòng được thuê</h1>
    <div class="dropdown">
        
        <ul class="dropdown-menu" style="padding: 20px;">
            <?php
            $months = date('m');
            for ($i = 1; $i <= $months; $i++) {
                ?>
                <li><a href="index.php?controller=thongke&act=room&month=<?php echo $i; ?>">Tháng <?php echo $i; ?></a></li>
            <?php } ?>
        </ul>
    </div>

    <?php
    if (isset($_GET['month'])) {
        $i = $_GET['month'];
        $sql = "SELECT tbl_room.id AS room_id, COUNT(tbl_booking.id) AS count
                FROM tbl_room
                LEFT JOIN tbl_booking ON tbl_room.id = tbl_booking.idRoom AND MONTH(tbl_booking.dateIn)=$i
                GROUP BY tbl_room.id";
    } else {
        $i = $months;
        $sql = "SELECT tbl_room.id AS room_id, COUNT(tbl_booking.id) AS count
                FROM tbl_room
                LEFT JOIN tbl_booking ON tbl_room.id = tbl_booking.idRoom AND MONTH(tbl_booking.dateIn)=$i
                GROUP BY tbl_room.id";
    }
    $RoomData = $db->fetch_assoc($sql, 0);
    ?>

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-8 col-lg-7">

            <!-- Area Chart -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Biểu đồ thống kê số lượt thuê theo tháng</h6>
                </div>
                <?php
                if (empty($RoomData)) {
                    echo '<p>Không có dữ liệu cho năm ' . $i . ' </p>';
                } else { ?>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="myRoomChart"></canvas>
                        </div>
                        <hr>

                    </div>
                <?php } ?>
            </div>

        </div>
        <div class="col-xl-4 col-lg-5">
            <h4 class="h3 mb-2 text-gray-800" style="font-size: 20px;">Thống kê lượt thuê tháng: <?php echo $i ?></h4>
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tháng</th>
                        <th>Số lượt thuê</th>
                        <th>Tỷ lệ %(100%)</th>
                    </tr>
                </thead>

                <?php
                $sql = "SELECT COUNT(id) AS count
                        FROM tbl_booking
                        WHERE MONTH(tbl_booking.dateIn)=$i";
                $sumCount = $db->fetch_assoc($sql, 1);
                $totalLuotthue = $sumCount['count']; // Tổng số lượt thuê trong tháng
                
                foreach ($RoomData as $row) {
                    $count = $row['count']; // Số lượt thuê của phòng này
                    $percent = ($count / $totalLuotthue) * 100; // Tính phần trăm
                    
                    echo '<tbody>
                                <tr>
                                    <td>Phòng: ' . $row['room_id'] . '</td>
                                    <td>' . $count . '</td>
                                    <td>' . round($percent, 2) . '%</td>
                                </tr>
                            </tbody>';
                }
                ?>

            </table>
        </div>
    </div>

</div>

<!-- Js chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    var RoomData = <?php echo json_encode($RoomData) ?>;
    var RoomValues = [];
    var rooms = [];
    RoomData.forEach(function (item) {
        rooms.push("Phòng: " + item.room_id);
        RoomValues.push(item.count);
    });

    var ctx = document.getElementById("myRoomChart").getContext('2d');
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: rooms,
            datasets: [{
                data: RoomValues,
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#5a5c69', '#007bff', '#d9534f', '#ffc107'],
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: true,
                position: 'bottom',
            },
            cutoutPercentage: 70,
        },
    });
</script>
