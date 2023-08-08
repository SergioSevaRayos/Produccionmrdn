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
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$email = $_POST['email'];
$contrasena = $_POST['contrasena'];

// Verificar si el usuario ya está registrado
$verificarUsuario = "SELECT id FROM usuarios WHERE email = '$email'";
$resultado = $conn->query($verificarUsuario);

if ($resultado->num_rows > 0) {
    $_SESSION['usuario_existente'] = true; // Almacenar en sesión que el usuario ya existe
    
    // Mostrar mensaje de alerta y redirigir después
    echo '<script type="text/javascript">
            alert("El usuario ya está registrado.");
            window.location.href = "index.html";
        </script>';
    exit();
}

// Hash de la contraseña (se recomienda usar funciones de hash seguras en producción)
$hashedContrasena = password_hash($contrasena, PASSWORD_DEFAULT);

// Consulta SQL para insertar los datos
$sql = "INSERT INTO usuarios (nombre, apellidos, email, contrasena) VALUES ('$nombre', '$apellidos', '$email', '$hashedContrasena')";

if ($conn->query($sql) === TRUE) {
    // echo "Usuario registrado exitosamente";
    $_SESSION['registro_exitoso'] = true; // Almacenar en sesión que el registro se ha completado
    header("Location: index.html"); // Redirigir a index.html
    exit();
} else {
    echo "Error al registrar el usuario: " . $conn->error;
}

$conn->close();
?>
