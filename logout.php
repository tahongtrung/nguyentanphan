<?php
session_start();
ob_start();
session_destroy();
header("Location: /thuctap/index.php");
?>