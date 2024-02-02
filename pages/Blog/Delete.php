<div class="row" style="padding-top: 3%; border: 1px solid #ccc;  margin:auto">
    <?php
        $sql = "SELECT * FROM tbl_posts order by id ";

        foreach($db->fetch_assoc($sql, 0) as $row){
            // do something
            
        ?>
       
            <div class="col-md-4">
                <a  style ="text-decoration: none; color:#333333; ">
                    <div class="card" style="width: 100%;">
                        <img src="assets/images/<?php echo $row['img']; ?>" class="card-img-top" alt="..." style =" height: 300px;">
                        <div class="card-body">
                            <h5 class="card-title content-1"><?php echo $row['title']; ?></h5>
                            <p class="card-text content-2"><?php echo $row['content']; ?></p>
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-secondary btn-block btn-delete" data-id="<?php echo $row['id']; ?>" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">Xóa</button>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        
    <?php
    }
    ?>
</div>
                               
                     
 <!-- Modal for Delete Confirmation
    tham khảo chatGPT
-->
<!-- Modal for Delete Confirmation -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa bài viết này?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Xóa</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        let deleteItemId; // Biến để lưu id bài viết cần xóa

        // Xử lý khi nút xóa được nhấn
        $('.btn-delete').click(function () {
            
            deleteItemId = $(this).data('id');
            $('#confirmDeleteModal').modal('show'); // Hiển thị modal xác nhận
        });
        // Xử lý khi nút xác nhận xóa trong modal được nhấn
        $('#confirmDeleteButton').click(function () {
            $.ajax({
                url: 'pages/Blog/Action.php?act=del',
                type: 'POST',
                data: {
                    id: deleteItemId
                },
                success: function (response) {
                    let res = JSON.parse(response);
                    $('#result').html(`<div class="alert alert-${res.type}" role="alert">${res.message}</div>`);
                    $('#result').fadeIn('slow', function () {
                        $('#result').delay(5000).fadeOut();
                    });
                    if (res.type === "success") {
                       
                        window.setTimeout(function () {
                            location.reload();
                        }, 1500);
                    }
                },
                error: function (error) {
                    console.log(error);}
            });
            $('#confirmDeleteModal').modal('hide'); // Ẩn modal xác nhận
        });
    });
</script>
