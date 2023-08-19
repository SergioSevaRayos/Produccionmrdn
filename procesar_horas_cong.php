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
$horasPenosidad = $_POST['horas_penosidad'];

// Obtener el email del usuario que inició sesión desde la cookie
$userEmail = $_COOKIE['user_email'];

// Consulta SQL para obtener el usuario_id correspondiente al correo electrónico
$getUserIDSql = "SELECT id FROM usuarios WHERE email = '$userEmail'";
$userIDResult = $conn->query($getUserIDSql);

if ($userIDResult->num_rows > 0) {
    $row = $userIDResult->fetch_assoc();
    $usuario_id = $row['id'];

    // Consulta SQL para verificar si las horas de penosidad ya existen en la base de datos para esa fecha y usuario
    $existingSql = "SELECT * FROM horas_penosidad WHERE usuario_id = $usuario_id AND fecha = '$fecha'";
    $result = $conn->query($existingSql);

    if ($result->num_rows > 0) {
        // Las horas de penosidad ya existen para esa fecha y usuario, realizar una actualización
        $updateSql = "UPDATE horas_penosidad SET horas_penosidad = $horasPenosidad WHERE usuario_id = $usuario_id AND fecha = '$fecha'";

        if ($conn->query($updateSql) === TRUE) {
            $_SESSION['horas_penosidad_actualizadas'] = true; // Almacenar en sesión que las horas de penosidad se han actualizado
            header("Location: produccion_diaria_cong.html"); // Redirigir a produccion_diaria_cong.html
            exit();
        } else {
            echo "Error al actualizar las horas de penosidad: " . $conn->error;
        }
    } else {
        // Las horas de penosidad no existen para esa fecha y usuario, realizar una inserción
        $insertSql = "INSERT INTO horas_penosidad (usuario_id, fecha, horas_penosidad) VALUES ($usuario_id, '$fecha', $horasPenosidad)";

        if ($conn->query($insertSql) === TRUE) {
            $_SESSION['horas_penosidad_guardadas'] = true; // Almacenar en sesión que las horas de penosidad se han guardado
            header("Location: produccion_diaria_cong.html"); // Redirigir a produccion_diaria_cong.html
            exit();
        } else {
            echo "Error al guardar las horas de penosidad: " . $conn->error;
        }
    }
} else {
    echo "No se encontró el usuario correspondiente al email.";
}

$conn->close();
?>
