<?php
session_start();
session_unset();
session_destroy();
header("Location: admin_login.php"); // Redirect to login page after logout
exit();
?>
