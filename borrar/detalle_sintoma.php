<?php

include('../db.php');

if (isset($_GET["id"])){
    $id = $_GET["id"];

    $sql = "DELETE FROM detalle_sintomas WHERE id_detalle_sintoma = $id";
    $conn->query($sql);
}

header("location: /consultar_enfermedad/modelo/detalle_sintomas.php");
        exit;
?>