<?php
session_start();
unset($_SESSION['us']);
unset($_SESSION['pas']);
unset($_SESSION['loggedin']);
unset($_SESSION['start']);
unset($_SESSION['expire']);
unset($_SESSION['id']);

header('location:index.php');
?>