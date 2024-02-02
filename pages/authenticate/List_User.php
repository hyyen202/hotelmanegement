<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
    <p class="mb-4">Danh sách tài khoản nhân viên</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách tài khoản nhân viên</h6>
        </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>ID</th>
                                <th>Tên đăng nhập</th>
                                <th>Họ và tên</th>
                                <th>Email</th>
                                <th>Quyền</th>
                                <th>Ngày tạo</th>
                                <th>Tùy biến</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT * FROM tbl_user";
                                $re = $db->fetch_assoc($sql, 0);
                                $i = 1;
                                foreach ($re as $row) {
                                ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?php echo $row['id'] ?></td>
                                        <td><?php echo $row['username'] ?></td>
                                        <td><?php echo $row['fullname'] ?></td>
                                        <td><?php echo $row['email'] ?></td>
                                        <td>
                                            <?php 
                                                if($row['role']==1){
                                                    echo 'Admin';
                                                }
                                                else if($row['role']==0){
                                                    echo 'Nhân viên';
                                                }
                                                else{
                                                    echo 'Đã nghỉ';
                                                }
                                            ?>
                                        
                                        </td>
                                        <td><?php echo $row['create_at'] ?></td>
                                        <td>
                                            <a href="index.php?controller=update_user&id=<?php echo $row['id']; ?>">Cập nhật</a>
                                        </td>
                                    </tr>
                                <?php
                                    $i++;
                                }
                                ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>