<?php
include('../db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $idPaciente = $_POST['id'];

    $sqlNombrePaciente = "SELECT CONCAT(nombre, ' ', apellido) AS nombre_completo FROM paciente WHERE id_paciente = $idPaciente";
    $resultNombrePaciente = $conn->query($sqlNombrePaciente);

    if ($resultNombrePaciente) {
        $rowNombrePaciente = $resultNombrePaciente->fetch_assoc();
        echo $rowNombrePaciente['nombre_completo'];
    } else {
        echo "Error al obtener el nombre del paciente: " . $conn->error;
    }
} else {
    echo "Parámetros incorrectos.";
}
?>