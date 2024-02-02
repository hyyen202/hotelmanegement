 <!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Cập nhật chi tiêu</h1>
<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank"
        href="https://datatables.net">official DataTables documentation</a>.</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách chi tiêu</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>ID</th>
                        <th>Tên nhân viên</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Ngày</th>
                        <th>Cập nhật</th>
                        <th>Cài đặt</th>
                    </tr>

                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>STT</th>
                        <th>ID</th>
                        <th>Tên nhân viên</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Ngày</th>
                        <th>Cập nhật</th>
                        <th>Cài đặt</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php  
                        $i = 1;
                        $sql="SELECT tbl_spend.id as idct, fullname, product, number, price, dateSpend,dateUpdate   FROM tbl_spend inner join  tbl_user on tbl_spend.idEmloyee =  tbl_user.id ";
                        foreach($db->fetch_assoc($sql, 0) as $row)
                        {

                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $row['idct'] ?></td>
                        <td><?php echo $row['fullname'] ?></td>
                        <td><?php echo $row['product'] ?></td>
                        <td><?php echo $row['number'] ?></td>
                        <td><?php echo number_format($row['price']) ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['dateSpend'])); ?></td>
                        <td><?php if(!empty($row['dateUpdate'])){
                                    echo date('d/m/Y', strtotime($row['dateUpdate']));
                                }
                             ?></td>
                        <td>
                            <a href="index.php?controller=quanlychitieu&act=update&id=<?php echo $row['idct']?>" class="btn-update">Cập nhật</a>
                        </td>
                    </tr>
                    <?php
                            $i++; 
                        }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
