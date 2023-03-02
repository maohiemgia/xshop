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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $inp_nickname = '';
     $username = $_SESSION['userLogin']['username'];

     if (empty($_POST['nickname'])) {
          $err = $errorArr['empty'];
     } else if (strlen($_POST['nickname']) > 45) {
          $err = $errorArr['length'];
     } else {
          $inp_nickname = $_POST['nickname'];
     }

     if (empty($err)) {
          $sql = "UPDATE
               `user`
          SET
               `user_nickname` = '$inp_nickname'
          WHERE
               `username` = '$username'";
          $accountresult = queryDB($sql);
          $_SESSION['userLogin']['user_nickname'] = $inp_nickname;
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
               <p class="section-header page-main-header">Thông tin người dùng</p>
               <div class="row px-0 mx-auto row-avatar">
                    <img class="img-fluid" src="../content/img/<?= $_SESSION['userLogin']['user_avatar'] ?>" alt="avatar">
               </div>
          </div>
          <form action="" method="post" class="col-10 col-sm-5 mx-auto mx-sm-0">
               <div class="col px-0 align-items-start form-div-row mx-auto mx-sm-0">
                    <p class="error text-danger fw-bold text-capitalize text-decoration-underline">
                         <?= isset($err) ? $err : '' ?>
                    </p>
                    <label class="px-0 py-2" for="#">Nick name</label>
                    <input type="text" class="w-100" name="nickname" value="<?= $_SESSION['userLogin']['user_nickname'] ?>">
                    <input type="submit" class="w-100" value="Cập nhật">
                    <label class="px-0 py-2" for="#">Tài khoản: <span class="span-display"><?= $_SESSION['userLogin']['username'] ?></span></label>
                    <label class="px-0 py-2" for="#">Email: <span class="span-display"><?= $_SESSION['userLogin']['user_email'] ?></span></label>
                    <div class="row mt-2 mx-0 px-0 other-option">
                         <a href="./changeavt.php">Đổi ảnh avatar</a>
                         <a href="./sendemailcode.php">Đổi mật khẩu</a>
                    </div>
                    <br>
                    <div class="row mt-2 mx-0 px-0 d-flex align-items-center justify-content-between">
                         <?php if ($_SESSION['userLogin']['user_role'] == 1) : ?>
                              <?php if (isset($_SESSION['outmanager']) && $_SESSION['outmanager'] == 1) : ?>
                                   <a href="../site/thoatquantri.php?outmanager=0" class="text-warning fw-bold px-0 w-auto">Thoát quản trị website</a>
                              <?php else : ?>
                                   <a href="../site/thoatquantri.php?outmanager=1" class="text-warning fw-bold px-0 w-auto">Quản trị website</a>
                              <?php endif; ?>
                              <a href="./logout.php" class="text-danger fw-bold px-0 w-auto" onclick="return confirm('Đăng xuất thật sự')">Đăng xuất</a>
                         <?php else : ?>
                              <a href="./logout.php" class="text-danger fw-bold px-0 w-auto" onclick="return confirm('Đăng xuất thật sự')">Đăng xuất</a>
                         <?php endif; ?>
                    </div>
               </div>
          </form>
     </div>

     <!-- footer -->
     <?php require_once "footer.php"; ?>

</body>

</html>