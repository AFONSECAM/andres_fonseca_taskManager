<?php

require_once '../config.php';
require_once '../app/models/User.php';
require_once '../app/helpers/Flash.php';

$userModel = new User($pdo);


if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])){
    $userName   = trim($_POST['username']);
    $email      = trim($_POST['email']);
    $password   = $_POST['password'];

    if($userModel->emailExists($email)){
        redirectWithFlashAlert('register.php', 'El email ya se encuentra registrado', 'error');        
    } elseif($userModel->userNameExists($userName)){
        redirectWithFlashAlert('register.php', 'El nombre de usuario ya se encuentra registrado', 'error');        
    }else{
        $registered = $userModel->register($userName, $email, $password);
        if($registered){
            $success = "Registro de usuario exitoso. Ya puede iniciar sesión.";
        } else{
            $error = "Error al registrar. Intente de nuevo.";
        }
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])){
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $user = $userModel->login($email, $password);

    if($user){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        redirectWithFlashAlert('../public/tasks.php', 'Inicio de sesión correcto', 'success');                
    }else{
        redirectWithFlashAlert('../public/tasks.php', 'Email o contraseña incorrectos', 'error');                
    }
}