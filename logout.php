<?php
session_start();

/* ล้าง session */
$_SESSION = [];

/* ทำลาย session */
session_destroy();

/* redirect */
header("Location: login.php");
exit();
