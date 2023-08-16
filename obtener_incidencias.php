<?php
session_start();

// Incluir el archivo de configuración de la base de datos
include 'db_config.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener las incidencias desde la base de datos
$obtenerIncidenciasSql = "SELECT id, descripcion, fecha FROM incidencias";
$result = $conn->query($obtenerIncidenciasSql);

$incidencias = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $incidencias[] = $row;
    }
}

echo json_encode($incidencias);

$conn->close();
?>
