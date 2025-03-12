<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
        .usuario-nuevo {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">Iniciar Sesión</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="login.php" method="post">
                    <div class="form-group">
                        <!-- Campo para ingresar el nombre de usuario -->
                        <label for="usuario">Usuario:</label>
                        <input type="text" id="usuario" name="usuario" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <!-- Campo para ingresar la contraseña -->
                        <label for="password">Contraseña:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group form-check">
                        <!-- Checkbox para recordar al usuario -->
                        <input type="checkbox" class="form-check-input" id="recordar" name="recordar">
                        <label class="form-check-label" for="recordar">Recordarme</label>
                    </div>
                    <!-- Botón para enviar el formulario -->
                    <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                </form>
            </div>
        </div>
        <!-- Frase de Usuario Nuevo y botón de registro -->
        <div class="usuario-nuevo">
            <p>¿Usuario nuevo?</p>
            <a href="register.php" class="btn btn-secondary">Registrarse</a>
        </div>
    </div>

    <?php
    // Iniciar la sesión
    session_start();

    // Verificar si el formulario ha sido enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Incluir el archivo de conexión a la base de datos
        include('db.php');

        // Obtener los valores del formulario
        $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
        $password = $_POST['password'];

        // Buscar al usuario en la base de datos
        $sql = "SELECT * FROM usuarios WHERE usuario='$usuario'";
        $result = mysqli_query($conn, $sql);

        // Verificar si se encontró el usuario
        if (mysqli_num_rows($result) > 0) {
            // Obtener los datos del usuario
            $row = mysqli_fetch_assoc($result);

            // Verificar si la contraseña es correcta
            if (password_verify($password, $row['password'])) {
                // Almacenar datos del usuario en la sesión
                $_SESSION['usuario'] = $row['usuario'];
                $_SESSION['rol'] = $row['rol'];

                // Verificar si se debe recordar al usuario
                if (isset($_POST['recordar'])) {
                    // Establecer cookies para recordar al usuario por 30 días
                    setcookie('usuario', $row['usuario'], time() + (86400 * 30), "/");
                    setcookie('rol', $row['rol'], time() + (86400 * 30), "/");
                }

                // Redirigir según el rol del usuario
                if ($row['rol'] == 'administrador') {
                    header("Location: admin_menu.php");
                } else {
                    header("Location: listado_productos.php");
                }
            } else {
                // Mostrar mensaje de error si la contraseña es incorrecta
                echo "<div class='alert alert-danger text-center mt-3'>Contraseña incorrecta.</div>";
            }
        } else {
            // Mostrar mensaje de error si no se encuentra al usuario
            echo "<div class='alert alert-danger text-center mt-3'>Usuario no encontrado.</div>";
        }

        // Cerrar la conexión con la base de datos
        mysqli_close($conn);
    }
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
