<div class="row" style="padding-top: 3%; border: 1px solid #ccc; margin:auto">
    <?php
        $sql = "SELECT * FROM tbl_posts order by id ";

        foreach($db->fetch_assoc($sql, 0) as $row){
            // do something
            
        ?>
       
            <div class="col-md-4">
                <a href=  "index.php?controller=content&act=detail&id=<?php echo $row['id']?>" style ="text-decoration: none; color:#333333; ">
                    <div class="card" style="width: 100%;">
                    <img src="../assets/images/<?php echo $row['img']; ?>" class="card-img-top" alt="..." style =" height: 300px;">
                        <div class="card-body">
                            <h5 class="card-title content-1"><?php echo $row['title']; ?></h5>
                            <p class="card-text content-2"><?php echo $row['content']; ?></p>
                            <div class="d-grid gap-2">
                                <a href="index.php?controller=content&act=detail&id=<?php echo $row['id']?>" class="btn btn-outline-secondary btn-block">See more</a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        
    <?php
    }
    ?>
    
</div>