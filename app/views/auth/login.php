<?php require_once '../app/helpers/Flash.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>TaskManager App</title>
</head>

<body <?php flashBodyAttributes(); ?>>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <h2 class="text-center">Inicio de sesión</h2>
                <form id="loginForm" method="POST">
                    <div class="form-group">
                        <label for="username">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese correo" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese contraseña"
                            required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4" name="login">Ingresar</button>
                </form>
                <p>¿No tienes una cuenta? <a href="../public/register.php"> Crear una aqui</a></p>
            </div>
        </div>
    </div>    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../public/js/myscript.js"></script>
</body>

</html>