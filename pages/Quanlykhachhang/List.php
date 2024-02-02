<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
    <p class="mb-4">Danh sách khách hàng</p>
    <input class="form-control" id="myInput" type="text" placeholder="Search..">


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                        <th>STT</th>
                            <th>CCCD/CMND</th>
                            <th>Tên</th>
                            <th>SDT</th>
                            <th>Ngày sinh</th>
                            <th>Email</th>
                            <th>Cài đặt</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>STT</th>
                            <th>CCCD/CMND</th>
                            <th>Tên</th>
                            <th>SDT</th>
                            <th>Ngày sinh</th>
                            <th>Email</th>
                            <th>Cài đặt</th>
                        </tr>
                    </tfoot>
                    <tbody id = "myCustomer">
                        <?php
                        $sql = "SELECT * FROM tbl_customers";
                        $re = $db->fetch_assoc($sql, 0);
                        $i = 1;
                        foreach ($re as $row) { ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['phone'] ?></td>
                                <td><?php echo date('d/m/Y', strtotime($row['birthday'])); ?></td>
                                <td><?php echo $row['email'] ?></td>
                                <td>
                                    <?php
                                    if ($_GET['act'] == 'list') { ?>
                                        <a href="index.php?controller=quanlykhachhang&act=update&id=<?php echo $row['id'] ?>" class="btn-update">Cập nhật</a>
                                    <?php } elseif ($_GET['act'] == 'history') {
                                        echo '<a href="index.php?controller=quanlykhachhang&act=history&id=' . $row['id'] . '" class="btn-delete">Xem lịch sử</a>';
                                    }
                                    ?>
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