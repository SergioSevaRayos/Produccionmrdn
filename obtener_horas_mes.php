<?php
// Iniciar sesión para manejar variables de sesión
session_start();

// Incluir el archivo de configuración de la base de datos
include 'db_config.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el email del usuario que inició sesión desde la cookie
$userEmail = $_COOKIE['user_email'];

// Consulta SQL para obtener el usuario_id correspondiente al correo electrónico
$getUserIDSql = "SELECT id FROM usuarios WHERE email = '$userEmail'";
$userIDResult = $conn->query($getUserIDSql);

if ($userIDResult->num_rows > 0) {
    $row = $userIDResult->fetch_assoc();
    $usuario_id = $row['id'];

    // Consulta SQL para obtener los datos de horas de penosidad del usuario
    $horasPenosidadSql = "SELECT fecha, horas_penosidad FROM horas_penosidad WHERE usuario_id = $usuario_id";
    $horasPenosidadResult = $conn->query($horasPenosidadSql);
}

$data = array();

if ($horasPenosidadResult->num_rows > 0) {
    while ($row = $horasPenosidadResult->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);

$conn->close();
?>
