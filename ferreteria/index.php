<?php
session_start();

// Verificar si las cookies están establecidas
if (isset($_COOKIE['usuario']) && isset($_COOKIE['rol'])) {
    $_SESSION['usuario'] = $_COOKIE['usuario'];
    $_SESSION['rol'] = $_COOKIE['rol'];
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ferretería</title>
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
        .center-text {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">Bienvenidos a la Ferretería</h1>
        <p class="center-text">Tu ferretería de confianza</p>
        <div class="text-center mt-3">
            <a href="login.php" class="btn btn-primary">Iniciar Sesión</a>
        </div>
    </div>
    <!-- Enlace a Bootstrap JS y dependencias -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
