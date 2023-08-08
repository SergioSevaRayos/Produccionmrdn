<?php
// Datos de conexión a la base de datos
$servername = "localhost:3307";
$username = "root";
$password = "9400Jet_";
$dbname = "produccion_db";

// Crear conexión
$mysqli = new mysqli($servername, $username, $password, $dbname);
$mysqli->set_charset('utf8');
?>