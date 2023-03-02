<?php
if (session_status() === PHP_SESSION_NONE) {
     session_start();
}
require_once '../global.php';

$_SESSION['menu'] = 1;

if (!isset($_SESSION['userLogin']) && !isset($_COOKIE['change_pass_verify']) || !isset($_SESSION['email_code_true']) &&  $_SESSION['email_code_true'] != 5) {
     header('location: login.php');
     exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $inp_newpassword = $inp_confirmnewpassword = '';

     if (isset($_COOKIE['forget_password'])) {
          $cookie_email = $_COOKIE['forget_password'];
          $sql = "SELECT
                    *
               FROM
                    `user`
               WHERE
                    `user_email` LIKE '%$cookie_email%';";
          $userchanging = queryDB($sql, 1, 0);
     } else {
          $username = '';
          if (isset($_SESSION['userLogin']['username'])) {
               $username = $_SESSION['userLogin']['username'];
               $userchanging = $_SESSION['userLogin'];
          }
     }

     if (empty($_POST["newpassword"]) || empty($_POST["confirmnewpassword"])) {
          $err = $errorArr['empty'];
     }
     if (!empty($_POST["newpassword"]) && !empty($_POST["confirmnewpassword"])) {
          $inp_newpassword = $_POST["newpassword"];
          $inp_confirmnewpassword = $_POST["confirmnewpassword"];


          if (!($inp_newpassword == $inp_confirmnewpassword)) {
               $err = $errorArr['wrong'] . " phần Xác nhận mật khẩu mới";
          } else {

               // encode password
               $passwordEncode = password_hash($inp_newpassword, PASSWORD_DEFAULT);

               if (isset($_COOKIE['forget_password'])) {
                    $cookie_email = $_COOKIE['forget_password'];
                    $sql = "UPDATE
                              `user`
                         SET
                              `password` = '$passwordEncode'
                         WHERE
                              `user_email` = '$cookie_email'";
               } else {
                    $username = '';
                    if (isset($_SESSION['userLogin']['username'])) {
                         $username = $_SESSION['userLogin']['username'];
                    }
                    $sql = "UPDATE
                              `user`
                         SET
                              `password` = '$passwordEncode'
                         WHERE
                              `username` = '$username'";
               }

               queryDB($sql);

               if (isset($_COOKIE['change_pass_verify'])) {
                    setcookie('change_pass_verify', 'cookie deleted', 1);
               }
               if (isset($_COOKIE['forget_password'])) {
                    setcookie('forget_password', 'cookie deleted', 1);
               }
               if (isset($_SESSION['email_code_true'])) {
                    setcookie('email_code_true', 'cookie deleted', 1);
               }


               header("location: ../index.php?notipasschange");
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
               <p class="section-header page-main-header">Đổi mật khẩu</p>
          </div>
          <form action="" method="post" enctype="multipart/form-data" class="col-10 col-sm-3 mx-auto mx-sm-auto">
               <div class="col px-0 align-items-start form-div-row mx-auto mx-sm-auto">
                    <p class="error text-danger fw-bold text-capitalize text-decoration-underline">
                         <?= isset($err) ? $err : '' ?>
                    </p>
                    <p class="error text-success fw-bold text-capitalize text-decoration-underline">
                         <?= isset($notifi) ? $notifi : '' ?>
                    </p>

                    <label class="px-0 py-2" for="#">Mật khẩu mới</label>
                    <input type="password" class="w-100" name="newpassword" placeholder="********" autofocus>
                    <label class="px-0 py-2" for="#">xác nhận mật khẩu mới</label>
                    <input type="password" class="w-100" name="confirmnewpassword" placeholder="********">

                    <input type="submit" class="w-100" value="Thay Đổi">
               </div>
          </form>
     </div>

     <!-- footer -->
     <?php require_once "footer.php"; ?>

</body>

</html>