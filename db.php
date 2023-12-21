<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "sintomas_enfermedad";

// Crear la conexión
$conn = mysqli_connect($servername, $username, $password, $database);

// Verificar la conexión
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
} 
?>
