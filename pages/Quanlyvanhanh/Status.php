 <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Danh sách phòng đang ở</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                            <th>STT</th>
                                            <th>ID</th>
                                            <th>Phòng</th>
                                            <th>Tên Khách</th>
                                            <th>Phone</th>
                                            <th>Time book</th>
                                            <th>Time checkout </th>
                                            <th>Giá phòng</th>
                                            <th>Action</th>
                                            <th>Tùy biến</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>STT</th>
                                            <th>ID</th>
                                            <th>Phòng</th>
                                            <th>Tên Khách</th>
                                            <th>Phone</th>
                                            <th>Time book</th>
                                            <th>Time checkout </th>
                                            <th>Giá phòng</th>
                                            <th>Action</th>
                                            <th>Tùy biến</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php 
                                            $sql = "SELECT bk.id as id, bk.idRoom as room, kh.name as name, kh.phone, bk.dateIn, bk.dateOut, bk.status as status, price
                                              FROM tbl_customers kh, tbl_booking bk, tbl_room r WHERE kh.id = bk.idCustomer and bk.idRoom = r.id and bk.status = 'Chưa thanh toán'";
                                            $re = $db->fetch_assoc($sql,0);
                                            $i = 1;
                                            foreach($re as $row){
                                          
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['room']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['phone']; ?></td>
                                            <td><?php echo date(' d/m/Y', strtotime($row['dateIn']))?></td>
                                            <td><?php echo date(' d/m/Y', strtotime($row['dateOut'])) ?></td>
                                            <td><?php echo number_format($row['price']).'đ'; ?></td>
                                            <td><a href="index.php?controller=quanlyvanhanh&act=product&id=<?php echo $row['id'];?>">Thanh toán</a></td>
                                            <td><a href="index.php?controller=quanlyvanhanh&act=update&id=<?php echo $row['id'];?>">Cập nhật</a></td>
                                        </tr>
                                        <?php $i++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
<!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
