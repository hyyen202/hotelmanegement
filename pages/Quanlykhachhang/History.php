<!-- Begin Page Content -->
<div class="container-fluid">
    <p class="mb-4">Lịch sử khách hàng</p>
    <input class="form-control" id="myInput" type="text" placeholder="Search..">


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Khách hàng: <?php echo $_GET['id']?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>STT</th> 
                            <th>Mã booking</th>
                            <th>Ngày thuê</th>
                            <th>Ngày trả</th>
                            <th>Phòng</th>
                            <th>Loại phòng</th>
                            <th>Thanh toán</th>
                            <th>Tùy biến</th>
                    
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>STT</th>
                            <th>Mã booking</th>
                            <th>Ngày thuê</th>
                            <th>Ngày trả</th>
                            <th>Phòng</th>
                            <th>Loại phòng</th>
                            <th>Thanh toán</th>
                            <th>Tùy biến</th>
                        </tr>
                    </tfoot>
                    <tbody id = "myCustomer">
                        <?php
                            if(isset($_GET['id'])){
                                $id = $_GET['id'];
                                $sql = "SELECT DISTINCT bk.id AS booking_id, bk.*, r.id AS room_id, r.*, bill.*, r.id AS r, bk.status as bkStatus, idCustomer, bill.total
                                FROM tbl_booking bk LEFT JOIN tbl_room r ON bk.idRoom = r.id LEFT JOIN tbl_bill bill ON bk.id = bill.idBooking INNER JOIN tbl_customers 
                                on bk.idCustomer = tbl_customers.id WHERE tbl_customers.id = $id and bk.status ='Đã thanh toán'";
                                $re = $db->fetch_assoc($sql, 0);
                            }
                            
                        $i = 1;
                        foreach ($re as $row) { ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $row['booking_id'] ?></td>
                                <td><?php echo $row['dateIn'] ?></td>
                                <td><?php echo $row['dateOut'] ?></td>
                                <td><?php echo $row['room_id'] ?></td>
                                <td><?php echo $row['type'] ?></td>
                                <td><?php echo $row['total']?></td>
                                <td>
                                    <a href="index.php?controller=quanlykhachhang&act=bill&id=<?php echo $row['booking_id'] ?>" class="btn-update">Xem hóa đơn</a>
                                </td>
                            </tr>
                        <?php
                            $i++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Search -->
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myCustomer tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>