<?php
session_start();
unset($_SESSION["CEDULA"]);
unset($_SESSION["NIVEL"]);
unset($_SESSION["LOGIN"]);
session_destroy();
header("Location: ../vistas/login.php");
exit;
?>