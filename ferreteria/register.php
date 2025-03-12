<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <!-- Enlace a Bootstrap CSS -->
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
        <h1 class="text-center mt-5">Registro de Usuario</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="register.php" method="post">
                    <div class="form-group">
                        <!-- Campo para ingresar el nombre de usuario -->
                        <label for="usuario">Usuario:</label>
                        <input type="text" id="usuario" name="usuario" class="form-control" required>
                        <label for="apellido1">Apellido1:</label>
                        <input type="text" id="apellido1" name="apellido1" class="form-control" required>
                        <label for="apellido2">Apellido2:</label>
                        <input type="text" id="apellido2" name="apellido2" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <!-- Campo para ingresar el email -->
                        <label for="email">Correo Electrónico:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <!-- Campo para ingresar la contraseña -->
                        <label for="password">Contraseña:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <!-- Selección del rol del usuario -->
                        <label for="rol">Rol:</label>
                        <select id="rol" name="rol" class="form-control">
                            <option value="cliente">Cliente</option>
                            <option value="administrador">Administrador</option>
                        </select>
                    </div>
                    <!-- Botón para enviar el formulario -->
                    <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                    <a href="login.php" class="btn btn-primary btn-block">Iniciar Sesión</a>
                </form>
            </div>
        </div>
    </div>

    <?php
    // Verificar si el formulario ha sido enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Incluir el archivo de conexión a la base de datos
        include('db.php');
        
        // Obtener los valores del formulario y sanitizarlos
        $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
        $apellido1 = mysqli_real_escape_string($conn, $_POST['apellido1']);
        $apellido2 = mysqli_real_escape_string($conn, $_POST['apellido2']);
        $email = mysqli_real_escape_string($conn, $_POST['email']); // Procesar el campo email
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar la contraseña
        $rol = mysqli_real_escape_string($conn, $_POST['rol']);

        // Validar que el email tenga un formato válido
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<div class='alert alert-danger text-center mt-3'>El formato del correo electrónico no es válido.</div>";
        } else {
            // Si el rol es administrador, el campo 'validado' será 0 por defecto
            $validado = ($rol == 'administrador') ? 0 : 1;

            // Insertar los valores en la tabla de usuarios
            $sql = "INSERT INTO usuarios (usuario, apellido1, apellido2, email, password, rol, validado) 
                    VALUES ('$usuario', '$apellido1', '$apellido2', '$email', '$password', '$rol', $validado)";
            
            // Verificar si la inserción ha sido exitosa
            if (mysqli_query($conn, $sql)) {
                if ($rol == 'administrador') {
                    echo "<div class='alert alert-warning text-center mt-3'>Registro exitoso. Espera validación de un administrador.</div>";
                } else {
                    echo "<div class='alert alert-success text-center mt-3'>Registro exitoso.</div>";
                }
            } else {
                echo "<div class='alert alert-danger text-center mt-3'>Error: " . mysqli_error($conn) . "</div>";
            }
        }

        // Cerrar la conexión con la base de datos
        mysqli_close($conn);
    }
    ?>
    <!-- Enlace a Bootstrap JS y dependencias -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
