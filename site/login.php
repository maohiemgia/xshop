<?php
if (session_status() === PHP_SESSION_NONE) {
     session_start();
}
require_once '../global.php';

$_SESSION['menu'] = 1;

if (isset($_SESSION['userLogin'])) {
     header('location: ../index.php');
     exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $inp_account = $inp_password = '';

     if (empty($_POST['account'])) {
          $err = $errorArr['empty'];
     } else {
          $inp_account = $_POST['account'];
     }
     if (empty($_POST['password'])) {
          $err = $errorArr['empty'];
     } else {
          $inp_password = $_POST['password'];
     }

     if (empty($err)) {
          $sql = "SELECT
               *
          FROM
               `user`
          WHERE
          `username` = '$inp_account'";

          // key and value
          $accountresult = queryDB($sql, 1);

          if (count($accountresult) < 1) {
               $err = $errorArr['wrong'];
          } else {
               // if ($inp_password == $accountresult[0]['password']) {
               if (password_verify($inp_password, $accountresult[0]['password'])) {
                    $_SESSION['userLogin'] = $accountresult[0];
                    // giới hạn thời gian đăng nhập bởi time() sau đó sẽ auto logout
                    setcookie('limit_time_login', 'logined', time() + 60 * 15, '/');
                    header("Location: ../index.php");
                    exit();
               }
          }
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
</head>

<body>
     <?php
     require_once "menu.php";
     ?>
     <!-- slider -->
     <div class="col col-sm-6 mx-auto">
          <div class="row px-0">
               <p class="section-header page-main-header">Đăng Nhập</p>
          </div>
          <form action="" method="post">
               <div class="row px-0 align-items-start form-div-row mx-auto">
                    <p class="error text-danger fw-bold text-capitalize text-decoration-underline">
                         <?= isset($err) ? $err : '' ?>
                    </p>
                    <label class="px-0 py-2" for="#">Tài khoản</label>
                    <input type="text" name="account" placeholder="nhập tài khoản" autofocus>
                    <label class="px-0 py-2" for="#">Mật khẩu</label>
                    <input type="password" name="password" placeholder="********">
                    <input type="submit" value="Đăng Nhập">
                    <div class="row mt-2 mx-0 px-0 other-option d-flex align-items-center justify-content-between">
                         <a href="./forgetpass.php">Quên mật khẩu</a>
                         <a href="./register.php">Đăng ký tài khoản</a>
                    </div>
               </div>
          </form>
     </div>

     <!-- footer -->
     <?php require_once "footer.php"; ?>

</body>

</html>