<?php
if (session_status() === PHP_SESSION_NONE) {
     session_start();
}
require_once '../global.php';

$_SESSION['menu'] = 1;

if (isset($_SESSION['userLogin'])) {
     header('location: login.php');
     exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $inp_email = '';

     if (empty($_POST["useremail"])) {
          $err = $errorArr['empty'];
     } else {
          $inp_email = strtolower($_POST["useremail"]);

          $sql = "SELECT
                    `user_email`
               FROM
                    `user`
               ";
          $userArr = queryDB($sql, 1);

          if (!filter_var($inp_email, FILTER_VALIDATE_EMAIL)) {
               $err = $errorArr['wrong'] . " Invalid email format";
          } else {
               foreach ($userArr as $u) {
                    if ($u['user_email'] == $inp_email) {
                         $email_status = true;
                         break;
                    }
                    $email_status = false;
               }
               if ($email_status == false) {
                    $err = "Không có email như vậy!!!";
               }
          }
     }

     if (empty($err) && $email_status == true) {
          $randomNumber = rand(10000, 99999);
          $email_confirm_code = $randomNumber;

          setcookie('cookie_email_code', $email_confirm_code, time() + 60 * 10);     // live 10 phút
          setcookie('change_pass_verify', 'in progress', time() + 60 * 10);     // live 10 phút
          setcookie('forget_password', $inp_email, time() + 60 * 60);     // live 60 phút

          $email_subject = 'Mã xác nhận';
          $email_body = "<br>Dưới đây là mã xác nhận của bạn:
          <br>------------------------------------------------------------------------------------------------------------------<br>
          Code: $email_confirm_code
          <br>Mã xác nhận sẽ bị vô hiệu hóa sau 10 phút.
          <br>------------------------------------------------------------------------------------------------------------------<br>
          <br>";


          $send_email = true;
          require_once '../dao/sendemail.php';

          header("location: ./confirmemailcode.php");
          exit();
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
               <p class="section-header page-main-header">Gửi mã tới email</p>
          </div>
          <form action="" method="post" enctype="multipart/form-data" class="col-10 col-sm-3 mx-auto mx-sm-auto">
               <div class="col px-0 align-items-start form-div-row mx-auto mx-sm-auto">
                    <p class="error text-danger fw-bold text-capitalize text-decoration-underline">
                         <?= isset($err) ? $err : '' ?>
                    </p>
                    <p class="error text-success fw-bold text-capitalize text-decoration-underline">
                         <?= isset($notifi) ? $notifi : '' ?>
                    </p>
                    <label class="px-0 py-2" for="#">Nhập email</label>
                    <input type="email" class="w-100" name="useremail" placeholder="nhập email nhận mã xác thực">
                    <input type="submit" class="w-100" value="Gửi yêu cầu">
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