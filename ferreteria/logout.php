<?php
// Iniciar la sesión
session_start();
// Destruir todas las variables de sesión
session_destroy();
// Redirigir al formulario de login
header("Location: login.php");
exit();
?>
