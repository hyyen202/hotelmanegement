<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <link rel="stylesheet" type="text/css" href="../assets/css/formBooking.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/mycss.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/detail.css">
     <!-- Latest compiled and minified CSS Rate -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <!-- Kiểm tra kết nối jQuery và RateYo -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>


</head>


    <div class="container">
            <div class="nav" style=" display:block">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light row" >
                        <div class="container-nav col"  style=" display:flex">
                                  <a class="navbar-brand" href="#"style="font-family: fangsong;
                                                                        font-size: 110%;
                                                                        font-weight: 380;
                                                                        padding-bottom: 7px;
                                                                        color: #858526;" >NIKKO|HOTTEL</a>
                                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                  </button>
                                  <div class="collapse navbar-collapse" id="navbarNav" style="padding-left:220px;">
                                          <ul class="navbar-nav">
                                            <li class="nav-item">
                                              <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                                            </li>
                                            <li class="nav-item">
                                              <a class="nav-link" href="index.php?controller=blog&page=features">Features</a>
                                            </li>
                                            <li class="nav-item">
                                              <a class="nav-link" href="index.php?controller=blog&page=list">Posts</a>
                                            </li>
                                            <li class="nav-item">
                                              <a class="nav-link contact" href="index.php?controller=booking&act=home" tabindex="-1" aria-disabled="true">Booking</a>
                                            </li>
                                            
                                          </ul>
                                  </div>
                          </div>
                      

                              <!--Login-->

                              
                          <?php
                          /*
                                  if($user == ''){
                                      echo'
                                      <ul class="nav">
                                          <a class="nav-item" href = "index.php?controller=login"><svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="#8899988" class="bi bi-person" viewBox="-4 -4 19 16">
                                          <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                                        </svg><a>
                                      </ul>
                                ';
                                  }else{
                                      echo'
                                          <div class="dropdown">
                                              <a class="btn btn-link dropdown-toggle link-dark" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span id="dis_name"> '.$data_user['fullname'].'</span>
                                              </a>

                                              <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                  <li><a class="dropdown-item" href="index.php?controller=blog&page=new">New post</a></li>
                                                  <li><a class="dropdown-item" href="index.php?controller=blog&page=list_edit">Edit post</a></li>
                                                  <li><a class="dropdown-item" href="index.php?controller=blog&page=delete">Delete post</a></li>
                                                  <li><a class="dropdown-item" href="index.php?controller=statistics">Statistic</a></li>
                                                  <li><a class="dropdown-item" href="index.php?controller=update">Update profile</a></li>
                                                  <li><a class="dropdown-item" href="index.php?controller=change">Change password</a></li>
                                                  <li><a class="dropdown-item" href="index.php?controller=logout">Logout</a>
                                                  </li>
                                              </ul>
                                          </div>
                                          ';
                                  }
                                  */
                                ?>
                      

                    
                      </nav>
                </div>






    <div class="container d-flex flex-wrap justify-content-center">
      </div>

  </header>
  </div>   
  <div class="container">