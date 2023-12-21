<?php
include('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $id_sintoma = $_POST["sintomas"];
    $id_enfermedad = $_POST["enfermedad"];
    $valor_min = $_POST["valor_min"];
    $valor_max = $_POST["valor_max"];
    $tiempo_min = $_POST["tiempo_min"];
    $tiempo_max = $_POST["tiempo_max"];

    // Validar y procesar los datos según tus necesidades

    // Insertar datos en la tabla detalle_sintomas
    $query_insert = "INSERT INTO detalle_sintomas (id_sintoma, id_enfermedad, valor_min, valor_max, tiempo_min, tiempo_max) VALUES ('$id_sintoma', '$id_enfermedad', '$valor_min', '$valor_max', '$tiempo_min', '$tiempo_max')";

    if ($conn->query($query_insert) === TRUE) {
        echo "Los datos se guardaron correctamente.";
        header("location: /consultar_enfermedad/modelo/detalle_sintomas.php");
        exit;
    } else {
        echo "Error al guardar los datos: " . $conn->error;
    }
}
?>