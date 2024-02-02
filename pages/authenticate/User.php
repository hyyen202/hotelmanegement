                            <!-- Dropdown - User Information -->
                            <?php 

                                if(isset($data_user)){?>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="index.php?controller=blog&page=new">Bài viết mới</a>
                                    <a class="dropdown-item" href="index.php?controller=blog&page=list_edit">Sửa bài viết</a>
                                    <a class="dropdown-item" href="index.php?controller=blog&page=delete">Xóa bài viết</a>
                                    <a class="dropdown-item" href="index.php?controller=user">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Cài đặt tài khoản
                                    </a>
                                    <a class="dropdown-item" href="index.php?controller=change">
                                        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Đổi mật khẩu
                                    </a>
                                   
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Đăng xuất
                                    </a>
                                    
                                <?php
                                    }
                                    
                                ?>
                        </li>


                    </ul>

                </nav>
                <!-- End of Topbar -->

              

           

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

   <!-- Logout Modal-->
 <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Đăng xuất</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Bạn chắc chắn muốn đăng xuất?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
                    <a class="btn btn-primary" href="index.php?controller=logout">Đăng xuất</a>
                </div>
            </div>
        </div>
    </div> 
