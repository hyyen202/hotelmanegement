<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="background: #7e7e2fe3">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                
                <div class="sidebar-brand-text mx-3"style="font-family: fangsong;
    font-size: 110%;
    font-weight: 380;
    padding-bottom: 7px;">NIKKO|HOTEL<sup style="font-size:7px">TM</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Trang chủ</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Nhân viên
            </div>

            <!-- Nav Item - Quản lý vận hành Collapse Menu -->
            <li class="nav-item ">
                <a class="nav-link" href="index.php" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                    aria-controls="collapseTwo">
                    <i class="fas fa-warehouse"></i>
                    
                    <span>Quản lý vận hành</span>
                </a>
                <div id="collapseTwo" class="collapse " aria-labelledby="headingTwo"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Nhân viên</h6>  
                        <a class="collapse-item" href="index.php?controller=quanlyvanhanh&act=list">Xem danh sách phòng</a>
                        <a class="collapse-item" href="index.php?controller=quanlyvanhanh&act=status">Cập nhật trạng thái phòng</a>
                        <a class="collapse-item" href="index.php?controller=quanlyvanhanh&act=accept">Xem danh sách chờ duyệt</a>
                    </div>
                </div>
            </li>
           
            <!-- Nav Item - Quản lý khách hàng Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fa fa-users" aria-hidden="true"></i>
                    <span>Quản lý khách hàng</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Nhân viên</h6>
                        <a class="collapse-item" href="index.php?controller=quanlykhachhang&act=add">Thêm thông tin KH</a>
                        <a class="collapse-item" href="index.php?controller=quanlykhachhang&act=list">Cập nhật thông tin KH</a>
                        <a class="collapse-item" href="index.php?controller=quanlykhachhang&act=history">Xem lịch sử khách hàng</a>
                    </div>
                </div>
            </li>
            <!-- Nav Item - Quản lý chi tiêu Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseChitieu"
                    aria-expanded="true" aria-controls="collapseChitieu">
                    <i class="fas fa-wallet"></i>
                    <span>Quản lý chi tiêu</span>
                </a>
                <div id="collapseChitieu" class="collapse" aria-labelledby="headingChitieu"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Nhân viên</h6>
                        <a class="collapse-item " href="index.php?controller=quanlychitieu&act=add">Thêm khoản chi tiêu</a>
                        <a class="collapse-item " href="index.php?controller=quanlychitieu&act=list">Xem khoản chi tiêu</a>
                    </div>
                </div>
            </li>
            <!-- Nav Item - notice -->
            <li class="nav-item">
                <a class="nav-link" href="index.php?controller=baocaomail&act=report">
                <i class="fa fa-inbox" aria-hidden="true"></i>
                    <span>Báo cáo sự cố</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Admin
            </div>

              <!-- Nav Item - Quản lý Phòng Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="index.php" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true"
                    aria-controls="collapseThree">
                    <i class="fa fa-bed" aria-hidden="true"></i>
                    
                    <span>Quản lý phòng</span>
                </a>
                <div id="collapseThree" class="collapse " aria-labelledby="headingThree"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Admin</h6>
                        <a class="collapse-item active" href="index.php?controller=quanlyphong&act=add">Thêm thông tin phòng</a>
                        <a class="collapse-item active" href="index.php?controller=quanlyphong&act=update">Cập nhật phòng</a>
                    </div>
                </div>
            </li>

             <!-- Nav Item - send -->
             <li class="nav-item">
                <a class="nav-link" href="index.php?controller=baocaomail&act=mail">
                <i class="fa fa-paper-plane" aria-hidden="true"></i>
                    <span>Gửi thông báo</span></a>
            </li>
             <!-- Nav Item - doanh thu -->
                <!--
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=revenue">
                        <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span>Doanh thu</span></a>
                    </li>
                -->

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTK"
                    aria-expanded="true" aria-controls="collapseTK">
                    <i class="far fa-chart-bar"></i>
                    <span>Thống kê</span>
                </a>
                <div id="collapseTK" class="collapse" aria-labelledby="headingTK" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Admin</h6>
                        <a class="collapse-item active" href="index.php?controller=thongke&act=revenue">Thống kê doanh thu</a>
                        <a class="collapse-item active" href="index.php?controller=thongke&act=spend">Thống kê chi tiêu</a>
                        <a class="collapse-item active" href="index.php?controller=thongke&act=room">Thống kê phòng</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Setting-->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSettings"
                    aria-expanded="true" aria-controls="collapseSettings">
                    <i class="fas fa-cog"></i>
                    <span>Cài đặt</span>
                </a>
                <div id="collapseSettings" class="collapse" aria-labelledby="headingSettings" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Admin(*)</h6>
                        <a class="collapse-item active" href="index.php?controller=service">Thêm, cập nhật sản phẩm</a>
                        <a class="collapse-item active" href="index.php?controller=register">Tạo tài khoản nhân viên</a>
                        <a class="collapse-item active" href="index.php?controller=user">Cập nhật tài khoản</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                   

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                      

                       <?php
                       //Thông báo và messages
                       include 'pages/BaocaoMail/Notice.php';
                       ?>


                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php 

                                        if(isset($data_user)){
                                            if($data_user['role']==1){
                                                echo $data_user['fullname'].'<br><span style="color: #333333; font-size: 10px; display: inline-block; text-align: center;">(admin)</span>';
                                            }
                                            else{
                                                echo $data_user['fullname'];
                                            }
                                        }
                                        else{
                                            echo'<i class="fa fa-user-circle" aria-hidden="true"></i>';
                                        }
                                    ?>
                                </span>

                                
                            </a>


        <?php
            //dropdown user navbar
            include 'pages/authenticate/User.php';
        ?>