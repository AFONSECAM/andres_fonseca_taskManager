<?php
require_once '../config.php';
require_once '../app/models/Task.php';
require_once '../app/helpers/Flash.php';


if(!isset($_SESSION['user_id'])){
    header("Location: ../public/login.php");
    exit;
}

$taskModel = new Task($pdo);
$userId = $_SESSION['user_id'];


$uploadDir = '../public/uploads/';


if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action']  == 'create'){
    $attachment = null;
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        $fileTmp = $_FILES['attachment']['tmp_name'];
        $fileName = time() . '_' . basename($_FILES['attachment']['name']);        
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmp, $filePath)) {
            $attachment = $fileName;
        }
    }

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];
    if($taskModel->create($userId, $title, $description, $due_date, $priority, $attachment)){
        redirectWithFlashAlert('../public/tasks.php', '¡Tarea creada correctamente!', 'success');      
    } else{
        redirectWithFlashAlert('../public/tasks.php', '¡No fue posible crear la tarea! Intente de nuevo.', 'error');      
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'edit'){
    $attachment = null;
    if (isset($_FILES['editAttachment']) && $_FILES['editAttachment']['error'] === UPLOAD_ERR_OK) {
        $fileTmp = $_FILES['editAttachment']['tmp_name'];
        $fileName = time() . '_' . basename($_FILES['editAttachment']['name']);        
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmp, $filePath)) {
            $attachment = $fileName;
        }
    }

    $id = $_POST['task_id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];
    $completed = isset($_POST['completed']) ? 1 : 0;

    if($taskModel->update($id, $title, $description, $due_date, $priority, $completed, $userId, $attachment)){
        redirectWithFlashAlert('../public/tasks.php','¡Tarea actualizada correctamente!','success');
    } else{
        redirectWithFlashAlert('../public/tasks.php','¡No fue posible actualizar la tarea! Intente de nuevo.','error');
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'delete'){
    $id = $_POST['task_id'];
    if($taskModel->delete($id, $userId)){
        redirectWithFlashAlert('../public/tasks.php','¡Tarea eliminada correctamente!','success');      
    } else{
        redirectWithFlashAlert('../public/tasks.php','¡No fue posible eliminar la tarea! Intente de nuevo','success');      
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'changeStatus'){
    $id = $_POST['task_id'];
    $newStatus = $_POST['completed'] ? 0 : 1;
    if($taskModel->changeStatus($id, $newStatus)){
        $newStatus ? redirectWithFlashAlert('../public/tasks.php','¡Tarea marcada cómo ✔ completa correctamente!','success')
        : redirectWithFlashAlert('../public/tasks.php','¡Tarea marcada cómo ❌ incompleta correctamente!','error');       
    } else{
        redirectWithFlashAlert('../public/tasks.php','¡No fue posible cambiar el estado! Intente de nuevo','error');
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'filterTasks'){
    $priority = $_POST['priority_filter'] ?? null;
    $status = $_POST['status_filter'] ?? null;
    $dueOrder = $_POST['due_filter'] ?? null;

    $tasks = $taskModel->filterTasks($userId, $priority, $status, $dueOrder);
}else{
    $tasks = $taskModel->getAll($userId);    
}
