<?php
// Iniciar o reanudar la sesión
session_start();

// Destruir todas las variables de sesión
session_destroy();

// Redireccionar a la página de inicio (index.html) después de cerrar la sesión
header("Location: index.html");
exit;
?>

