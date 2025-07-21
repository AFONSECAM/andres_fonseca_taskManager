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
        <div class="d-flex justify-content-center align-items-center mb-4">
            <h3>Registro de usuario</h3>            
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4">                
                <form method="POST">
                    <div class="form-group">
                        <label for="username">Nombre usuario</label>
                        <input type="username" class="form-control" id="username" name="username" placeholder="Nombre de usuario" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Crear contraseña"
                            required>
                    </div>
                    <button type="submit" name="register" class="btn btn-primary mt-4" name="login">Registro</button>
                </form>
                <p>¿Ya tienes una cuenta? <a href="../public/login.php"> Inicia sesión aquí</a></p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../public/js/myscript.js"></script>
</body>

</html>