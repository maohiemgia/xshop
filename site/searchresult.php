<?php
session_start();
require_once '../global.php';

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

if (isset($_GET['product_name'])) {
     $product_name = $_GET['product_name'];

     $sql = "SELECT
          *
     FROM
          `product`
     WHERE
          `product_name` LIKE '%$product_name%'
     ORDER BY
          `product_date_added`
     DESC";

     $_SESSION['productSearchSql'] = $sql;
     $_SESSION['productSearchStatus'] = true;

     header("location: ../index.php?searchResult=$product_name");
} else {
     header("location: ../index.php");
}
