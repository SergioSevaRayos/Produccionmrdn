<?php
session_start();
if (!isset($_SESSION['email'])) {
    // Si el usuario no tiene una sesión iniciada, devuelve un código de estado HTTP 401 (Unauthorized)
    http_response_code(401);
    exit;
}
?>
