<div class="card-container">
<div id="result" class="mb-3"></div>

    <?php
    $sql = "SELECT *, cus.id as cccd, re.id as idRe, priceRoom FROM tbl_rebooking re, tbl_customers cus WHERE re.idCustomer = cus.id and re.status='Chưa duyệt'
            ORDER BY re.timebook ASC";
    $re = $db->fetch_assoc($sql, 0);

    if ($re) {
        foreach($re as $row){
    ?> 
    <form>
        <div class="card col-md-9 col-lg-7 col-xl-5" style="border-radius: 15px; display: inline-block;">
        
            <div class="card-body p-4">
            <div id="result" class="mb-3"></div>
                <div class="d-flex text-black">
                    
                    <div class="flex-grow-1 ms-3">
                        <h5 class="mb-1"><?php echo $row['name'] ?> - <?php echo $row['cccd'];?></h5>
                        <p class="mb-2 pb-1" style="color: #2b2a2a;">SDT: <?php echo $row['phone'];?></p>
                        <p class="mb-2 pb-1" style="color: #2b2a2a;">Thời gian: <?php echo date('H:i:s d/m/Y', strtotime($row['timebook']));?></p>
                        <p class="mb-2 pb-1" style="color: #2b2a2a;">
                                            Scam: <?php echo $row['scam'];?></p>
                        <div class="d-flex justify-content-start rounded-3 p-2 mb-2" style="background-color: #efefef;">
                            <div>
                                <p class="small text-muted mb-1">Phòng</p>
                                <p class="mb-0"><?php echo $row['idRoom'];?></p>
                            </div>
                            <div class="px-3">
                                <p class="small text-muted mb-1">Ngày nhận</p>
                                <p class="mb-0"><?php echo date('d/m/Y', strtotime($row['dateIn']));?></p>
                            </div>
                            <div>
                                <p class="small text-muted mb-1">Ngày trả</p>
                                <p class="mb-0"><?php echo date('d/m/Y', strtotime($row['dateOut']));?></p>
                            </div>
                        </div>
                        <div class="d-flex pt-1">
                            <button type="button" class="btn btn-danger me-1 flex-grow-1 cancel" 
                                    data-cccd="<?php echo $row['cccd']; ?>" 
                                    data-idre="<?php echo $row['idRe']; ?>">Xóa yêu cầu</button>

                            <button type="button" class="btn btn-success flex-grow-1 accept" 
                                    data-cccd="<?php echo $row['cccd']; ?>" 
                                    data-idre="<?php echo $row['idRe']; ?>"
                                    data-idroom="<?php echo $row['idRoom']; ?>"
                                    data-datein="<?php echo $row['dateIn']; ?>"
                                    data-priceRoom="<?php echo $row['priceRoom']; ?>"
                                    data-dateout="<?php echo $row['dateOut']; ?>">Xác nhận</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form>
    <?php
        }
    } else {
        echo "<p class='text-center text-gray-500'>Không có yêu cầu đặt phòng</p>";
    }
    ?>
</div>

<script>
    $(document).ready(function () {
        $('.cancel').click(function () {
            let cccd = $(this).data('cccd');
            let idRe = $(this).data('idre');

            $.ajax({
                url: 'pages/Quanlyvanhanh/Action.php?act=scam',
                type: 'POST',
                data: {
                    cccd: cccd,
                    idRe: idRe
                },
                success: function (response) {
                    let res = JSON.parse(response);
                    $('#result').html(`<div class="alert alert-${res.type}" role="alert">${res.message}</div>`);
                    $('#result').fadeIn('slow', function () {
                        $('#result').delay(5000).fadeOut();
                    });
                    if (res.type == "success") {
                        window.setTimeout(function() {
                            window.location.href="index.php?controller=quanlyvanhanh&act=accept";
                        }, 1500);
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
        $('.accept').click(function () {
            let cccd = $(this).data('cccd');
            let idRoom = $(this).data('idroom');
            let dateIn = $(this).data('datein');
            let dateOut = $(this).data('dateout');
            let idRe = $(this).data('idre');
            let priceRoom = <?php echo json_encode($row['priceRoom']); ?>;


            $.ajax({
                url: 'pages/Quanlyvanhanh/Action.php?act=accept',
                type: 'POST',
                data: {
                    cccd: cccd,
                    idRe: idRe,
                    idRoom: idRoom,
                    dateIn: dateIn,
                    dateOut: dateOut,
                    priceRoom: priceRoom
                },
                success: function (response) {
                    let res = JSON.parse(response);
                    $('#result').html(`<div class="alert alert-${res.type}" role="alert">${res.message}</div>`);
                    $('#result').fadeIn('slow', function () {
                        $('#result').delay(5000).fadeOut();
                    });
                    if (res.type == "success") {
                        window.setTimeout(function() {
                            window.location.href="index.php?controller=quanlyvanhanh&act=accept";
                        }, 1500);
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    });
</script>
