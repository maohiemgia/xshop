<?php
if (session_status() === PHP_SESSION_NONE) {
     session_start();
}
require_once '../global.php';

if (isset($_GET['outmanager'])) {
     $_SESSION['outmanager'] = $_GET['outmanager'];
     if ($_SESSION['outmanager'] == 1) {
          header('location: ../admin/adminhomepage.php');
     } else {
          header('location: ../index.php');
     }
}
