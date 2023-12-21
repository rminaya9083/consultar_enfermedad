<?php

include('../db.php');

if (isset($_GET["id"])){
    $id = $_GET["id"];

    $sql = "DELETE FROM paciente WHERE id_paciente = $id";
    $conn->query($sql);
}

header("location: /consultar_enfermedad/modelo/paciente.php");
        exit;
?>