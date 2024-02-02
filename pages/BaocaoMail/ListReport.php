 <!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Danh sách báo cáo</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách báo cáo</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>ID</th>
                        <th>Tên nhân viên</th>
                        <th>Nội dung</th>
                        <th>Thời gian</th>
                    </tr>

                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>STT</th>
                        <th>ID</th>
                        <th>Tên nhân viên</th>
                        <th>Nội dung</th>
                        <th>Thời gian</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php  
                        $i = 1;
                        $sql="SELECT tbl_report.*, tbl_user.fullname FROM tbl_report, tbl_user WHERE tbl_user.id = tbl_report.idEmployee ORDER BY id desc";
                        foreach($db->fetch_assoc($sql, 0) as $row)
                        {

                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $row['id'] ?></td>
                        <td><?php echo $row['fullname'] ?></td>
                        <td><?php echo $row['content'] ?></td>
                        <td><?php echo date('H:i:s d/m/y', strtotime($row['date_report'])) ?></td>
                        
                    </tr>
                    <?php
                            $i++; 
                        }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
