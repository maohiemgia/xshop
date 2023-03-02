<?php
if (session_status() === PHP_SESSION_NONE) {
     session_start();
}
require_once '../global.php';

$_SESSION['menu'] = 1;

if (
     !isset($_SESSION['userLogin']) && !isset($_COOKIE['change_pass_verify'])
     && !isset($_GET['register'])
) {
     header('location: login.php');
     exit();
}

if (!isset($_COOKIE['cookie_email_code'])) {
     $mess = "Đã quá thời hạn, vui lòng tạo lại mã";
     alertResult($mess);

     header("Refresh:1; url=login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $inp_emailcode = '';

     if (empty($_POST["emailcodeconfirm"])) {
          $err = $errorArr['empty'];
     } else {
          $inp_emailcode = $_POST["emailcodeconfirm"];
          if ($inp_emailcode != $_COOKIE['cookie_email_code']) {
               $err = $errorArr['wrong'] . " Not this code";
          } else {
               setcookie('cookie_email_code', 'cookie deleted', 1);

               if (isset($_GET['register'])) {
                    $sql = $_SESSION['temps_sql'];
                    queryDB($sql);
                    header("location: ../index.php?messnoti");
               } else {
                    $_SESSION['email_code_true'] = 5;
                    header("location: ./changepass.php");
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
     <link rel="stylesheet" href="../content/css/profile.css">
</head>

<body>
     <?php
     require_once "menu.php";
     ?>

     <!-- slider -->
     <div class="col mx-auto">
          <div class="col-12 col-sm-3 px-0 mx-auto">
               <p class="section-header page-main-header">Nhập mã xác thực email</p>
          </div>
          <form action="" method="post" enctype="multipart/form-data" class="col-10 col-sm-3 mx-auto mx-sm-auto">
               <div class="col px-0 align-items-start form-div-row mx-auto mx-sm-auto">
                    <p class="error text-danger fw-bold text-capitalize text-decoration-underline">
                         <?= isset($err) ? $err : '' ?>
                    </p>
                    <p class="error text-success fw-bold text-capitalize text-decoration-underline">
                         <?= isset($notifi) ? $notifi : '' ?>
                    </p>
                    <label class="px-0 py-2" for="#">Nhập mã</label>
                    <input type="number" class="w-100" name="emailcodeconfirm" placeholder="nhập mã xác thực đã nhận được">
                    <input type="submit" class="w-100" value="Xác thực">
               </div>
          </form>
     </div>

     <!-- footer -->
     <?php require_once "footer.php"; ?>

</body>

</html>