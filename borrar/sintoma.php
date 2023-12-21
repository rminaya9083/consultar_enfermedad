<?php

include('../db.php');

if (isset($_GET["id"])){
    $id = $_GET["id"];

    $sql = "DELETE FROM sintoma WHERE id_sintoma = $id";
    $conn->query($sql);
}

header("location: /consultar_enfermedad/modelo/sintoma.php");
        exit;
?>