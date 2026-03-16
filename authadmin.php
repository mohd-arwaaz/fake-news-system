<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: admin.php");
    exit();
}
?>
