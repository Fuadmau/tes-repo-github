<?php
session_start();

$key = $_GET['id'];

unset($_SESSION['cart'][$key]);

header("Location: keranjang.php");
?>
