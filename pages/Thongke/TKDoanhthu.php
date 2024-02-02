<div class="container-fluid">

<h1 class="h3 mb-2 text-gray-800">Thống kê doanh thu</h1>
<!--
<p class="mb-4" >Bộ lọc thống kê theo năm</p>
<div class="dropdown" >
    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Chọn năm
    <span class="caret"></span></button>
    <ul class="dropdown-menu" style ="padding:20px";> -->
      <?php
      
        $nam = date('Y');
        $sql = "SELECT MONTH(dateCheckout) AS month, SUM(total) AS revenue
                FROM tbl_bill
                WHERE YEAR(dateCheckout) = $nam
                GROUP BY MONTH(dateCheckout)";
    $dataRevenue = $db->fetch_assoc($sql, 0);
?>

<!-- Rest of your HTML and chart setup -->

<!-- Content Row -->
    <div class="row">

        <div class="col-xl-8 col-lg-7">

            <!-- Area Chart -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Biểu đồ thống kê doanh thu </h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myRevenueChart"></canvas>
                    </div>
                    <hr>
                    
                </div>
            </div>

        
        </div>
        <div class="col-xl-4 col-lg-5">
            <h4 class="h3 mb-2 text-gray-800" style ="font-size : 20px;">Thống kê doanh thu năm: <?php echo  $i ?></h4>
            <table class="table table-bordered"  width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tháng</th>
                            <th>Doanh thu</th>
                            <th>So sánh </th>
                        </tr>

                        </tr>
                    </thead>

                    <?php
                        $preRevenue = null;

                        foreach ($dataRevenue as $row) {
                            $Revenue = $row['revenue'];

                            // Kiểm tra nếu là tháng đầu tiên, không có tháng trước đó
                            if ($preRevenue === null) {
                                $compare = 'None';
                            } else {
                                // Tính phần trăm tăng trưởng
                                // phần trăm = ((revenue_current-revenue_previous)/revenue_previous)*100%
                                $phantram = (($Revenue - $preRevenue) / $preRevenue) * 100;

                                // Xác định mũi tên và màu dựa trên phần trăm
                                if ($preRevenue > $Revenue) {
                                    $compare = '<i class="fa fa-arrow-down" aria-hidden="true" style="color: red;"></i>  ' .number_format(abs($phantram)). '%';
                                } elseif ($preRevenue < $Revenue) {
                                    $compare = '<i class="fa fa-arrow-up" aria-hidden="true"  style="color: green;"></i>  ' .number_format(abs($phantram)). '%';
                                } else {
                                    $compare = 'Không đổi';
                                }
                            }

                            echo '<tbody>
                                    <tr>
                                        <td>Tháng: ' . $row['month'] . '</td>
                                        <td>' . number_format($Revenue).'đ'. '</td>
                                        <td>' . $compare . '</td>
                                    </tr>
                                </tbody>';

                            $preRevenue = $Revenue;
                        }
                    ?>

            </table>
           
           
        </div>
    </div>

</div>

 <!-- Js chart-->
    
    <script src="assets/js/demo/chart-area-demo.js"></script>
    <script src="assets/js/demo/chart-pie-demo.js"></script>
    <script src="assets/js/demo/chart-bar-demo.js"></script>
   
<script>
    var revenueData = <?php echo json_encode($dataRevenue); ?>;
    var months = [];
    var revenueValues = [];

    // Iterate over revenueData and add to arrays
    revenueData.forEach(function(item) {
        months.push('Tháng: ' + item.month);
        revenueValues.push(item.revenue);
    });

    var ctx = document.getElementById("myRevenueChart");
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: "Revenue",
                backgroundColor: "#4e73df",
                hoverBackgroundColor: "#2e59d9",
                borderColor: "#4e73df",
                data: revenueValues,
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    time: {
                        unit: 'month'
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 6
                    },
                    maxBarThickness: 25,
                }],
                yAxes: [{
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        callback: function(value, index, values) {
                            return  number_format(value);
                        }
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            },
            legend: {
                display: false
            },
            tooltips: {
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
                    }
                }
            },
        }
    });
   
</script>
