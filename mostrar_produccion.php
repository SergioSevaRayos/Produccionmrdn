<?php
// Incluir el archivo de configuración de la base de datos
include 'db_config.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el email del usuario que inició sesión desde la consulta GET
$userEmail = $_GET['email'];

// Consulta SQL para obtener el usuario_id correspondiente al correo electrónico
$getUserIDSql = "SELECT id FROM usuarios WHERE email = '$userEmail'";
$userIDResult = $conn->query($getUserIDSql);

if ($userIDResult->num_rows > 0) {
    $row = $userIDResult->fetch_assoc();
    $usuario_id = $row['id'];

    // Consulta SQL para obtener la producción introducida por el usuario
    $produccionSql = "SELECT fecha, metros_cubicos FROM produccion_diaria WHERE usuario_id = $usuario_id";
    $produccionResult = $conn->query($produccionSql);

    $produccionData = array();

    if ($produccionResult->num_rows > 0) {
        while ($row = $produccionResult->fetch_assoc()) {
            $produccionData[] = $row;
        }
    }

    echo json_encode($produccionData); // Devolver los datos en formato JSON
} else {
    echo "No se encontró el usuario correspondiente al email.";
}

$conn->close();
?>




