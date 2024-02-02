<div class="row">
    <div class="col col-12">
        <div id="result" class="mb-3"></div>
        <div class="card">
            <div class="card-header">
                Cập nhật thông tin phòng
            </div>
            <?php
                $id = $_GET['id'];
                $sql = "SELECT * FROM tbl_room WHERE id = '$id'";
                foreach($db->fetch_assoc($sql,0) as $row){
             ?>
            <div class="card-body">
                <form id="new_form">
                    <div class="mb-3">
                        <label class="form-label">Tên Phòng</label>
                        <input type="text" class="form-control" id="name" value="<?php echo $row['id']; ?>">
                    </div>
                    <div class="mb-3">
                        <div class="col-lg-6">
                            <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                                <img id="previewImage" src="assets/images/<?php echo $row['img']; ?>" alt="Preview" width="80">
                                <input id="img" type="file" name="img" class="form-control border-0">
                               
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Loại phòng</label>
                        <input type="text" class="form-control" id="type" value="<?php echo $row['type']; ?>">
                    </div>
                    <div class="row">
                        <div class="col col-6">
                            <div class="mb-3">
                                <label class="form-label">Giá</label>
                                <input type="number" class="form-control" id="price" value="<?php echo $row['price']; ?>">
                            </div>
                        </div>
                        <div class="col col-6">
                            <div class="mb-3">
                                <label class="form-label">Ghi chú</label>
                                <input type="text" class="form-control" id="note" value="<?php echo $row['note']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary" type="button" id="update">Cập nhật</button>
                    </div>
                </form>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<script>
   $(document).ready(function () {
    // Hiển thị tên file khi chọn ảnh
    $('#img').change(function () {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.input-group-append').find('label').html(`<i class="fa fa-cloud-upload mr-2 text-muted"></i>${fileName}`);
    });

    let initialData = {
        img: '<?php echo $row['img']; ?>',
        name: '<?php echo $row['id']; ?>',
        type: '<?php echo $row['type']; ?>',
        price: '<?php echo $row['price']; ?>',
        note: '<?php echo $row['note']; ?>'
    };

    // Bắt sự kiện khi người dùng click vào button
    $('#update').click(function (e) {
        e.preventDefault();
        let name = $('#name').val(),
            type = $('#type').val(),
            price = $('#price').val(),
            note = $('#note').val();

        let formData = new FormData();
        formData.append('name', name);
        formData.append('type', type);
        formData.append('price', price);
        formData.append('note', note);

        // Lấy file ảnh
        let imgFile = $('#img')[0].files[0];
        if (imgFile) {
            formData.append('img', imgFile);
        } else {
            // Nếu không có file mới được chọn, giữ nguyên tên file cũ
            formData.append('img', initialData.img);
        }

        if (name !== initialData.name || type !== initialData.type || price !== initialData.price || note !== initialData.note || imgFile) {
            $.ajax({
                url: 'pages/Quanlyphong/Action.php?act=update',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    let res = JSON.parse(response);
                    $('#result').html(`<div class="alert alert-${res.type}" role="alert">${res.message}</div>`);
                    $('#result').fadeIn('slow', function () {
                        $('#result').delay(5000).fadeOut();
                    });
                    if (res.type == "success") {
                        window.setTimeout(function () {
                            window.location.href = "index.php?controller=quanlyphong&act=update";
                        }, 1500);
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        } else {
            // Hiển thị thông báo cho người dùng rằng không có thay đổi để cập nhật
            $('#result').html(`<div class="alert alert-info" role="alert">Không có thay đổi để cập nhật</div>`);
            $('#result').fadeIn('slow', function () {
                $('#result').delay(2000).fadeOut();
            });
        }
    });
});


</script>
