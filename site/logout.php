<?php
if (session_status() === PHP_SESSION_NONE) {
     session_start();
}
// unset($_SESSION['userLogin']);


session_destroy();
header('location: login.php');
die;
