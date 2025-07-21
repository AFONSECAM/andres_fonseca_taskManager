<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

function setFlashAlert($message, $type = 'success'): void {
    $_SESSION['flash'] = [
        'message' => $message,
        'type' => $type
    ];
}

function getFlashAlert(){
    $flashAlertData = ['success' => null, 'error' => null];

    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        if ($flash['type'] === 'success') {
            $flashAlertData['success'] = $flash['message'];
        } else {
            $flashAlertData['error'] = $flash['message'];
        }
        unset($_SESSION['flash']);
    }

    return $flashAlertData;

}

function redirectWithFlashAlert($location, $message, $type = 'success'){
    setFlashAlert($message, $type);
    header("Location: $location");
    exit;
}

function flashBodyAttributes(){
    $flash = getFlashAlert();
    if ($flash['success']) {
        echo 'data-flash="' . htmlspecialchars($flash['success']) . '" data-flash-type="success"';
    } elseif ($flash['error']) {
        echo 'data-flash="' . htmlspecialchars($flash['error']) . '" data-flash-type="error"';
    }
}