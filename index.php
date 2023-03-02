<?php
if (session_status() === PHP_SESSION_NONE) {
     session_start();
}

require_once 'global.php';

$_SESSION['menu'] = 0;

if (isset($_GET['messnoti'])) {
     $mess = "Đăng ký thành công!!!";
     alertResult($mess);
}

if (isset($_GET['notipasschange'])) {
     $mess = "Đổi mật khẩu thành công!!!";
     alertResult($mess);
}

// query category
$sql = "SELECT
*
FROM
`category` ORDER BY `category_name` ASC
";

$categoryArr = queryDB($sql, 1);

if (!isset($result)) {
     //   select to product table 
     $sql = "SELECT
     *
     FROM
     `product`
     ORDER BY
     `product_date_added`
     DESC
     ";

     //   get data
     $result = queryDB($sql, 1);      // key and value
}

// phân trang hiển thị
if (!isset($productArr)) {
     $productArr = array();
     $productArr = array_chunk($result, 8);
}

if (!isset($indexDisplay)) {
     $indexDisplay = 0;
}

// for ($i = 0; $i < count($result); $i++) {
//      array_push($productArr, $result[$i]);
// }
// $productArr = array_chunk($productArr, 8);


if (isset($_POST['indexPage'])) {
     $indexPage = $_POST["indexPage"];
} else {
     $indexPage = 0;
}
$indexDisplay = $indexPage;
$nowIndexFrom = ($indexDisplay + 1) * 8;


// selected filter category
// $_SESSION['categorySelected'] = array();
$_SESSION['price_start'] = '';
$_SESSION['price_end'] = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     // selected filter price
     if (isset($_POST['price_start']) || isset($_POST['price_end'])) {
          $_SESSION['price_start'] = $_POST['price_start'];
          if ($_SESSION['price_start'] < 0) {
               $_SESSION['price_start'] = 0;
          }
          $_SESSION['price_end'] = $_POST['price_end'];
          if ($_SESSION['price_end'] < $_SESSION['price_start']) {
               $_SESSION['price_end'] = $_SESSION['price_start'] + 1;
          }
     }

     $price_s = intval($_SESSION['price_start']);
     $price_e = intval($_SESSION['price_end']);
     $price_range_sum = $price_s + $price_e;

     if (isset($_POST['checkBoxCategory']) && count($_POST['checkBoxCategory']) > 0) {
          $_SESSION['categorySelected'] = $_POST['checkBoxCategory'];
     }

     if (isset($_POST['cancel-selected'])) {
          $cateCancel = $_POST['cancel-selected'];
          $indexCancel = array_search($cateCancel, $_SESSION['categorySelected']);
          array_splice($_SESSION['categorySelected'], $indexCancel, 1);
          if (count($_SESSION['categorySelected']) < 1 && $price_range_sum <= 1) {
               header('location:dao/reset.php');
          }
     }

     if (isset($_SESSION['categorySelected']) && count($_SESSION['categorySelected']) > 0) {
          $cateSelected_display = $_SESSION['categorySelected'];


          $cateSelected = $_SESSION['categorySelected'];
          $cateSelected =  "'" . implode("','", $cateSelected) . "'";
     }

     // filter conditions
     if (
          $price_range_sum > 1 ||
          isset($_SESSION['categorySelected']) && count($_SESSION['categorySelected']) > 0
     ) {
          if (!isset($_SESSION['querySql'])) {
               $_SESSION['querySql'] = '';
          }

          if (empty($price_e)) {
               $price_e = $price_s + 1;
          }

          if (count($_SESSION['categorySelected']) > 0 && $price_range_sum <= 1) {
               $sql = "SELECT
          p.*,
          c.category_name
          FROM
               `product` p
          LEFT JOIN category c ON
               c.category_id = p.category_id
          WHERE
               c.category_name IN($cateSelected)
          ORDER BY
               p.`product_date_added`
          DESC      
          ";
          } else if (count($_SESSION['categorySelected']) <= 0 && $price_range_sum > 1) {
               $sql = "SELECT
          p.*
          FROM
               `product` p
          WHERE
               p.`product_price` >= $price_s AND p.`product_price` <= $price_e
          ORDER BY
               p.`product_date_added`
          DESC      
          ";
          } elseif (count($_SESSION['categorySelected']) > 0 && $price_range_sum > 1) {
               $sql = "SELECT
          p.*,
          c.category_name
          FROM
               `product` p
          LEFT JOIN category c ON
               c.category_id = p.category_id
          WHERE
               c.category_name IN($cateSelected) AND p.`product_price` >= $price_s AND p.`product_price` <= $price_e
          ORDER BY
               p.`product_date_added`
          DESC      
          ";
          }

          $_SESSION['querySql'] = $sql;
          //   get data
          $result = queryDB($sql, 1);      // key and value
          $productArr = array_chunk($result, 8);
     }
}

// sort by
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     global $sql;
     if (!isset($_SESSION['orderbywhat'])) {
          $_SESSION['orderbywhat'] = '';
     }

     if (!empty($_SESSION['querySql'])) {
          $sqlSortBy = $_SESSION['querySql'];
     } else {
          $sqlSortBy = $sql;
     }

     if (isset($_POST['sort-option'])) {
          $_SESSION['orderbywhat'] = $_POST['sort-option'];
     }

     $indexString = stripos($sqlSortBy, "order by");
     $newSQL = substr($sqlSortBy, 0, $indexString + 8);

     if ($_SESSION['orderbywhat'] == 1) {
          $orderType = '`product_name`';
     } else if ($_SESSION['orderbywhat'] == 2) {
          $orderType = '`product_price` DESC';
     } else if ($_SESSION['orderbywhat'] == 4) {
          $orderType = '`product_name` DESC';
     } else if ($_SESSION['orderbywhat'] == 3) {
          $orderType = '`product_price` ASC';
     } else {
          $orderType = '`product_date_added` DESC';
     }

     $sqlSortBy = str_replace(
          "ORDER BY",
          "ORDER BY $orderType",
          $newSQL
     );

     $sql = $sqlSortBy;

     $_SESSION['querySql'] = $sql;
     // key and value
     $result = queryDB($sql, 1);
     $productArr = array_chunk($result, 8);
}

if (isset($_GET['searchResult']) && $_SESSION['productSearchStatus'] == true) {
     //   get data
     $searchResult = $_GET['searchResult'];
     global $sql;
     $sql = $_SESSION['productSearchSql'];
     $_SESSION['querySql'] = $sql;

     $result = queryDB($sql, 1);      // key and value
     $productArr = array_chunk($result, 8);
     $_SESSION['productSearchStatus'] = false;
}


// setcookie('product_viewed', '0', time()+ 1, '/');
// setcookie('user_ip', '0', time()+ 1, '/');
// session_destroy();


// echo "<br>";
// echo "<br>";
// echo "<br>";
// echo "<br>";
// echo "<pre>";
// print_r($_COOKIE);
// print_r($_SESSION);
// echo "</pre>";

?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Home-Xshop</title>
     <link rel="stylesheet" href="content/css/home.css">
</head>

<body>
     <?php
     require_once "site/menu.php";
     ?>

     <!-- slider -->
     <div class="col col-sm-6 mx-auto">
          <div id="carouselExampleControls" class="carousel slide m-auto" data-ride="carousel">
               <div class="carousel-inner slide-auto">
                    <div class="carousel-item active">
                         <img class="d-block img-slide" src="content/img/default_img.jpg" alt="First slide">
                    </div>
                    <div class="carousel-item">
                         <img class="d-block img-slide" src="content/img/mehdi-messrro-yef79KkAguA-unsplash.jpg" alt="Third slide">
                    </div>
                    <div class="carousel-item">
                         <img class="d-block img-slide" src="content/img/addibanner.jpg" alt="Third slide">
                    </div>
               </div>

               <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
               </a>
               <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
               </a>
          </div>
     </div>

     <main>
          <!-- search filter -->
          <p class="section-header" id="product-section">Bộ lọc tìm kiếm</p>
          <div class="row mx-sm-0 product-found py-3 px-3 d-sm-flex flex-sm-row flex-column align-content-center align-items-center">
               <div class="col result-found">
                    <p class="text-capitalize mb-0">
                         <?= $nowIndexFrom - 7 ?> <i class="fa-solid fa-arrow-right-long"></i> <?= $nowIndexFrom > count($result) ? count($result) : $nowIndexFrom ?> trong <span style="font-weight: 700; font-size:larger">
                              <?= count($result) ?>
                         </span>
                         sản phẩm tìm thấy
                    </p>
               </div>
               <div class="col sort-by my-sm-0 my-2 d-sm-flex justify-content-sm-end align-content-center align-items-center">
                    <label for="sort-by-option">
                         <p class="fw-bold text-capitalize mb-0 pe-3 pb-2 pb-sm-0">
                              Sắp xếp theo
                         </p>
                    </label>
                    <form action="" method="post" class="mb-sm-0">
                         <select name="sort-option" id="sort-by-option">
                              <option value="1" <?= isset($_SESSION['orderbywhat']) && $_SESSION['orderbywhat'] == 1 ? 'selected' : '' ?>>Tên A-Z</option>
                              <option value="4" <?= isset($_SESSION['orderbywhat']) && $_SESSION['orderbywhat'] == 4 ? 'selected' : '' ?>>Tên Z-A</option>
                              <option value="2" <?= isset($_SESSION['orderbywhat']) && $_SESSION['orderbywhat'] == 2 ? 'selected' : '' ?>>Giá cao đến thấp</option>
                              <option value="3" <?= isset($_SESSION['orderbywhat']) && $_SESSION['orderbywhat'] == 3 ? 'selected' : '' ?>>Giá thấp đến cao</option>
                         </select>
                         <button type="submit" name="sortByName" class="btn-submit-sort">Sắp Xếp</button>
                    </form>
               </div>
          </div>

          <!-- product display -->
          <div class="row product-filter-option mx-sm-0 py-5 d-sm-flex justify-content-sm-between flex-sm-row flex-column">
               <div class="col col-sm-3 col-product">
                    <form method="POST" action="">
                         <div class="col col-filter selected-section">
                              <div class="row mx-0">
                                   <p class="col section-header">đã chọn</p>
                                   <a href="dao/reset.php" class="col reset border-0 bg-transparent text-decoration-none">Làm mới</a>
                              </div>
                              <div class="row mx-0 selected-result">
                                   <?php if (isset($_SESSION['categorySelected'])) : ?>
                                        <?php foreach ($_SESSION['categorySelected'] as $cate) : ?>
                                             <span class="my-2">
                                                  <?= $cate; ?>
                                                  <button class="cancel-selected-btn" type="submit" name="cancel-selected" value="<?= $cate; ?>">
                                                       x
                                                  </button>
                                             </span>
                                        <?php endforeach; ?>
                                   <?php endif; ?>
                              </div>
                         </div>
                         <div class="col col-filter category-section">
                              <div class="row mx-0">
                                   <p class="section-header">danh mục sản phẩm</p>
                              </div>
                              <div class="row mx-0">
                                   <?php foreach ($categoryArr as $category) : ?>
                                        <label>
                                             <input type="checkbox" name="checkBoxCategory[]" value="<?= $category['category_name'] ?>" <?php if (isset($cateSelected_display)) : ?> <?php if (in_array($category['category_name'], $cateSelected_display)) {
                                                                                                                                                                                              echo "checked";
                                                                                                                                                                                         } ?> <?php endif; ?>>
                                             <?= $category['category_name'] ?>
                                        </label>
                                   <?php endforeach ?>
                              </div>
                         </div>
                         <div class="col col-filter price-section">
                              <div class="row mx-0">
                                   <p class="section-header">giá</p>
                              </div>
                              <div class="row mx-0">
                                   <div class="col-sm-3 col-5">
                                        <input type="number" name="price_start" class="price-start" value="<?= isset($_SESSION['price_start']) ?  $_SESSION['price_start'] : '' ?>" placeholder="Từ">
                                   </div>
                                   <div class="col-sm-2 price-line d-none d-sm-block">
                                   </div>
                                   <div class="col-sm-3 col-5">
                                        <input type="number" name="price_end" class="price-end" value="<?= isset($_SESSION['price_end']) ? $_SESSION['price_end'] : '' ?>" placeholder="Đến">
                                   </div>
                                   <div class="col-sm-2 col-2 price-currency">
                                        vnđ
                                   </div>
                              </div>
                         </div>
                         <button type="submit" value="btn">Áp dụng</button>
                    </form>
               </div>
               <div class="col col-sm-8 col-product p-sm-4 mt-4 mt-sm-0 h-100">
                    <div class="row mx-0 mt-3 product-display-section">
                         <?php if (count($productArr) > 0) : ?>
                              <?php foreach ($productArr[$indexDisplay] as $product) : ?>
                                   <div class="col-6 col-sm-3 product-display">
                                        <div class="row mx-0 product-img-section">
                                             <a href="./site/productdetail.php?productid=<?= $product['product_id'] ?>" class="px-0">
                                                  <img src="content/img/<?= $product['product_img'] ?>" alt="fef">
                                                  <span>
                                                       <?= $product['product_discount'] ?>%
                                                       <br>
                                                       giảm
                                                  </span>
                                             </a>
                                        </div>
                                        <div class="row mx-0 product-infor my-2">
                                             <a href="./site/productdetail.php?productid=<?= $product['product_id'] ?>" class="text-decoration-none">
                                                  <p class="product-name">
                                                       <?= $product['product_name'] ?>
                                                  </p>
                                             </a>
                                             <p class="product-price">
                                                  <span class="product-price-display">
                                                       <?= number_format($product['product_price']) ?>
                                                  </span>
                                                  <span>
                                                       VNĐ
                                                  </span>
                                             </p>
                                        </div>
                                   </div>
                              <?php endforeach ?>
                         <?php else : ?>
                              <p class="text-danger">Không có sản phẩm nào phù hợp!</p>
                         <?php endif; ?>
                    </div>

                    <!-- display page number -->
                    <?php if (count($productArr) > 1) : ?>
                         <div class="row mx-0 pages">
                              <form action="" method="POST">
                                   <ul class="pagination justify-content-center">
                                        <li class="page-item <?= $indexDisplay <= 0 ? 'hidden' : ''; ?>">
                                             <button class="page-link-btn btn" type="submit" name="indexPage" value="<?= $indexPage - 1 ?>">
                                                  <i class="fa-solid fa-chevron-left"></i>
                                             </button>
                                        </li>
                                        <?php for ($i = 0; $i < count($productArr); $i++) : ?>
                                             <li class="page-item <?= $i == $indexDisplay ? 'active' : ''; ?>">
                                                  <button class="page-link-btn btn" type="submit" name="indexPage" value="<?= $i ?>">
                                                       <?= $i + 1 ?>
                                                  </button>
                                             </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?= $indexDisplay >= count($productArr) - 1 ? 'hidden' : ''; ?>">
                                             <button class="page-link-btn btn" type="submit" name="indexPage" value="<?= $indexPage + 1 ?>" id="aboutus-section">
                                                  <i class="fa-solid fa-chevron-right"></i>
                                             </button>
                                        </li>
                                   </ul>
                              </form>
                         </div>
                    <?php endif; ?>
               </div>
          </div>

          <!-- about us -->
          <p class="col section-header">Về chúng tôi</p>
          <div class="row product-filter-option mx-0 justify-content-between align-items-start">
               <div class="col col-sm-5 px-0 me-3">
                    <img src="content/img/mehdi-messrro-yef79KkAguA-unsplash.jpg" class="img-fluid" alt="about us img">
               </div>
               <div class="col col-sm-6 px-0">
                    <p>Xshop là hệ thống siêu thị nhỏ trên toàn quốc, kinh doanh đa dạng các mặt hàng khác nhau. Cung
                         cấp với giá cực kì ưu đãi. Khách hàng hài lòng là ưu tiên số 1</p>
               </div>
          </div>
     </main>

     <!-- footer -->
     <?php require_once "site/footer.php"; ?>

</body>

</html>