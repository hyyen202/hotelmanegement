<div class="container-fluid">

<h1 class="h3 mb-2 text-gray-800">Thống kê chi tiêu</h1>

      <?php
        $nam = date('Y');

        $sql = "SELECT MONTH(dateSpend) AS month,  SUM(price) AS spend, product
                FROM tbl_spend
                WHERE YEAR(dateSpend) = $nam
                GROUP BY MONTH(dateSpend)";
    
    $dataSpend = $db->fetch_assoc($sql, 0);
?>

<!-- Rest of your HTML and chart setup -->

<!-- Content Row -->
    <div class="row">

        <div class="col-xl-8 col-lg-7">

            <!-- Area Chart -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Biểu đồ thống kê chi tiêu </h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="mySpendChart"></canvas>
                    </div>
                    <hr>
                    
                </div>
            </div>

        
        </div>
        <div class="col-xl-4 col-lg-5">
            <h4 class="h3 mb-2 text-gray-800" style ="font-size : 20px;">Thống kê chi tiêu năm: <?php echo  $nam ?></h4>
            <table class="table table-bordered"  width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tháng</th>
                            <th>Giá</th>
                            <th>Sản phẩm</th>
                        </tr>

                    </thead>

                    <?php
                        $sql = "SELECT product, MONTH(dateSpend) AS month FROM tbl_spend";
                        $productsByMonth = array(); // Mảng để lưu sản phẩm theo tháng

                        // Lặp qua kết quả truy vấn và sắp xếp sản phẩm theo tháng
                        foreach ($db->fetch_assoc($sql, 0) as $row) {
                            $month = $row['month'];
                            $product = $row['product'];

                            if (!isset($productsByMonth[$month])) {
                                $productsByMonth[$month] = array();
                            }

                            // Thêm sản phẩm vào mảng của tháng tương ứng
                            $productsByMonth[$month][] = $product;
                        }

                        foreach ($dataSpend as $row) {
                            $Spend = $row['spend'];
                            echo '<tbody>
                                    <tr>
                                        <td>Tháng: ' . $row['month'] . '</td>
                                        <td>' . number_format($Spend).'đ' . '</td>
                                        <td>'; // Mở cột cho tên sản phẩm

                            // Kiểm tra xem có sản phẩm nào cho tháng này hay không
                            if (isset($productsByMonth[$row['month']])) {
                                foreach ($productsByMonth[$row['month']] as $product) {
                                    echo $product . '<br>'; // Hiển thị tên sản phẩm
                                }
                            } else {
                                echo 'Không có sản phẩm';
                            }

                            echo '</td></tr></tbody>'; // Đóng cột cho tên sản phẩm
                    }
                    ?>


            </table>
           
           
        </div>
    </div>

</div>

 <!-- Js chart-->
<script src="assets/js/demo/chart-area-demo.js"></script>
   
<script>
    var SpendData = <?php echo json_encode($dataSpend);?>;
    var months = [];
    var SpendValues = [];

    SpendData.forEach(function(item){
        months.push("Tháng: " + item.month);
        SpendValues.push(item.spend);
    });

    var ctx = document.getElementById("mySpendChart");
    var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
        label: "Đã chi",
        lineTension: 0.3,
        backgroundColor: "rgba(78, 115, 223, 0.05)",
        borderColor: "rgba(78, 115, 223, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(78, 115, 223, 1)",
        pointBorderColor: "rgba(78, 115, 223, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: SpendValues,
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
            maxTicksLimit: 7
            }
        }],
        yAxes: [{
            ticks: {
            maxTicksLimit: 5,
            padding: 10,
            // Include a dollar sign in the ticks
            callback: function(value, index, values) {
                return '' + number_format(value);
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
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        titleMarginBottom: 10,
        titleFontColor: '#6e707e',
        titleFontSize: 14,
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        intersect: false,
        mode: 'index',
        caretPadding: 10,
        callbacks: {
            label: function(tooltipItem, chart) {
            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
            return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
            }
        }
        }
    }
    });

   
</script>
