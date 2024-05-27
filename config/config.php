<?php

session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'Administrador';
}

function restrictAccess($role = null) {
    if (!isLoggedIn()) {
        header('Location: /login.php');
        exit();
    }
    if ($role && !in_array($_SESSION['role'], (array) $role)) {
        header('Location: /unauthorized.php');
        exit();
    }
}
// URL base para archivos
define('BASE_URL', 'http://localhost:88/actas/uploads/');
?>
