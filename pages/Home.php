  <!-- Begin Page Content -->
  <div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Trang chủ</h1>
</div>
<?php
    //gọi hàm đếm phòng
    $room = selectRoom($db);
    //gọi hàm và tính doanh thu của tháng hiện tại
    $current_month = date('m');
    $revenue = number_format(selectRevenue($db, $current_month));
    //gọi hàm đếm số lượng sản phẩm và dịch vụ
    $countPro = countPro($db);
?>
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="index.php?controller=quanlyvanhanh&act=list">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Số lượng phòng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                    echo $room;
                                ?>                      
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Earnings (Annual) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Doanh thu trong tháng</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                                echo $revenue." VND";
                            ?> 
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


 <div class="col-xl-3 col-md-6 mb-4">
        <a href="index.php?controller=baocaomail&act=report">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Báo cáo</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <i class="fa fa-flag" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php
        
        $re = countBK($db); ?>
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="index.php?controller=quanlyvanhanh&act=accept">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Booking trực tuyến</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $re;?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>


<div class="row">
        <?php 
            include "pages/Quanlyvanhanh/Expries.php";
        ?>
        <!-- Collapsable Card Example -->

    </div>


<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
    
<script>
    document.title = "Trang chủ | <?=SITE_NAME?>" ;
</script>