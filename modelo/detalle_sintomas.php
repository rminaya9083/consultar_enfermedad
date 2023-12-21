<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultorio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</head>

<body>
    <?php include('../index.html');?>

    <div>
        <h2>Lista de Categoria - Sintomas / Enfermedad</h2>
        <a class="btn btn-success" href="/consultar_enfermedad/insertar/detalle_sintomas.php">Agregar Categoria</a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>Síntoma</th>
                    <th>Enfermedad</th>
                    <th>V_Minimo</th>
                    <th>V_Maximo</th>
                    <th>T_Minimo</th>
                    <th>T_Maximo</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include("../db.php");
                // Realiza una consulta para obtener los datos necesarios desde detalle_sintomas, sintoma y enfermedad
                $query = "SELECT ds.id_detalle_sintoma, s.sintoma, e.enfermedad, ds.valor_min, ds.valor_max, ds.tiempo_min, ds.tiempo_max
                          FROM detalle_sintomas ds
                          INNER JOIN sintoma s ON ds.id_sintoma = s.id_sintoma
                          INNER JOIN enfermedad e ON ds.id_enfermedad = e.id_enfermedad";
                $result = $conn->query($query);
                if (!$result) {
                    die("Query inválido: " . $conn->error);
                }


                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                        <td> $row[sintoma]</td>
                        <td>$row[enfermedad]</td>
                        <td>$row[valor_min]</td>
                        <td>$row[valor_max]</td>
                        <td>$row[tiempo_min]</td>
                        <td>$row[tiempo_max]</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='/consultar_enfermedad/editar/detalle_sintomas.php?id=$row[id_detalle_sintoma]'>Editar</a>
                            <a class='btn btn-danger btn-sm' href='/consultar_enfermedad/borrar/detalle_sintomas.php?id=$row[id_detalle_sintoma]'>Eliminar</a>
                        </td>
                        </tr>
                        ";
                        
                        
                    }
                } else {
                    echo "<tr><td colspan='7'>No hay datos disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>

