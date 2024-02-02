<div class="card">
    <form>
        <?php
        $id = $_GET['id'];
        $sql = "SELECT bk.id as id, kh.name as name, dateIN, dateOut, bk.status as st, 
                        bk.priceRoom as priceR, idRoom, phone, type, fullname, DATEDIFF(dateOut, dateIN)  as day,
                        ((DATEDIFF(dateOut, dateIN)) * bk.priceRoom) as sumRoom, deal, kh.id as cccd
                FROM tbl_customers kh, tbl_booking bk,  tbl_user as user , tbl_room r
                WHERE kh.id = bk.idCustomer  AND r.id = bk.idRoom AND bk.id = $id and bk.idEmloyee = user.id";
      
        $re = $db->fetch_assoc($sql, 1);

        $dateOut = $re['dateOut'];
        $dateIn = $re['dateIN'];

        // Định dạng ngày tháng năm (VD: 01-10-2023)
        $fmDateOut = date('d-m-Y', strtotime($dateOut));
        $fmDateIn = date('d-m-Y', strtotime($dateIn));
        ?>
        <div class="card-body">
            <div class="container mb-5 mt-3">
                <div class="row d-flex align-items-baseline">
                    <div class="col-xl-9">
                        <p style="color: #7e8d9f;font-size: 20px;">Hoá đơn >> <strong>ID: #<?php echo $id; ?></strong></p>
                    </div>
                    <div class="col-xl-3 float-end">
                    <?php if ($re['st'] == "Chưa thanh toán") {
                       echo ' <a id="cancel" class="btn btn-light text-capitalize btn-cancel" data-mdb-ripple-color="dark">
                            Hủy thanh toán
                        </a>'; }?>
                    </div>
                    <hr>
                </div>

                <div class="container">
                    <div class="col-md-12">
                        <div class="text-center">
                            <p class="pt-0">NIKKO HOTEL</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-8">
                            <p class="text-muted">NV booking: <?php echo $re['fullname']; ?></p>
                            <ul class="list-unstyled">
                                <li class="text-muted">Tên: <span style="color:#5d9fc5 ;"><?php echo $re['name']; ?></span></li>
                                <li class="text-muted">Ngày thuê: <?php echo $fmDateIn; ?></li>
                                <li class="text-muted"><i class="fas fa-phone"></i> <?php echo $re['phone']; ?></li>
                            </ul>
                        </div>
                        <div class="col-xl-4">
                            <p class="text-muted">NV thanh toán: <?php echo $data_user['fullname']; ?></p>
                            <ul class="list-unstyled">
                                <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span
                                        class="fw-bold">ID:</span><?php echo $id; ?></li>
                                <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span
                                        class="fw-bold">Ngày trả phòng: </span><?php echo $fmDateOut; ?></li>
                                <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span
                                        class="me-1 fw-bold">Trạng thái:</span><span class="
                                      <?php
                                      if ($re['st'] == 'Đã thanh toán') {
                                          echo "badge bg-success text-black fw-bold";
                                      } else {
                                          echo "badge bg-warning text-black fw-bold";
                                      } ?>">
                                        <?php echo $re['st']; ?></span></li>
                            </ul>
                        </div>
                    </div>

                    <div class="row my-2 mx-1 justify-content-center">
                        <table class="table table-striped table-borderless">
                            <thead style="background-color:#84B0CA ;" class="text-white">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Phòng</th>
                                    <th scope="col">Số ngày thuê</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col">Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th></th>
                                    <td><?php echo $re['idRoom']; ?></td>
                                    <td><?php echo $re['day']; ?></td>
                                    <td><?php echo number_format($re['priceR']).'đ'; ?></td>
                                    <td><?php echo number_format($re['sumRoom']).'đ'; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <?php 
                                    $sql = "SELECT *, tbl_service.qty as qtyS, tbl_service.price as price FROM tbl_service, tbl_product 
                                            WHERE tbl_service.status = 0 and idBooking = $id and tbl_product.id = tbl_service.idPro ";
                                    $items = $db->fetch_assoc($sql,0);
                                    if (isset($items)) { ?>
                                        <table class="table table-striped table-borderless">
                                            <p class="text-muted">Dịch vụ:</p>
                                            <thead style="background-color:#84B0CA ;" class="text-white">
                                                <tr>
                                                    <th scope="col">STT</th>
                                                    <th scope="col">Tên</th>
                                                    <th scope="col">Số lượng</th>
                                                    <th scope="col">Giá</th>
                                                    <th scope="col">Tổng</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                        // Hiển thị sản phẩm từ tbl_service với status = 0 là chưa thanh toán
                                      
                                        $i = 1;
                                        $tmp = 0; // Tạo biến để tính tổng giá trị
                                        foreach ($items as $item) {
                                            echo "<tr>";
                                            $itemTotal=  $item['qtyS'] *  $item['price'];
                                            ?>
                                            <th><?php echo $i ?></th>
                                            <td><?php echo $item['name']  ?></td>
                                            <td><?php echo $item['qtyS']  ?></td>
                                            <td><?php echo number_format($item['price']) ?></td>
                                            <td><?php echo number_format($itemTotal)?></td>
                                            <?php
                                            $tmp += $itemTotal; // Cộng dồn vào tổng giá trị
                                            $i++;
                                            echo "</tr>";
                                            
                                        echo '<input type="hidden" data-id="'.$item['idPro'].'" data-qty="'.$item['qty'].'">';
                                    
                                        }   
                                ?>
                                
                                
                                <!-- Repeat these three lines for each product -->

                            </tbody>
                        </table>
                        <?php }
                                    $bill =$tmp+$re['sumRoom'];
                                    $deal = $re['deal'];
                            ?>
                    </div>
                    <div class="row">
                        <div class="col-xl-8">
                            <p class="ms-3">Lưu ý: Hóa đơn đã bao gồm VAT</p>
                        </div>
                        <div class="col-xl-3">
                            <ul class="list-unstyled">
                                <li class="text-muted ms-3"><span class="text-black me-4">Tổng: </span><?php echo number_format($bill).'đ' ?></li>
                                <li class="text-muted ms-3"><span class="text-black me-4">Trả trước: </span><?php echo number_format($deal).'đ'?></li>
                            </ul>
                            <p class="text-black float-start"><span class="text-black me-3">Thanh toán</span><span
                                    style="font-size: 22px;"><?php $total = ($bill - $deal); echo  number_format($total) ?>đ</span></p>
                        </div>
                    </div>
                  
                    <hr>
                    <div class="row">
                        <div class="col-xl-9">
                            
                        </div>
                        <?php if ($re['st'] == "Chưa thanh toán") {
                            echo
                                '<div class="col-xl-3">
                                <button type="submit" class="btn btn-primary text-capitalize print" style="background-color:#60bdf3;" id="total">Thanh toán</button>
                            </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
   $(document).ready(function () {
        $('#cancel').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: 'pages/quanlyvanhanh/Unset.php',
                type: 'POST',
                success: function (response) {
                    window.location.href = "index.php";
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

       

        $('#total').click(function (e) {
                    e.preventDefault();

                    let idRoom = "<?php echo $re['idRoom'] ?>";
                    let day = "<?php echo $re['day'] ?>";
                    let total = "<?php echo $bill ?>";
                    let idBooking = "<?php echo $re['id'] ?>";
                    let dateCheckout = "<?php echo $re['dateOut'] ?>";
                    let cccd = "<?php echo $re['cccd'] ?>";

                    let items = []; // Initialize an array to store product data

                    // Select all input elements with the data-id attribute
                    $("input[data-id]").each(function (index, element) {
                        let id = $(element).data('id'); // Use data attribute to get the name
                        let qty = $(element).data('qty'); // Use data attribute to get the quantity

                        // Push product data into the items array
                        items.push({ id, qty });
                    });

                    let tmp = $("input[name='tmp']").val();
                    let formData = new FormData();
                    formData.append('tmp', tmp);
                    formData.append('items', JSON.stringify(items)); // Convert array to JSON string
                    formData.append('idRoom', idRoom);
                    formData.append('day', day);
                    formData.append('total', total);
                    formData.append('idBooking', idBooking);
                    formData.append('dateCheckout', dateCheckout);
                    formData.append('cccd', cccd);

                    $.ajax({
                        url: 'pages/quanlyvanhanh/Action.php?act=total',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            try {
                                let res = JSON.parse(response);
                                $('#result').html(`<div class="alert alert-${res.type}" role="alert">${res.message}</div>`);
                                $('#result').fadeIn('slow', function () {
                                    $('#result').delay(5000).fadeOut();
                                });
                                if (res.type == "success") {
                                    alert("Thanh toán thành công!");
                                    window.location.href="index.php";
                                }
                            } catch (e) {
                                console.log('Error parsing JSON:', e);
                            }
                        },
                        error: function (error) {
                            console.log('AJAX Error:', error);
                        }
                    });
                });

            });
    
    
</script>

