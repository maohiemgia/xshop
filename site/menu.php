<?php
$product_name = '';
$linkString = '';
$productLinkString = '';
$imgLinkString = '';

if (isset($_SESSION['menu'])) {
     if ($_SESSION['menu'] == 1) {
          $linkString =  '../';
          $productLinkString = '';
          $imgLinkString = '../content/img/';
     } else if ($_SESSION['menu'] == 3) {
          $linkString =  '../';
          $productLinkString = '../site/';
          $imgLinkString = '../content/img/';
     } else {
          $linkString = '';
          $productLinkString = './site/';
          $imgLinkString = 'content/img/';
     }
}

if (isset($_POST['search_product'])) {
     $product_name = $_POST['search_product'];

     if ($_SESSION['menu'] == 1) {
          header("location: searchResult.php?product_name=$product_name");
     } else if ($_SESSION['menu'] == 3) {
          header("location: ../site/searchResult.php?product_name=$product_name");
     } else {
          header("location: site/searchResult.php?product_name=$product_name");
     }
}


// $_SESSION['userLogin'] = '';
// echo "<br>";
// print_r($_COOKIE);
// echo "<br>";
// print_r($_SESSION['userLogin']);
// print_r($_SESSION);


$logined = false;

if (isset($_SESSION['userLogin'])) {
     if (!empty($_SESSION['userLogin'])) {
          $logined = true;
     } else {
          $logined = false;
     }
}

$userProfileLink =  $logined ? $productLinkString . "profile.php" : $productLinkString . "login.php";

$userAvtLink = '';
if (isset($_SESSION['userLogin']) && !empty($_SESSION['userLogin']['user_avatar'])) {
     $userAvtLink = $imgLinkString . $_SESSION['userLogin']['user_avatar'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
     <!-- BS5 -->
     <!-- Latest compiled and minified CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- Latest compiled JavaScript -->
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
     <!-- fontawesome -->
     <script src="https://kit.fontawesome.com/6c87d9fedd.js" crossorigin="anonymous"></script>
     <style>
          @font-face {
               font-family: logo-font;
               src: url("content/fonts/ZCOOLKuaiLe-Regular.ttf"),
                    url("./content/fonts/ZCOOLKuaiLe-Regular.ttf"),
                    url("../content/fonts/ZCOOLKuaiLe-Regular.ttf");
          }

          @font-face {
               font-family: open-sans;
               src: url("content/fonts/OpenSans-VariableFont_wdth,wght.ttf"),
                    url("./content/fonts/OpenSans-VariableFont_wdth,wght.ttf"),
                    url("../content/fonts/OpenSans-VariableFont_wdth,wght.ttf");
          }

          /* width */
          ::-webkit-scrollbar {
               width: 10px;
          }

          /* Track */
          ::-webkit-scrollbar-track {
               background: #f1f1f1;
          }

          /* Handle */
          ::-webkit-scrollbar-thumb {
               background: #ff0056;
          }

          /* Handle on hover */
          ::-webkit-scrollbar-thumb:hover {
               background: #555;
          }

          * {
               padding: 0;
               margin: 0;
               box-sizing: border-box;
               font-family: open-sans;
          }

          .hidden {
               display: none;
          }

          .logo {
               font-family: logo-font;
               font-weight: 400;
               font-size: 30px;
               color: #ff0056 !important;
               text-transform: uppercase;
          }

          .menu-link>a {
               font-weight: 700;
               font-size: 15px;
               color: #ff0056;
               text-transform: capitalize;
          }

          .menu-link>a:hover {
               transform: scale(1.5);
          }

          .user-avt {
               font-weight: 700;
               font-size: 15px;
               color: #ff0056;
          }

          .user-avt>i {
               color: #000;
               font-size: 25px;
               padding-right: 5px;
          }

          .btn-menu-search {
               background: #ff0056;
               color: #fff;
          }

          .btn-menu-search:hover {
               background: transparent;
               border: 1px solid;
          }

          header {
               margin-bottom: 80px;
          }

          header>nav.navbar {
               border-bottom: 3px solid #ff0056;
               z-index: 9;
          }

          .login-btn {
               border: 2px solid #34b988;
               padding: 5px 12px;
          }

          .login-btn:hover {
               color: #fff;
               background: #34b988;
               border-color: transparent;
          }

          .avticon {
               width: 100%;
               max-width: 50px;
               padding:  0 5px;
               border-radius: 50%;
          }
     </style>
</head>

<body>
     <header>
          <nav class="navbar navbar-expand-sm navbar-light py-0 fixed-top bg-light mb-5">
          <!-- <nav class="navbar navbar-expand-sm navbar-light py-0 bg-light mb-5"> -->
               <div class="container-fluid">
                    <a class="navbar-brand logo" href="<?= $linkString ?>index.php">
                         xshop
                    </a>

                    <!-- Button to open the offcanvas sidebar -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#menu">
                         <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="offcanvas offcanvas-top h-100" id="menu">
                         <div class="offcanvas-header">
                              <h1 class="offcanvas-title">Menu</h1>
                              <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                         </div>
                         <div class="offcanvas-body justify-content-around align-items-center">
                              <?php if (!isset($_SESSION['outmanager']) || $_SESSION['outmanager'] == 0) : ?>
                                   <div class="col-sm-6 d-sm-flex align-items-center justify-content-end menu-link">
                                        <a class="nav-link px-0 px-sm-3" href="<?= $linkString ?>index.php">trang chủ</a>
                                        <a class="nav-link px-0 px-sm-3" href="<?= $linkString ?>index.php#product-section">sản phẩm</a>
                                        <a class="nav-link px-0 px-sm-3" href="<?= $linkString ?>index.php#aboutus-section">giới thiệu</a>
                                        <a class="nav-link px-0 px-sm-3" href="<?= $linkString ?>index.php#footer-section">liên hệ</a>
                                   </div>
                              <?php else : ?>
                                   <div class="col-sm-6 d-sm-flex align-items-center justify-content-end menu-link">
                                        <a class="nav-link px-0 px-sm-3" href="<?= $linkString ?>admin/adminhomepage.php">trang chủ</a>
                                        <a class="nav-link px-0 px-sm-3" href="<?= $linkString ?>admin/adminmanager.php">quản lý</a>
                                        <a class="nav-link px-0 px-sm-3" href="<?= $linkString ?>content/framework/thongke.php">thống kê</a>
                                        <a class="nav-link px-0 px-sm-3" href="<?= $linkString ?>site/thoatquantri.php?outmanager=0">thoát quản trị</a>
                                   </div>
                              <?php endif; ?>
                              <form class="d-flex py-3" method="POST">
                                   <input class="form-control me-2" type="text" name="search_product" placeholder="Tìm kiếm sản phẩm" value="<?= isset($searchResult) ? $searchResult : '' ?>">
                                   <button class="btn btn-menu-search" type="submit">Search</button>
                              </form>
                              <a href="<?= $userProfileLink ?>" class="user-avt text-uppercase text-decoration-none <?= $logined ? '' : 'login-btn' ?>" title="Thông tin user">
                                   <?= $logined ? $_SESSION['userLogin']['user_nickname'] . "<img src='$userAvtLink' class='avticon' alt='avt'>" : "Đăng nhập" ?>
                              </a>
                         </div>
                    </div>
               </div>
          </nav>
     </header>

</body>

</html>