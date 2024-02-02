
<div class="card ">
            <div class="card-header">
                Phòng sắp hết hạn
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
                                                <th>SDT</th>
                                                <th>Ngày đặt</th>
                                                <th>Ngày trả</th>
                                                <th>Tùy biến</th>
                                                <th>Còn lại</th>

                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>STT</th>
                                                <th>ID</th>
                                                <th>Phòng</th>
                                                <th>Tên Khách</th>
                                                <th>SDT</th>
                                                <th>Ngày đặt</th>
                                                <th>Ngày trả</th>
                                                <th>Tùy biến</th>
                                                <th>Còn lại</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php 
                                                $sql = "SELECT
                                                            bk.id AS id,
                                                            bk.idRoom AS room,
                                                            kh.name AS name,
                                                            kh.phone,
                                                            bk.dateIn,
                                                            bk.dateOut,
                                                            bk.status AS status,
                                                            r.price,
                                                            CURRENT_TIMESTAMP AS current_datetime,
                                                            DATEDIFF(bk.dateOut, CURRENT_TIMESTAMP) AS remaining_days
                                                        FROM
                                                            tbl_customers kh
                                                        JOIN
                                                            tbl_booking bk ON kh.id = bk.idCustomer
                                                        JOIN
                                                            tbl_room r ON bk.idRoom = r.id
                                                        WHERE
                                                            bk.status = 'Chưa thanh toán'
                                                            AND DATEDIFF(bk.dateOut, CURRENT_TIMESTAMP) <= 1
                                                        ORDER BY
                                                            remaining_days ASC;
                                                        ";
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
                                                <td><?php echo date('d/m/Y', strtotime($row['dateIn'])); ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($row['dateOut'])); ?></td>
                                                <td><a href="index.php?controller=quanlyvanhanh&act=product&id=<?php echo $row['id'];?>">Thanh toán</a></td>
                                                <td><?php if($row['remaining_days']==0){
                                                    echo "Hôm nay"; }
                                                    else if($row['remaining_days']<0){
                                                        echo "Quá hạn";
                                                    }
                                                    else{
                                                        echo $row['remaining_days']; }
                                                    ?></td>
                                            </tr>
                                            <?php $i++; } ?>
                                        </tbody>
                                    </table>
                </div>
            </div>
