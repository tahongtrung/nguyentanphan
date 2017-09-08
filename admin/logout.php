<?php
session_start();
ob_start();
unset($_SESSION['adminEmail']);
unset($_SESSION['adminName']);
header("Location: /thuctap/admin/index.php");
?>