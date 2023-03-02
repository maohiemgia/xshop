<?php
if (session_status() === PHP_SESSION_NONE) {
     session_start();
}
require_once '../global.php';

$_SESSION['menu'] = 3;

if (!isset($_SESSION['userLogin']) || $_SESSION['userLogin']['user_role'] == 0) {
     header('location: ../index.php');
     exit();
}
$sql = "select * from `category`";
$cateArr = queryDB($sql, 1);

if (!isset($_GET['cateid'])) {
     header('location: ../index.php');
     exit();
} else {
     $idQuery = $_GET['cateid'];
}

$sql = "SELECT
p.*,
c.category_name
FROM
`product` p
LEFT JOIN category c ON
c.category_id = p.category_id
WHERE `product_id` = '$idQuery'
ORDER BY
product_date_added
DESC
";
$productArrDB = queryDB($sql, 1, 0);

$bug_img = true;
$inp_img_name = $productArrDB['product_img'];
$inp_dateadd = $productArrDB['product_date_added'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
     if (!isset($err)) {
          $err = array();
     }

     $inp_name = strtolower($_POST['productname']);
     $inp_price = $_POST['productprice'];
     $inp_quantity = $_POST['productquantity'];
     $inp_cate = $_POST['productcate'];
     $inp_sale = $_POST['productsale'];
     $inp_special = $_POST['productspecial'];
     $inp_descr = $_POST['mota'];

     if (!isset($productArrDB['product_date_added']) || !empty($_POST['productdateadd'])) {
          $inp_dateadd = $_POST['productdateadd'];
     }

     // validate date add
     if (empty($inp_dateadd)) {
          $err['date'] = "Lỗi chưa chọn thời gian";
     }

     if (!isset($productArrDB['product_img']) || !empty($_FILES['productimg']['name'])) {
          $inp_img = $_FILES['productimg'];

          // validate img
          $img_tail = array('jpg', 'png', 'gif', 'jpeg');
          if ($inp_img['size'] < 1) {
               $err['img'] = $errorArr['oversize'];
          } else if ($inp_img['size'] > 3072000) { // <3mb
               $err['img'] = $errorArr['oversize'] . ". Quá lớn";
          } else {
               $upload_ext = pathinfo($inp_img['name'], PATHINFO_EXTENSION);
               if (!in_array($upload_ext, $img_tail)) {
                    $err['img'] = $errorArr['wrong'] . ". Chỉ hỗ trợ JPG, PNG, GIF, JPEG";
               }
          }

          $bug_img = false;
          $inp_img_name = $inp_img['name'];
     }

     //validate name
     if (empty($inp_name)) {
          $err['name'] = $errorArr['empty'];
     } else if (strlen($inp_name) < 2 || strlen($inp_name) > 200) {
          $err['name'] = $errorArr['length'] . " Trong khoảng 2 đến 200 ký tự!";
     }

     // validate price
     if ($inp_price < 0 || $inp_price > 999999999) {
          $err['price'] = $errorArr['wrong'] . " Trong khoảng 0 đến 999999999!";
     }

     // validate quantitty
     if ($inp_quantity < 0 || $inp_quantity > 999999999) {
          $err['quantity'] = $errorArr['wrong'] . " Trong khoảng 0 đến 999999999!";
     }

     // validate sale
     if ($inp_sale < 0 || $inp_sale > 100) {
          $err['sale'] = $errorArr['wrong'] . " Trong khoảng 0 đến 100!";
     }

     // validate description
     if (empty($inp_descr)) {
          $inp_descr = 'không có mô tả';
     } else if (strlen($inp_descr) > 1500) {
          $err['des'] = $errorArr['length'] . " Tối đa 1500 ký tự!";
     }



     if (empty($err)) {
          $productId = $productArrDB['product_id'];
          $notifi = "Cập nhật thành công";

          if ($bug_img == false) {
               move_uploaded_file($inp_img['tmp_name'], '../content/img/' . $inp_img_name);
          }

          $sql = "UPDATE
               `product`
          SET
               `product_name` = '$inp_name',
               `product_price` = '$inp_price',
               `product_img` = '$inp_img_name',
               `product_quantity` = '$inp_quantity',
               `product_description` = '$inp_descr',
               `category_id` = '$inp_cate',
               `product_date_added` = '$inp_dateadd',
               `product_discount` = '$inp_sale',
               `product_special` = '$inp_special'
          WHERE
               `product_id` = '$productId'";

          queryDB($sql);
          header('location: ./product.php?mess=Sửa thành công');
     }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>admin - insert category</title>
     <link rel="stylesheet" href="../content/css/login.css">
     <link rel="stylesheet" href="../content/css/profile.css">
     <link rel="stylesheet" href="../content/css/manage.css">
     <link rel="stylesheet" href="../content/css/productdetail.css">
</head>

<body>
     <?php
     require_once "../site/menu.php";
     ?>

     <div class="row mx-0 manage-link-section p-3 ps-sm-5" style="min-height: 300px;">
          <h2 class="text-capitalize fw-bold fs-2 px-0">Sửa hàng hóa</h2>

          <!-- <p class="error text-danger fw-bold text-capitalize text-decoration-underline">
               <?= isset($err) ? $err : '' ?>
          </p> -->
          <form action="" method="post" enctype="multipart/form-data">
               <label class="px-0 py-2" for="#">Mã hàng hóa</label>
               <input type="text" class="w-50 d-block inputid" placeholder="auto number" value="<?= $productArrDB['product_id'] ?>" readonly>

               <label class="px-0 py-2" for="#">tên hàng hóa</label>
               <input type="text" class="w-75 d-block inputname" placeholder="nhập tên hàng" name="productname" value="<?= $productArrDB['product_name'] ?>">
               <p class="error text-danger fw-bold text-capitalize text-decoration-underline">
                    <?= isset($err['name']) ? $err['name'] : '' ?>
               </p>

               <label class="px-0 py-2" for="#">đơn giá (vnđ)</label>
               <input type="number" class="w-50 d-block inputname" placeholder="nhập giá hàng" name="productprice" value="<?= $productArrDB['product_price'] ?>">
               <p class="error text-danger fw-bold text-capitalize text-decoration-underline">
                    <?= isset($err['price']) ? $err['price'] : '' ?>
               </p>

               <label class="px-0 py-2" for="#">số lượng</label>
               <input type="number" class="w-50 d-block inputname" placeholder="nhập số lượng hàng" name="productquantity" value="<?= $productArrDB['product_quantity'] ?>">
               <p class="error text-danger fw-bold text-capitalize text-decoration-underline">
                    <?= isset($err['quantity']) ? $err['quantity'] : '' ?>
               </p>

               <label class="px-0 py-2 d-flex" for="#">loại hàng
                    <select name="productcate" class="ms-5">
                         <?php foreach ($cateArr as $c) : ?>
                              <option value="<?= $c['category_id'] ?>" <?= $c['category_id'] ==  $productArrDB['category_id'] ? 'selected' : '' ?>>
                                   <?= $c['category_name'] ?>
                              </option>
                         <?php endforeach; ?>
                    </select>
               </label>
               <label class="px-0 py-2" for="#">ngày nhập</label>
               <input type="datetime-local" class="w-sm-25 d-block inputname" placeholder="nhập ngày nhập hàng" name="productdateadd" value="<?= $productArrDB['product_date_added'] ?>">
               <p class="error text-danger fw-bold text-capitalize text-decoration-underline">
                    <?= isset($err['date']) ? $err['date'] : '' ?>
               </p>

               <label class="px-0 py-2" for="#">hình ảnh</label>
               <input type="file" class="w-100 inputname" name="productimg">
               <img src="../content/img/<?= $productArrDB['product_img'] ?>" alt="img" style="max-width: 150px;">
               <p class="error text-danger fw-bold text-capitalize text-decoration-underline">
                    <?= isset($err['img']) ? $err['img'] : '' ?>
               </p>

               <label class="px-0 py-2" for="#">giảm giá (%)</label>
               <input type="number" value="<?= $productArrDB['product_discount'] ?>" class="w-sm-25 d-block inputname" placeholder="nhập % giảm giá" name="productsale">
               <p class="error text-danger fw-bold text-capitalize text-decoration-underline">
                    <?= isset($err['sale']) ? $err['sale'] : '' ?>
               </p>

               <label class="px-0 py-2" for="#">số lượt xem</label>
               <input type="number" value="<?= $productArrDB['product_views'] ?>" class="w-25 d-block inputname" name="productview" placeholder="0" readonly style="background: #e6e6e6;">

               <label class="px-0 py-2 d-flex" for="#">kiểu hàng
                    <select name="productspecial" class="ms-5">
                         <option value="0" <?= $productArrDB['product_special'] == 0 ? 'selected' : '' ?>>
                              hàng bình thường
                         </option>
                         <option value="1" <?= $productArrDB['product_special'] == 1 ? 'selected' : '' ?>>
                              hàng đặc biệt
                         </option>
                    </select>
               </label>

               <label class="px-0 py-2 d-flex" for="#">Mô tả</label>
               <textarea class="p-2" name="mota" cols="30" rows="10" placeholder="mô tả sản phẩm"><?= $productArrDB['product_description'] ?></textarea>
               <p class="error text-danger fw-bold text-capitalize text-decoration-underline">
                    <?= isset($err['des']) ? $err['des'] : '' ?>
               </p>
               <br>

               <input class="insert_foot_btn" type="submit" value="cập nhật">
               <a class="insert_foot_btn" href="./product.php">Trở về</a>
          </form>
     </div>
     <!-- footer -->
     <?php require_once "../site/footer.php"; ?>

</body>

</html>