<div class="col-md-4" style="padding-left:2%; height:300px">
    <ul class="list-group">
        <li class="list-group-item list-group-label " style="text-align: center;  font-weight:bold;   padding-left:5%; margin: auto  " >Maybe you are interested</li>
        <?php
        $sql = "SELECT * FROM tbl_posts ORDER BY id desc limit 5";
        $maxTitleLength = 25; // Độ dài tối đa của tiêu đề
        foreach ($db->fetch_assoc($sql, 0) as $row) {
            $title = $row['title'];
            $img = $row['img'];
            if (mb_strlen($title) > $maxTitleLength) {
                $title = mb_substr($title, 0, $maxTitleLength) . '...'; // Cắt tiêu đề khi quá dài
            }
        ?>
          
          <li style="padding-left: 3%; padding-right: 3px; --bs-list-group-item-padding-y: 1.1rem; font-size: 1.1rem; display: flex; list-style-type: circle; " class="list-group-item">
            <a style="color: #333333; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; align-items: center;"
                 href="index.php?controller=content&act=detail&id=<?php echo $row['id'] ?>">
                <img src="../assets/images/<?php echo $img ?>" class="img-fluid me-2" style="max-width: 60px;">
                <?php echo $title ?>
            </a>
        </li>

        <?php
        }
        ?>
    </ul>
</div>

