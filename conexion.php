<?php
define('BASE_URL', 'http://localhost/deportenis');
// Configuración de la base de datos
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'deportenis';

// Crear conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
