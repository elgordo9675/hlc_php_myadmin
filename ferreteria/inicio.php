<?php
// Iniciar la sesión
session_start();
// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    // Redirigir al formulario de login
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ferretería</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Bienvenidos a la Ferretería</h1>
    <?php
    // Incluir el archivo de conexión a la base de datos
    include('db.php');

    // Consultar todos los productos en la base de datos
    $sql = "SELECT * FROM productos";
    $result = mysqli_query($conn, $sql);

    // Verificar si se encontraron productos
    if (mysqli_num_rows($result) > 0) {
        // Mostrar los productos en una tabla
        echo "<table>";
        echo "<tr><th>Nombre</th><th>Descripción</th><th>Precio</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . htmlspecialchars($row["nombre"]) . "</td><td>" . htmlspecialchars($row["descripcion"]) . "</td><td>" . htmlspecialchars($row["precio"]) . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No hay productos disponibles.";
    }

    // Cerrar la conexión con la base de datos
    mysqli_close($conn);
    ?>
</body>
</html>
