<?php
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: /view/auth/login.php");
    exit();
}

// Verificar si la sesión ha caducado
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 120)) {
    // La sesión ha caducado
    session_unset();
    session_destroy();
    header("Location: /ruta/a/login.php");
    exit();
}

// Actualizar el tiempo de la última actividad
$_SESSION['last_activity'] = time();
?>