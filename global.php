<?php
if (session_status() === PHP_SESSION_NONE) {
     session_start();
}

$errorArr = [
     "empty" => "Lỗi chưa nhập",
     "wrong" => "Lỗi nhập sai",
     "length" => "Lỗi số lượng ký tự không phù hợp",
     "oversize" => "Kích cỡ không phù hợp"
];

// declare database infor
$host = 'localhost';
$dbname = 'xshop';
$usernameDB = 'root';
$passwordDB = '';

// connect to database
try {
     $connect = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usernameDB, $passwordDB);
} catch (PDOException $err) {
     echo "connect bug:<br>" . $err->getMessage();
}

// query to database function
// includes query, fetchdata from database
function queryDB($sql, $fetchData = false, $fetchAll = true)
{
     global $connect;
     try {
          $stmt = $connect->prepare($sql);
          $stmt->execute();
          if ($fetchData) {
               if ($fetchAll) {
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
               }
               return $stmt->fetch(PDO::FETCH_ASSOC);
          }
     } catch (PDOException $err) {
          echo "Query to DB bug:<br>" . $err->getMessage();
     } finally {
          unset($stmt, $connect);
     }
}


function alertResult($mess)
{
     echo "<script> alert('$mess') </script>";
}

function check_input($data)
{
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     return $data;
}

// Function to get the client IP address
function get_client_ip()
{
     $ipaddress = '';
     if (getenv('HTTP_CLIENT_IP'))
          $ipaddress = getenv('HTTP_CLIENT_IP');
     else if (getenv('HTTP_X_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
     else if (getenv('HTTP_X_FORWARDED'))
          $ipaddress = getenv('HTTP_X_FORWARDED');
     else if (getenv('HTTP_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_FORWARDED_FOR');
     else if (getenv('HTTP_FORWARDED'))
          $ipaddress = getenv('HTTP_FORWARDED');
     else if (getenv('REMOTE_ADDR'))
          $ipaddress = getenv('REMOTE_ADDR');
     else
          $ipaddress = 'UNKNOWN';
     return $ipaddress;
}


// function redirectTo($location, $confirm = false)
// {
//      if ($confirm) {
//           echo "<script> window.location.replace('$location') </script>";
//      }
// }


// kiểm tra xem người dùng login chưa?
// function checkUserLogin($redirectStat = 0)
// {
//      if ($redirectStat == 1) {
//           if (!isset($_SESSION['userLogin'])) {
//                header('location: ../login page/login.php');
//                die;
//           }
//      }

//      if (!isset($_COOKIE['limit_time_login'])) {
//           $message = 'Time login expired \nPlease re-login';
//           echo "<script>alert('$message');</script>";

//           unset($_SESSION['userLogin']);
//           header("Refresh:0");
//      }

//      if (isset($_SESSION['userLogin'])) {
//           $username = $_SESSION['userLogin'];
//      }
// }
