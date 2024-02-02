<div class="row">
    <div class="col col-12">
      
    <div id="result" class="mb-3"></div>
    <!-- Hết thông báo -->
        <div class="card">
            <div class="card-header">
                Báo cáo
            </div>
            <div class="card-body">
                <form id="new_form">
                    <div class="mb-3">
                        <label  class="form-label">Tên nhân viên</label>
                        <input type="text" class="form-control" id="name" value=<?php echo $data_user['fullname'];?> readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nội dung</label>
                        <textarea class="form-control" id="ct" placeholder="Nhập nội dung..."></textarea>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary" type="button" id="clear_now">Nhập lại</button>
                        <button class="btn btn-primary" type="button" id="report">Báo cáo</button>
                    </div>
                   
                </form>
            </div>
        </div>
    </div>
</div>

<script>
   $(document).ready(function () {
    $('#clear_now').click(function (e) {
        // Ngăn không cho load lại trang
        e.preventDefault();
        // reset form
        $("#new_form")[0].reset();
    });
    $('#report').click(function (e) {
        e.preventDefault();

        let ct = $('#ct').val();  // Sửa lỗi tên biến thành 'content'

        // Gửi request
        $.ajax({
            url: 'pages/BaocaoMail/Action.php?act=report',
            type: 'POST',
            data: {
                ct
            },
            success: function (response) {
                try {
                    let res = JSON.parse(response);
                    $('#result').html(`<div class="alert alert-${res.type}" role="alert">${res.message}</div>`);
                    $('#result').fadeIn('slow', function () {
                        $('#result').delay(5000).fadeOut();
                    });
                    if (res.type == "success") {
                        window.setTimeout(function() {
                            window.location.href="index.php?controller=baocaomail&act=report";
                        }, 500);
                    }
                } catch (e) {
                    console.log('Lỗi phân tích JSON:', e);
                }
            },
            error: function (error) {
                console.log('Lỗi AJAX:', error);
            }
        });
    });
});

</script>
