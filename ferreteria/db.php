<?php
// Datos de conexión a la base de datos
$host = "localhost:3307";  // Nombre del servidor de la base de datos
$user = "root";       // Nombre de usuario para la base de datos
$password = "";       // Contraseña para la base de datos
$dbname = "ferreteria";  // Nombre de la base de datos

// Crear conexión con la base de datos usando mysqli
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar si la conexión ha fallado
if ($conn->connect_error) {
    // Mostrar mensaje de error y terminar la ejecución del script
    die("Conexión fallida: " . $conn->connect_error);
}
?>
