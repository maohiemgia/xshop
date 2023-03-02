<?php
session_start();

if (isset($_SESSION['categorySelected'])) {
     $_SESSION['categorySelected'] = array();
}

if (isset($_SESSION['price_start'])) {
     $_SESSION['price_start'] = '';
}

if (isset($_SESSION['price_end'])) {
     $_SESSION['price_end'] = '';
}

if (isset($_SESSION['orderbywhat'])) {
     $_SESSION['orderbywhat'] = '';
}

if (isset($_SESSION['querySql'])) {
     $_SESSION['querySql'] = '';
}

header('location: ../index.php');
