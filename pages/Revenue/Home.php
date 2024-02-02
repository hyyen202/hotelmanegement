 <!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Doanh thu</h1>
<p class="mb-4" >Bộ lọc doanh thu theo tháng
</p>
<div class="dropdown" >
    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Chọn tháng
    <span class="caret"></span></button>
    <ul class="dropdown-menu" style ="padding:20px";>
      <?php for($i = 1; $i<=12; $i++){
        ?>
            <li><a href="index.php?controller=revenue&thang=<?php echo $i;?>">Tháng <?php echo $i;?></a></li>
      <?php } ?>
    </ul>
  </div>



<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Doanh thu của tháng <?php 
                                            if(isset($_GET['thang']))
                                                { echo $_GET['thang'];}
                                            ?></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>ID</th>
                        <th>Thời gian</th>
                        <th>Tổng</th>
                    </tr>

                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>STT</th>
                        <th>ID</th>
                        <th>Thời gian</th>
                        <th>Tổng</th>
                    </tr>
                </tfoot>
                <tbody>
            <?php 
                $thang = $_GET['thang'];
                if(isset($thang))
                    {
                        $sql="SELECT *, month(dateCheckout) as month, year(dateCheckout) as year  FROM tbl_bill 
                                WHERE month(dateCheckout) = $thang";
                        $re= $db->fetch_assoc($sql,0);
                    }
                    else{
                        $sql="SELECT *, month(dateCheckout) as month, year(dateCheckout) as year  FROM tbl_bill ";
                        $re= $db->fetch_assoc($sql,0);
                    }
               
                $i = 1;
                foreach($re as $row)
                { 
            ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $row['id'] ?></td>
                        <td><?php echo $row['dateCheckout'] ?></td>
                        <td><?php echo $row['total'] ?></td>
                    </tr>
                    <?php
                        $i++;
                        }
                    ?>

                </tbody>
            </table>
            <p class="text-black float-start"><span class="text-black me-3"> Tổng doanh thu</span>
            <?php
                $sql="SELECT sum(total) as tong FROM tbl_bill  WHERE month(dateCheckout) = $thang";
                $re= $db->fetch_assoc($sql,1);
               ?>
            <span
                style="font-size: 25px;" id = 'sum'><?php echo round($re['tong'],0)?></span></p>
        </div>
    </div>
</div>