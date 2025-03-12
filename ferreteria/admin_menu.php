<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'administrador') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú del Administrador</title>
    <!-- Enlace a Bootstrap CSS para estilo responsivo -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 50px;
            background: url('https://cdn.pixabay.com/photo/2019/03/29/04/35/tools-4088531_960_720.jpg') no-repeat center center fixed;
            background-size: cover;
            background-blend-mode: overlay;
            background-color: rgba(255, 255, 255, 0.5); /* Ajusta la transparencia aquí */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">Menú del Administrador</h1>
        <div class="list-group mt-3">
            <!-- Enlaces a las diferentes funcionalidades del administrador -->
            <a href="modificar_datos.php" class="list-group-item list-group-item-action">Modificar Producto</a>
            <a href="modificar_datos.php" class="list-group-item list-group-item-action">Eliminar Producto</a>
            <a href="añadir_producto.php" class="list-group-item list-group-item-action">Añadir Producto</a> <!-- Nuevo enlace -->
            <a href="validar.php" class="list-group-item list-group-item-action">Validar Administradores</a>
            <a href="leer_usuarios.php" class="list-group-item list-group-item-action">Usuarios</a>
            <a href="logout.php" class="list-group-item list-group-item-action">Cerrar Sesión</a>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
