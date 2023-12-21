<?php

include('../db.php');

if (isset($_GET["id"])){
    $id = $_GET["id"];

    $sql = "DELETE FROM rol WHERE id_rol = $id";
    $conn->query($sql);
}

header("location: /consultar_enfermedad/modelo/rol.php");
        exit;
?>