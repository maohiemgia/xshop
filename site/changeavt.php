<?php
if (session_status() === PHP_SESSION_NONE) {
     session_start();
}
require_once '../global.php';

$_SESSION['menu'] = 1;

if (!isset($_SESSION['userLogin'])) {
     header('location: login.php');
     exit();
}
$img_tail = array('jpg', 'png', 'gif', 'jpeg');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $inp_avt = $_FILES['fileavt'];
     $username = $_SESSION['userLogin']['username'];

     if ($inp_avt['size'] < 1) {
          $err = $errorArr['empty'];
     } else if ($inp_avt['size'] > 3072000) { // about 3mb
          $err = $errorArr['oversize'] . ". Quá lớn";
     } else {
          $upload_ext = pathinfo($inp_avt['name'], PATHINFO_EXTENSION);
          if (!in_array($upload_ext, $img_tail)) {
               $err = $errorArr['wrong'] . ". Chỉ hỗ trợ JPG, PNG, GIF, JPEG";
          }
     }


     if (empty($err)) {
          $img_name = $inp_avt['name'];
          $notifi = "Cập nhật thành công";
          move_uploaded_file($inp_avt['tmp_name'], '../content/img/' . $img_name);
          $sql = "UPDATE
               `user`
               SET
                    `user_avatar` = '$img_name'
               WHERE
                    `username` = '$username'";
                    
          $accountresult = queryDB($sql);
          $_SESSION['userLogin']['user_avatar'] = $img_name;
     }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Home-Xshop</title>
     <link rel="stylesheet" href="../content/css/login.css">
     <link rel="stylesheet" href="../content/css/profile.css">
</head>

<body>
     <?php
     require_once "menu.php";
     ?>

     <!-- slider -->
     <div class="row mx-auto">
          <div class="col-12 col-sm-3 px-0 ms-sm-5 mx-auto mx-sm-5">
               <p class="section-header page-main-header">Đổi ảnh đại diện</p>
               <div class="row px-0 mx-auto row-avatar">
                    <img class="img-fluid" src="../content/img/<?= $_SESSION['userLogin']['user_avatar'] ?>" alt="avatar">
               </div>
          </div>
          <form action="" method="post" enctype="multipart/form-data" class="col-10 col-sm-5 mx-auto mx-sm-0">
               <div class="col px-0 align-items-start form-div-row mx-auto mx-sm-0">
                    <p class="error text-danger fw-bold text-capitalize text-decoration-underline">
                         <?= isset($err) ? $err : '' ?>
                    </p>
                    <p class="error text-success fw-bold text-capitalize text-decoration-underline">
                         <?= isset($notifi) ? $notifi : '' ?>
                    </p>
                    <label class="px-0 py-2" for="#">Tải ảnh lên</label>
                    <input type="file" class="w-100" name="fileavt">
                    <input type="submit" class="w-100" value="Cập nhật">
                    <div class="row mt-2 mx-0 px-0 other-option">
                         <a href="./profile.php" class="text-success fw-bold text-decoration-underline">Trở lại</a>
                    </div>
               </div>
          </form>
     </div>

     <!-- footer -->
     <?php require_once "footer.php"; ?>

</body>

</html>