<?php
session_start();

// Incluir el archivo de configuración de la base de datos
include 'db_config.php';

// Obtener los datos de la solicitud POST
$descripcion = $_POST['descripcion'];

// Obtener el email del usuario que inició sesión desde la cookie
$userEmail = $_COOKIE['user_email'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener el usuario_id correspondiente al correo electrónico
$getUserIDSql = "SELECT id FROM usuarios WHERE email = '$userEmail'";
$userIDResult = $conn->query($getUserIDSql);

if ($userIDResult->num_rows > 0) {
    $row = $userIDResult->fetch_assoc();
    $usuario_id = $row['id'];

    // Consulta SQL para insertar la incidencia en la base de datos
    $insertSql = "INSERT INTO incidencias (usuario_id, descripcion) VALUES ($usuario_id, '$descripcion')";

    if ($conn->query($insertSql) === TRUE) {
        echo "Incidencia introducida correctamente.";
    } else {
        echo "Error al introducir la incidencia: " . $conn->error;
    }
} else {
    echo "No se encontró el usuario correspondiente al email.";
}

$conn->close();
?>
