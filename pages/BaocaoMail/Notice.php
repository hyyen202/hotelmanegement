 <!-- Nav Item - Alerts -->
 <?php 
    if(isset($data_user))
    {
        $re = countBK($db);
  ?>
 <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw">
                                    <?php
                                        if ($re > 5) {
                                            echo '<span class="badge badge-danger badge-counter">5+</span>';
                                        } elseif ($re >= 1) {
                                            echo '<span class="badge badge-danger badge-counter">' . $re . '</span>';
                                        }
                                        // You can remove the else block if you don't want to display anything when $re is 0.
                                    ?>
                                </i>

                            </a>

                           
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Khách hàng booking
                                </h6>
                                <?php 
                                $sql = "SELECT timebook, name, dateIn From tbl_customers, tbl_rebooking 
                                        WHERE tbl_customers.id = tbl_rebooking.idCustomer and status = 'chưa duyệt'
                                        ORDER BY tbl_rebooking.id desc limit 5";
                                $query = $db->fetch_assoc($sql, 0);
                                if(!isset($query)){
                                    echo  '<p class="dropdown-item text-center text-gray-500" >Không có yêu cầu đặt phòng</p>';
                                }
                                else{
                                        
                                    foreach($query as $row){
                                        $time= date('H:i:s d/m/y', strtotime($row['timebook']));
                                        $dateIn = date(' d/m/y', strtotime($row['dateIn']));
                                ?>
                                    <a class="dropdown-item d-flex align-items-center" href="index.php?controller=quanlyvanhanh&act=accept">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-primary">
                                                <i class="fas fa-file-alt text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500"><?php echo $time;?></div>
                                            <span class="font-weight-bold"><?php echo "Khách hàng ".$row['name']. " vừa gửi yêu cầu đặt phòng vào ngày "
                                                                                .$dateIn ?></span>
                                        </div>
                                    </a>
                                
                                    <?php
                                        }}
                                       echo' <a class="dropdown-item text-center small text-gray-500" href="index.php?controller=quanlyvanhanh&act=accept">Xem thêm</a>';
                                        $sql = "SELECT *, tbl_report.id as id FROM tbl_report, tbl_user WHERE tbl_report.idEmployee=tbl_user.id and status = 0 ";
                                        $r = $db->fetch_assoc($sql,0);
                                    ?>
                            </div>
                        </li>
                        
                       

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                    <?php
                                    
                                        $report = countRP($db);

                                        if ($report > 5) {
                                            echo '<span class="badge badge-danger badge-counter">5+</span>';
                                        } elseif ($report >= 1) {
                                            echo '<span class="badge badge-danger badge-counter">' . $report . '</span>';
                                        }
                                    ?>
                                
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Báo cáo
                                </h6>
                                <?php
                                    
                                    foreach($r as $row)
                                    {
                                        $idR = $row['id'];
                                        $time= date('H:i:s d/m/y', strtotime($row['date_report']));

                                ?>
                                <a class="dropdown-item d-flex align-items-center check"  data-report-id="<?php echo $idR; ?>">
                                    
                                    <div class="font-weight-bold">
                                        <div class="text-truncate"><?php echo $row['content']?></div>
                                        <div class="small text-gray-500"><?php echo $row['fullname']." · ". $time?></div>
                                    </div>
                                </a>
                                <?php }?>
                                <a class="dropdown-item text-center small text-gray-500" href="index.php?controller=baocaomail&act=listreport">Xem thêm</a>
                              
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>


    <?php
                                    
             }  
    ?>

<script>
    $(document).ready(function () {
   
    // Bắt sự kiện khi người dùng bấm vào thông báo
    $('.check').click(function (e) {
        e.preventDefault();
        
        // Lấy ID của thông báo từ thuộc tính data-report-id (ví dụ: data-report-id="1")
        var reportId = $(this).data('report-id');

        // Thực hiện yêu cầu AJAX để cập nhật status
        $.ajax({
            type: 'POST',
            url: 'pages/BaocaoMail/Action.php?act=notice',
            data: { report_id: reportId }, // Gửi ID của thông báo
            dataType: 'json',
            success: function (response) {
                    window.setTimeout(function () {
                                window.location.href = "index.php?controller=baocaomail&act=listreport";
                            }, 500);
            },
            error: function (error) {
                console.error(error);
            }
        });
    });

});

</script>