<?php
if (session_status() === PHP_SESSION_NONE) {
     session_start();
}

require_once '../global.php';

$_SESSION['menu'] = 1;

$iStatus = 0;

if (isset($_GET['productid']) && $iStatus == 0) {
     $_SESSION['product_id_detail'] = $_GET['productid'];
     $iStatus = 1;
}
$productid =  $_SESSION['product_id_detail'];

// query comment
$sql = "SELECT
     c.*,
     u.user_nickname,
     u.user_avatar
     FROM
     `comment` c
     LEFT JOIN USER u ON
     u.username = c.username
     WHERE c.product_id = '$productid'
     ORDER BY
     c.comment_date
     DESC";
$commentresult = queryDB($sql, 1);

$categorySelected = array();

//   select to product 
$sql = "SELECT
     p.*,
     c.category_name
     FROM
     `product` p
     JOIN category c ON
     c.category_id = p.category_id
     WHERE
     `product_id` = '$productid'
     ORDER BY
     `product_date_added`
     DESC
";

//   get data
$productresult = queryDB($sql, 1, 0);      // key and value

$productPriceAfterSale =  $productresult['product_price'] - ($productresult['product_price'] * $productresult['product_discount'] / 100);

// phân trang hiển thị
if (!isset($productArr)) {
     $productArr = array();
     $productArr = array_chunk($commentresult, 3);
}

if (!isset($indexDisplay)) {
     $indexDisplay = 0;
}


if (isset($_POST['indexPage'])) {
     $indexPage = $_POST["indexPage"];
} else {
     $indexPage = 0;
}
$indexDisplay = $indexPage;



if ($_SERVER["REQUEST_METHOD"] == "POST") {
     if (empty($_POST['comment'])) {
          $err = $errorArr['empty'];
     } else if (strlen($_POST['comment']) > 250) {
          $err = $errorArr['length'] . " Tối đa là 250 ký tự";
     } else {
          $inp_username = $_SESSION['userLogin']['username'];
          $inp_comment = $_POST['comment'];
          $sql = "INSERT INTO `comment`(
               `comment_content`,
               `product_id`,
               `username`
           )
           VALUES(
               '$inp_comment',
               '$productid',
               '$inp_username'
           )";

          queryDB($sql);
          header("Refresh:0");
     }
}

//check ip user then increment view
$sql = "SELECT
`product_id`,
`product_views`
FROM
`product`
WHERE
`product_id` = '$productid'";

$productviewupdate = queryDB($sql, 1, 0);

$user_ip_address = get_client_ip();

$usercount = $productviewupdate['product_views'];

if (!isset($_COOKIE['user_ip'])) {
     setcookie('user_ip', $user_ip_address, time() + 60 * 60 * 5, "/"); // 5 hours
}

if (!isset($_SESSION['product_viewed'])) {
     $_SESSION['product_viewed'] = array();
}


if (
     isset($_COOKIE['user_ip'])
) {

     if ($_COOKIE['user_ip'] != $user_ip_address) {
          $user_ip_status = 1;
     }
     if (!in_array($productid, $_SESSION['product_viewed'])) {
          $user_ip_status = 1;
          array_push($_SESSION['product_viewed'], $productid);
     }

     if (
          isset($user_ip_status) && $user_ip_status == 1
     ) {
          $usercount++;
          $user_ip_status = 0;

          $sql = "UPDATE
          `product`
          SET
          `product_views` = '$usercount'
          WHERE
          `product_id` = '$productid'
          ";
          queryDB($sql);

          header("Refresh:0");
     }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Product Details</title>
     <link rel="stylesheet" href="../content/css/productdetail.css">
</head>

<body>
     <?php
     require_once "./menu.php";
     ?>

     <main>
          <p class="ms-sm-5 ms-4 mb-sm-5 link-title-path">
               Xshop
               <i class="fa-solid fa-chevron-right"></i>
               <?= $productresult['category_name'] ?>
               <i class="fa-solid fa-chevron-right"></i>
               <?= $productresult['product_name'] ?>
          </p>
          <div class="row mx-0">
               <div class="col-12 col-sm-4 product-img text-center">
                    <img src="../content/img/<?= $productresult['product_img'] ?>" alt="img">
               </div>
               <div class="col col-sm-8 my-3 text-center text-sm-start">
                    <p class="product-name-header fw-bolder fs-3 text-capitalize">
                         <?= $productresult['product_name'] ?>
                    </p>
                    <p class="product-view">
                         <?= $productresult['product_views'] ?>
                         <i class="fa-solid fa-eye"></i>
                    </p>
                    <p class="product-price d-flex align-items-center">
                         <!-- <i class="fa-solid fa-coins money-icon"></i> -->
                         <span class="mx-auto ps-0 mx-sm-0 beforesale <?= $productresult['product_discount'] > 0 ? 'saleprice' : 'rawprice' ?>">
                              <?= number_format($productresult['product_price']); ?>
                         </span>
                         <span class="aftersalesale <?= $productresult['product_discount'] > 0 ? 'rawprice' : 'hidden' ?>">
                              <?= number_format($productPriceAfterSale); ?>
                         </span>

                         <sup>VNĐ</sup>

                         <span class="salepercent <?= $productresult['product_discount'] > 0 ? '' : 'hidden' ?>">
                              <?= $productresult['product_discount'] > 0 ? $productresult['product_discount'] . "% giảm" : '' ?>
                         </span>
                    </p>
                    <p class="product-des mt-5">
                         <span class="fw-bolder fs-4 text-capitalize">
                              Mô tả sản phẩm:
                         </span>
                         <br>
                         <?= $productresult['product_description'] ?>
                    </p>
               </div>
          </div>
          <div class="row mx-0 ms-sm-3 mt-sm-5 mx-3 mx-sm-4">
               <p class="product-des mt-5">
                    <span class="fw-bolder fs-4 text-capitalize">
                         Bình luận (<?= count($commentresult); ?>):
                    </span>
               </p>
               <p class="text-center <?= isset($_SESSION['userLogin']) && count($_SESSION['userLogin']) > 1 ? 'hidden' : '' ?>">
                    Bạn cần
                    <a class="fw-bold fs-5" href="./login.php">Đăng nhập </a>
                    để có thể bình luận
               </p>

               <div class="row mx-0 comment-section p-sm-3 py-4 py-sm-5 mb-3 <?= isset($_SESSION['userLogin']) && count($_SESSION['userLogin']) > 1 ? '' : 'hidden' ?>">
                    <div class="row">
                         <p class="error text-danger fw-bold text-capitalize text-center text-decoration-underline">
                              <?= isset($err) ? $err : '' ?>
                         </p>
                         <div class="col-3 w-auto m-auto">
                              <img class="rounded-circle w-auto avt-comment" src="../content/img/<?= $_SESSION['userLogin']['user_avatar'] ?>" alt="image">
                              <p class="text-center w-auto fw-bold"><?= $_SESSION['userLogin']['user_nickname'] ?></p>
                         </div>
                         <div class="col w-auto">
                              <form action="" method="post">
                                   <input type="text" name="comment" placeholder="nhập bình luận vào đây" class="w-100 comment-input">
                                   <input type="submit" value="Comment" class="submit-input">
                              </form>
                         </div>
                    </div>
               </div>

               <div class="row mx-0 comment-section p-sm-3 py-5">
                    <?php if (count($productArr) > 0) : ?>
                         <?php foreach ($productArr[$indexDisplay] as $comment) : ?>
                              <div class="row py-2">
                                   <div class="col-3 w-auto m-auto">
                                        <img class="rounded-circle w-auto avt-comment" src="../content/img/<?= $comment['user_avatar'] ?>" alt="image">
                                        <p class="text-center w-auto fw-bold"><?= $comment['user_nickname'] ?></p>
                                   </div>
                                   <div class="col w-auto">
                                        <p class="date-comment fw-bold">
                                             <?php $date = date_create($comment['comment_date']); ?>
                                             <?= date_format($date, "d/m/y H:i:s") ?>
                                        </p>
                                        <p class="comment-content"><?= $comment['comment_content'] ?></p>
                                   </div>
                              </div>
                         <?php endforeach; ?>
                    <?php else : ?>
                         <p class="text-danger">Hiện chưa có bình luận nào!</p>
                    <?php endif; ?>

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
     </main>

     <!-- footer -->
     <?php require_once "./footer.php"; ?>

</body>

</html>