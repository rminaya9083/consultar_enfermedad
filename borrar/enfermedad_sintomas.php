<?php

include('../db.php');

if (isset($_GET["id"])){
    $id = $_GET["id"];

    $sql = "DELETE FROM enfermedad_sintoma WHERE id_enfermedad = $id";
    $conn->query($sql);
}

header("location: /consultar_enfermedad/modelo/enfermedad_sintomas.php");
        exit;
?>