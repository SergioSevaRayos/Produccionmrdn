<?php
// Iniciar sesión para manejar variables de sesión
session_start();

// Incluir el archivo de configuración de la base de datos
include 'db_config.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener los datos de la solicitud POST
$fecha = $_POST['fecha'];
$metrosCubicos = $_POST['metros_cubicos'];

// Obtener el email del usuario que inició sesión desde la cookie
$userEmail = $_COOKIE['user_email'];

// Consulta SQL para obtener el usuario_id correspondiente al correo electrónico
$getUserIDSql = "SELECT id FROM usuarios WHERE email = '$userEmail'";
$userIDResult = $conn->query($getUserIDSql);

if ($userIDResult->num_rows > 0) {
    $row = $userIDResult->fetch_assoc();
    $usuario_id = $row['id'];

    // Consulta SQL para verificar si la producción ya existe en la base de datos para esa fecha y usuario
    $existingSql = "SELECT * FROM produccion_diariacong WHERE usuario_id = $usuario_id AND fecha = '$fecha'";
    $result = $conn->query($existingSql);

    if ($result->num_rows > 0) {
        // La producción ya existe para esa fecha y usuario, realizar una actualización
        $updateSql = "UPDATE produccion_diariacong SET metros_cubicos = $metrosCubicos WHERE usuario_id = $usuario_id AND fecha = '$fecha'";

        if ($conn->query($updateSql) === TRUE) {
            $_SESSION['produccion_actualizada'] = true; // Almacenar en sesión que la producción se ha actualizado
            header("Location: produccion_diaria_cong.html"); // Redirigir a produccion_diaria.html
            exit();
        } else {
            echo "Error al actualizar la producción: " . $conn->error;
        }
    } else {
        // La producción no existe para esa fecha y usuario, realizar una inserción
        $insertSql = "INSERT INTO produccion_diariacong (usuario_id, fecha, metros_cubicos) VALUES ($usuario_id, '$fecha', $metrosCubicos)";

        if ($conn->query($insertSql) === TRUE) {
            $_SESSION['produccion_guardada'] = true; // Almacenar en sesión que la producción se ha guardado
            header("Location: produccion_diaria_cong.html"); // Redirigir a produccion_diaria.html
            exit();
        } else {
            echo "Error al guardar la producción: " . $conn->error;
        }
    }
} else {
    echo "No se encontró el usuario correspondiente al email.";
}

$conn->close();
?>

