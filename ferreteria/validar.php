<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario tiene rol de administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'administrador') {
    header("Location: login.php");
    exit();
}

// Incluir el archivo de conexión a la base de datos
include('db.php');

// Aprobar o rechazar solicitudes de administrador
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['aprobar'])) {
        $usuario_id = intval($_POST['usuario_id']); // Convertir a entero por seguridad
        $sql = "UPDATE usuarios SET validado = 1 WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $usuario_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: validar.php?status=aprobado");
        exit();
    } elseif (isset($_POST['rechazar'])) {
        $usuario_id = intval($_POST['usuario_id']);
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $usuario_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: validar.php?status=rechazado");
        exit();
    }
}

// Consultar administradores pendientes
$sql = "SELECT id, usuario FROM usuarios WHERE rol = 'administrador' AND validado = 0";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validar Administradores</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 50px;
            background: url('https://cdn.pixabay.com/photo/2019/03/29/04/35/tools-4088531_960_720.jpg') no-repeat center center fixed;
            background-size: cover;
            background-blend-mode: overlay;
            background-color: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">Validar Administradores</h1>
        <?php
        // Mensajes de estado después de aprobar/rechazar
        if (isset($_GET['status'])) {
            if ($_GET['status'] == 'aprobado') {
                echo "<div class='alert alert-success text-center mt-3'>Administrador aprobado correctamente.</div>";
            } elseif ($_GET['status'] == 'rechazado') {
                echo "<div class='alert alert-success text-center mt-3'>Administrador rechazado correctamente.</div>";
            }
        }

        // Verificar si hay solicitudes pendientes
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table table-bordered mt-3'>";
            echo "<thead><tr><th>Usuario</th><th>Acciones</th></tr></thead><tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>" . htmlspecialchars($row['usuario']) . "</td>
                    <td>
                        <form action='validar.php' method='post' style='display:inline;'>
                            <input type='hidden' name='usuario_id' value='" . htmlspecialchars($row['id']) . "'>
                            <button type='submit' name='aprobar' class='btn btn-success btn-sm'>Aprobar</button>
                        </form>

                        <form action='validar.php' method='post' style='display:inline;'>
                            <input type='hidden' name='usuario_id' value='" . htmlspecialchars($row['id']) . "'>
                            <button type='submit' name='rechazar' class='btn btn-danger btn-sm'>Rechazar</button>
                        </form>
                    </td>
                </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<div class='alert alert-warning text-center mt-3'>No hay solicitudes de administrador pendientes.</div>";
        }

        // Cerrar el statement y conexión
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        ?>
        <div class="text-center mt-3">
            <a href="admin_menu.php" class="btn btn-primary">Volver al Menú del Administrador</a>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
