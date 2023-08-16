<?php
session_start();

// Incluir el archivo de configuración de la base de datos
include 'db_config.php';

// Obtener el usuario_id del usuario conectado
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

    // Consulta SQL para obtener las incidencias del usuario conectado
    $getIncidenciasSql = "SELECT * FROM incidencias WHERE usuario_id = $usuario_id";
    $incidenciasResult = $conn->query($getIncidenciasSql);

    $incidencias = array();

    if ($incidenciasResult->num_rows > 0) {
        while ($row = $incidenciasResult->fetch_assoc()) {
            $incidencias[] = $row;
        }
        echo json_encode($incidencias);
    } else {
        echo json_encode(array()); // Devuelve un array vacío si no hay incidencias
    }
} else {
    echo "No se encontró el usuario correspondiente al email.";
}

$conn->close();
?>

