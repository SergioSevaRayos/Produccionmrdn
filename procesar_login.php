<?php
if (!empty($_POST['email']) && !empty($_POST['contrasena'])) {
    // Obtener los datos del formulario mediante el método POST
    $mEmail = $_POST['email'];
    $mContrasena = $_POST['contrasena'];

    require 'db_config.php';
    // Incluir el archivo de conexión a la base de datos

    if ($mysqli) {
        // Verificar si la conexión a la base de datos se ha establecido correctamente

        $sql = "SELECT * FROM `usuarios` WHERE `email` = ?";
        // Consulta SQL para verificar si el email coincide en la base de datos

        if ($nueva_consulta = $mysqli->prepare($sql)) {
            // Preparar la consulta SQL con los marcadores de posición para evitar inyecciones SQL

            $nueva_consulta->bind_param('s', $mEmail);
            // Asociar el valor del email al marcador de posición de la consulta

            $nueva_consulta->execute();
            // Ejecutar la consulta preparada

            $resultado = $nueva_consulta->get_result();
            // Obtiene el resultado de la consulta

            if ($resultado->num_rows == 1) {
                // Comprueba si se encontró exactamente un resultado

                $row = $resultado->fetch_assoc();
                $hashedPasswordDB = $row['contrasena'];
                
                if (password_verify($mContrasena, $hashedPasswordDB)) {
                    // ¡Inicio de sesión exitoso! Almacena el email en una cookie
                    setcookie("user_email", $mEmail, time() + (86400 * 30), "/"); // Cookie válida por 30 días

                    // Redirecciona a "index.html"
                    header("Location: inicio.html");
                } else {
                    // Credenciales incorrectas
                    echo "Credenciales incorrectas. Inténtalo nuevamente.";
                }
            } else {
                // Usuario no encontrado
                echo "Usuario no encontrado.";
            }

            $nueva_consulta->close();
            // Cierra la consulta preparada
        } else {
            // Error al preparar la consulta
            echo "Error al preparar la consulta.";
        }

        $mysqli->close();
        // Cierra la conexión a la base de datos
    } else {
        echo "No hay conexión";
        // Establece un mensaje de error si no se pudo conectar a la base de datos
    }
} else {
    echo "Por favor, completa todos los campos del formulario.";
    // Establece un mensaje de error si algunos campos están vacíos en el formulario
}
?>