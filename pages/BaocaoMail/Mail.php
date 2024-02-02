<form style="display:block; padding: 5%; padding-top:2%;" action="pages/BaocaoMail/Send.php" method="post" >
    <div class="card-header">
            Gửi thông báo
    </div>
    <div class="form-row" >
        <div class="form-group col-md-6">
            <label>Email</label>
            <input type="email" name = "email" class="form-control" placeholder="Email">
        </div>
       
    </div>
    <div class="form-group">
        <label >Tiêu đề</label>
        <input type="textarea" class="form-control" name="subject" placeholder="Nhập tiêu đề email...">
    </div>
   
    <div class="form-group">
        <label >Nội dung</label>
        <input type="textarea" class="form-control" name="message" placeholder="Nhập nội dung email...">
    </div>
    <button type="submit" name ="send" class="btn btn-primary">Gửi</button>
</form>
