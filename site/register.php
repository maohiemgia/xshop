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
     $inp_account = $inp_password = $inp_email = '';

     if (
          empty($_POST['account'])
          || empty($_POST['password']) || empty($_POST['email'])
     ) {
          $err = $errorArr['empty'] . " hết các phần!";
     }
     if (
          !empty($_POST['account'])
          && !empty($_POST['password']) && !empty($_POST['email'])
     ) {
          $inp_account = strtolower($_POST["account"]);
          $inp_password = $_POST['password'];
          $inp_email = strtolower($_POST["email"]);


          $sql = "SELECT
               `username`,
               `password`,
               `user_email`,
               `user_active`
          FROM
               `user`
          ";
          $userArr = queryDB($sql, 1);

          if (strlen($inp_account) < 5 || strlen($inp_account) > 20) {
               $err1 = "Tài khoản từ 5 đến 20 ký tự";
          } else {
               foreach ($userArr as $u) {
                    if ($u['username'] == $inp_account) {
                         $err = "Tài khoản đã tồn tại!!!";
                         $accAble = 1;
                         break;
                    }
                    $accAble = 0;
               }
               if ($accAble == 0) {
                    $uppercase = preg_match('@[A-Z]@', $inp_password);
                    $lowercase = preg_match('@[a-z]@', $inp_password);
                    $number    = preg_match('@[0-9]@', $inp_password);
                    $specialChars = preg_match('@[^\w]@', $inp_password);

                    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($inp_password) < 8 || strlen($inp_password) > 16) {
                         $err2 = 'Mật khẩu từ 8 đến 16 ký tự, bao gồm ít nhất 1 chữ in hoa, 1 số và một ký tự đặc biệt.';
                    } else {
                         if (!filter_var($inp_email, FILTER_VALIDATE_EMAIL)) {
                              $err3 = $errorArr['wrong'] . " Invalid email format";
                         } else {
                              foreach ($userArr as $u) {
                                   if ($u['user_email'] == $inp_email) {
                                        $err3 = "Email này đã tồn tại!!!";
                                        break;
                                   }
                              }
                         }
                    }
               }
          }
     }

     if (empty($err) && empty($err1) && empty($err2) && empty($err3)) {
          // encode password
          $passwordEncode = password_hash($inp_password, PASSWORD_DEFAULT);

          $sql = "INSERT INTO `user`(
               `username`,
               `password`,
               `user_email`
           )
           VALUES(
               '$inp_account',
               '$passwordEncode',
               '$inp_email'
           )";
          $_SESSION['temps_sql'] = $sql;

          // $mess = "Đăng ký tạm thời thành công. Vui lòng vào email đã đăng ký để nhận mã kích hoạt tài khoản.";
          // alertResult($mess);

          $randomNumber = rand(10000, 99999);
          $email_confirm_code = $randomNumber;

          setcookie('cookie_email_code', $email_confirm_code, time() + 60 * 10);     // live 10 phút

          $email_subject = 'Mã xác nhận';
          $email_body = "<br>Dưới đây là mã xác nhận của bạn:
          <br>------------------------------------------------------------------------------------------------------------------<br>
          Code: $email_confirm_code
          <br>Mã xác nhận sẽ bị vô hiệu hóa sau 10 phút.
          <br>------------------------------------------------------------------------------------------------------------------<br>
          <br>";

          $send_email = true;
          require_once '../dao/sendemail.php';
          header("location: ./confirmemailcode.php?register=123");
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
</head>

<body>
     <?php
     require_once "menu.php";
     ?>
     <!-- slider -->
     <div class="col col-sm-6 mx-auto">
          <div class="row px-0">
               <p class="section-header page-main-header">Đăng Ký</p>
          </div>
          <form action="" method="post">
               <div class="row px-0 align-items-start form-div-row mx-auto">
                    <p class="error text-danger fw-bold text-capitalize text-decoration-underline">
                         <?= isset($err) ? $err : '' ?>
                    </p>
                    <label class="px-0 py-2" for="#">Tài khoản</label>
                    <input type="text" name="account" placeholder="nhập tài khoản" value="<?= !empty($inp_account) ? $inp_account : '' ?>" autofocus>
                    <p class="error text-danger fw-bold text-capitalize text-decoration-underline">
                         <?= isset($err1) ? $err1 : '' ?>
                    </p>
                    <label class="px-0 py-2" for="#">Mật khẩu</label>
                    <input type="password" name="password" placeholder="********">
                    <p class="error text-danger fw-bold text-capitalize text-decoration-underline">
                         <?= isset($err2) ? $err2 : '' ?>
                    </p>
                    <label class="px-0 py-2" for="#">Email</label>
                    <input type="email" name="email" placeholder="nhập email" value="<?= !empty($inp_email) ? $inp_email : '' ?>">
                    <p class="error text-danger fw-bold text-capitalize text-decoration-underline">
                         <?= isset($err3) ? $err3 : '' ?>
                    </p>

                    <input type="submit" value="Đăng ký">
                    <div class="row mt-2 mx-0 px-0 other-option d-flex align-items-center justify-content-between">
                         <a href="./forgetpass.php">Quên mật khẩu</a>
                         <a href="./login.php">Đăng nhập tài khoản</a>
                    </div>
               </div>
          </form>
     </div>

     <!-- footer -->
     <?php require_once "footer.php"; ?>

</body>

</html>