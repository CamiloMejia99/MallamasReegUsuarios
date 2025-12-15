<?php
session_start();
unset($_SESSION['acceso_registro']); // elimina acceso
session_destroy(); // destruye toda la sesión

header("Location: ../index.php?salio=1");
exit;
?>
