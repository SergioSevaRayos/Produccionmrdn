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

    // Consulta SQL para obtener los datos de producción del usuario
    $produccionSql = "SELECT fecha, metros_cubicos FROM produccion_diaria WHERE usuario_id = $usuario_id";
    $produccionResult = $conn->query($produccionSql);
}

if ($produccionResult->num_rows > 0) {
    $data = array();
    while ($row = $produccionResult->fetch_assoc()) {
        $data[] = $row;
    }
    $dataJson = json_encode($data);
    echo $dataJson;
} else {
    echo json_encode(array()); // Si no hay datos, devuelve un array JSON vacío
}

$conn->close();
?>
