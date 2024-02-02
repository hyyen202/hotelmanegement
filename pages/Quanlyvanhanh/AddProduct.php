<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Dịch vụ</h1>
    <!-- DataTales Example -->
    <div class="row">
        <div class="card shadow mb-4 col-8">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Sản phẩm</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Chọn</th>
                                <th>STT</th>
                                <th>ID</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Chọn</th>
                                <th>STT</th>
                                <th>ID</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php 
                            $sql = "SELECT * FROM tbl_product ";
                            $re = $db->fetch_assoc($sql, 0);
                            $i = 1;
                            $total = 0; // Initialize the total

                            foreach($re as $row) {
                            ?>
                                <tr>
                                    <td><input type="checkbox" name="selected[]" value="<?php echo $row['id']; ?>"></td>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td>
                                        <?php if ($row['qty'] < 1 || $row['status'] == 'Tạm hết') { ?>
                                            Tạm hết
                                        <?php } else { ?>
                                            <input type="number" class="form-control" name="qty[]" min="1">
                                        <?php } ?>
                                    </td>
                                    <input type="hidden" class="product-id" value="<?php echo $row['id']; ?>"> 
                                </tr>
                            <?php
                                // Calculate the total price
                                if (isset($_POST['selected']) && in_array($row['id'], $_POST['selected'])) {
                                    $total += $row['price'];
                                }
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card shadow mb-4 col-4">
            <div class="row">
                <div class="col col-12">
                
                    <div id="result" class="mb-3"></div>
                    <!-- Hết thông báo -->
                    <div class="card">
                        <div class="card-header">
                            Thêm sản phẩm
                        </div>
                        <div class="card-body">
                            <form id="spend_form">
                                <div class="mb-3">
                                    <label class="form-label">Mã booking</label>
                                    <input type="text" class="form-control" id="idBooking" name="idBooking" value="<?php echo $_GET['id']; ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tổng</label>
                                    <input type="number" class="form-control" id="total" name="total" value="<?php echo $total; ?>" readonly>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button class="btn btn-primary" type="button" id="add">Thêm</button>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button class="btn btn-primary" type="button" id="skip">Tiếp tục</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script>
        $(document).ready(function () {
            function updateTotal() {
                let total = 0;
                $('input[name="selected[]"]:checked').each(function () {
                    const row = $(this).closest('tr');
                    const price = parseFloat(row.find('td:eq(4)').text()); // Cột giá là cột thứ 4
                    const qty = parseFloat(row.find('input[name="qty[]"]').val()) || 0; // Đặt giá trị mặc định là 0 nếu qty không hợp lệ
                    total += price * qty;
                });
                $('#total').val(total);
            }

            // Listen for changes in checkboxes and quantity inputs
            $(document).on('change', 'input[name="selected[]"], input[name="qty[]"]', function () {
                updateTotal();
            });

            // Initial calculation of the total
            updateTotal();

            $('#skip').click(function (e) {
                window.setTimeout(function () {
                    window.location.href = "index.php?controller=quanlyvanhanh&act=total&id=<?php echo $_GET['id']; ?>";
                }, 1500);
            });

            // Bắt sự kiện khi người dùng click vào button
            $('#add').click(function (e) {
                e.preventDefault();

                let idBooking = "<?php echo $_GET['id']; ?>";
                let items = []; // Mảng để lưu thông tin về sản phẩm đã chọn
                let total = 0;

                let allSelected = true; // Giả sử tất cả sản phẩm đã chọn hợp lệ

                $('input[name="selected[]"]:checked').each(function () {
                    const row = $(this).closest('tr');
                    const idPro = row.find('td:eq(2)').text(); // Lấy tên sản phẩm từ cột 2
                    const name = row.find('td:eq(2)').text(); // Lấy tên sản phẩm từ cột 2
                    const price = parseFloat(row.find('td:eq(4)').text()); // Lấy giá từ cột 4
                    const qty = parseFloat(row.find('input[name="qty[]"]').val()) || 0; // Lấy số lượng từ input có name là "qty[]"

                    if (isNaN(qty) || qty <= 0) {
                        allSelected = false; // Nếu số lượng không hợp lệ, đặt allSelected thành false
                    }

                    const itemTotal = price * qty; // Tính tổng cho sản phẩm này
                    total += itemTotal; // Cộng tổng giá sản phẩm này vào tổng giá hóa đơn

                    // Thêm thông tin sản phẩm này vào mảng
                    items.push({
                        name: name,
                        price: price,
                        idPro: idPro,
                        qty: qty,
                        itemTotal: itemTotal
                    });
                });

                if (!allSelected) {
                    // Nếu có ít nhất một sản phẩm đã chọn nhưng số lượng không hợp lệ, hiển thị thông báo lỗi
                    $('#result').html('<div class="alert alert-danger" role="alert">Vui lòng nhập số lượng hợp lệ cho tất cả sản phẩm đã chọn!</div>');
                } else {
                    // Nếu tất cả sản phẩm đã chọn và số lượng là hợp lệ, thực hiện AJAX request
                    let formData = new FormData();
                    formData.append('idBooking', idBooking);
                    formData.append('items', JSON.stringify(items)); // Chuyển mảng thành chuỗi JSON để gửi lên máy chủ
                    formData.append('total', total);

                    $.ajax({
                        url: 'pages/Quanlyvanhanh/Action.php?act=addproduct',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            let res = JSON.parse(response);
                            $('#result').html('<div class="alert alert-' + res.type + '" role="alert">' + res.message + '</div>');
                            $('#result').fadeIn('slow', function () {
                                $('#result').delay(5000).fadeOut();
                            });
                            if (res.type === "success") {
                                $("#spend_form")[0].reset();
                            }
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }
            });

        });
    </script>
</div>
