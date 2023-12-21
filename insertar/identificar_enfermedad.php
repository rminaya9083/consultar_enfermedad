<?php
include('../db.php');

$id_enfermedad = "";
$enfermedades_concatenadas = "";
$enfermedades_concatenadas_1 = "";
$enfermedades_resultado = "";
$enfermedades_resultado = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los síntomas, valores y tiempos desde el formulario
    $sintomas = isset($_POST['sintomas']) ? $_POST['sintomas'] : null;
    $valor = isset($_POST['valores']) ? $_POST['valores'] : null;
    $tiempo = isset($_POST['tiempos']) ? $_POST['tiempos'] : null;

    if ($sintomas !== null) {
        // Construir la cadena de síntomas para la consulta SQL
        $sintomas_busqueda = implode(',', array_map('intval', $sintomas));
        $valor_busqueda = implode(',', array_map('intval', $valor));
        $tiempo_busqueda = implode(',', array_map('intval', $tiempo));

        // Construir la cadena de condiciones para la consulta SQL
        $condiciones = [];
        for ($i = 0; $i < count($sintomas); $i++) {
            $condiciones[] = "id_sintoma = {$sintomas[$i]}";
        }

        // Construir la consulta SQL
        $sql = "
            SELECT ts.id_enfermedad, e.enfermedad, AVG(ts.orden) AS ordenes
            FROM enfermedad_sintoma ts
            JOIN enfermedad e ON e.id_enfermedad = ts.id_enfermedad
            WHERE FIND_IN_SET(ts.id_sintoma, '$sintomas_busqueda') > 0
            GROUP BY ts.id_enfermedad
            HAVING ordenes > 1 AND COUNT(DISTINCT ts.id_sintoma) > 1
            ORDER BY ordenes;
        ";

        $resultado = mysqli_query($conn, $sql);

        // Verificar si la consulta fue exitosa
        if ($resultado) {
            // Inicializar la variable para concatenar las enfermedades
            $enfermedades_concatenadas = "";

            // Iterar sobre los resultados de la primera consulta
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $enfermedades_concatenadas .= $fila['enfermedad'] . ", ";
            }

            // Liberar el resultado de la primera consulta
            mysqli_free_result($resultado);
        } else {
            // Mostrar mensaje de error de la primera consulta
            echo "Error en la primera consulta: " . mysqli_error($conn);
        }

        // Segunda consulta SQL
        $sql_1 = "
            SELECT e.enfermedad
            FROM detalle_sintomas ds
            JOIN enfermedad e ON e.id_enfermedad = ds.id_enfermedad
            WHERE FIND_IN_SET(ds.id_sintoma, '$sintomas_busqueda') > 0
              AND (
                CAST(SUBSTRING_INDEX(SUBSTRING_INDEX('$valor_busqueda', ', ', FIND_IN_SET(ds.id_sintoma, '$sintomas_busqueda')), ', ', -1) AS SIGNED) BETWEEN ds.valor_min AND ds.valor_max
              )
              AND (
                CAST(SUBSTRING_INDEX(SUBSTRING_INDEX('$tiempo_busqueda', ', ', FIND_IN_SET(ds.id_sintoma, '$sintomas_busqueda')), ', ', -1) AS SIGNED) BETWEEN ds.tiempo_min AND ds.tiempo_max
              )
            ORDER BY e.enfermedad;
        ";
        $resultado_1 = mysqli_query($conn, $sql_1);

        // Verificar si la consulta fue exitosa
        if ($resultado_1) {
            // Iterar sobre los resultados de la segunda consulta
            while ($fila = mysqli_fetch_assoc($resultado_1)) {
                $enfermedades_concatenadas_1 .= $fila['enfermedad'] . ", ";
            }

            // Liberar el resultado de la segunda consulta
            mysqli_free_result($resultado_1);
        } else {
            // Mostrar mensaje de error de la segunda consulta
            echo "Error en la segunda consulta: " . mysqli_error($conn);
        }

        // Eliminar la coma y el espacio extra al final
        $enfermedades_resultado = rtrim($enfermedades_concatenadas_1, ', ');

        // Concatenar los resultados de ambas consultas
        $enfermedades_resultado .= ', ' . rtrim($enfermedades_concatenadas, ', ');

        // Imprimir las enfermedades encontradas
       // echo "Enfermedades encontradas: $enfermedades_resultado";

    } else {
       // echo "Seleccione al menos un síntoma desde el formulario.";
    }
}

// Consulta SQL para obtener los síntomas
$sql_sintomas = "SELECT id_sintoma, sintoma FROM sintoma";
$resultado_sintomas = mysqli_query($conn, $sql_sintomas);

// Cerrar la conexión
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Síntomas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<?php include('../index.html');?>
    <div class="container mt-5">
        <form method="post" action="">
            <<div class="row mb-2 mx-auto">
                <label for="enfermedad" class="form-label mt-6 text-center mx-auto">Enfermedad Resultante:</label>
                <div class="col-sm-6 mx-auto">
                <input type="text" id="enfermedad" name="enfermedad" class="form-control text-center" value="<?= isset($enfermedades_resultado) ? htmlspecialchars($enfermedades_resultado) : '' ?>" readonly>
                </div>
            </div>
            <div class="rounded-3 p-1 border mb-3 row mb-3 justify-content-center">
                <div class="col-sm-4">
                    <?php
                    // Generar 5 listas desplegables de síntomas en la primera columna
                    for ($i = 1; $i <= 3; $i++) {
                        echo "<label for=\"sintomas$i\" class=\"form-label\"><b>Selecciona síntoma $i:</b></label>";
                        echo "<select name=\"sintomas[]\" id=\"sintomas$i\" class=\"form-select\">";
                        echo "<option value=\"\" disabled selected>Selecciona una opción</option>"; // Máscara por defecto
                        mysqli_data_seek($resultado_sintomas, 0);
                        while ($fila_sintoma = mysqli_fetch_assoc($resultado_sintomas)) {
                            $id_sintoma = $fila_sintoma['id_sintoma'];
                            $nombre_sintoma = $fila_sintoma['sintoma'];
                            echo "<option value=\"$id_sintoma\">$nombre_sintoma</option>";
                        }                        
                        
                        echo "</select>";
                        echo "<label for=\"valor$i\" class=\"form-label\">Valor:</label>";
                        echo "<input type=\"number\" name=\"valores[]\" id=\"valor$i\" class=\"form-control mb-2\" placeholder=\"Ingresa el valor\">";
                        
                        echo "<label for=\"tiempo$i\" class=\"form-label\">Tiempo(Hrs):</label>";
                        echo "<input type=\"number\" name=\"tiempos[]\" id=\"tiempo$i\" class=\"form-control mb-3\" placeholder=\"Ingresa el tiempo\">";
                        echo "<hr>";                        
                        echo "<br>";                        
                        
                    }
                    ?>
                </div>
                <div class="col-sm-4">
                    <?php
                    // Generar otras 5 listas desplegables de síntomas en la segunda columna
                    for ($i = 4; $i <= 6; $i++) {
                        echo "<label for=\"sintomas$i\" class=\"form-label\"><b>Selecciona síntoma $i:</b></label>";
                        echo "<select name=\"sintomas[]\" id=\"sintomas$i\" class=\"form-select\">";
                        echo "<option value=\"\" disabled selected>Selecciona una opción</option>"; // Máscara por defecto
                        mysqli_data_seek($resultado_sintomas, 0);
                        while ($fila_sintoma = mysqli_fetch_assoc($resultado_sintomas)) {
                            $id_sintoma = $fila_sintoma['id_sintoma'];
                            $nombre_sintoma = $fila_sintoma['sintoma'];
                            echo "<option value=\"$id_sintoma\">$nombre_sintoma</option>";
                        }
                        echo "</select>";
                        echo "<label for=\"valor$i\" class=\"form-label\">Valor:</label>";
                        echo "<input type=\"number\" name=\"valores[]\" id=\"valor$i\" class=\"form-control mb-2\" placeholder=\"Ingresa el valor\">";
                        
                        echo "<label for=\"tiempo$i\" class=\"form-label\">Tiempo(Hrs):</label>";
                        echo "<input type=\"number\" name=\"tiempos[]\" id=\"tiempo$i\" class=\"form-control mb-3\" placeholder=\"Ingresa el tiempo\">";
                        echo "<hr>";                        
                        echo "<br>";        
                    }
                    ?>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="offset-sm-1 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-success mt-3">Consultar Enfermedad</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-danger mt-3" href="/consultar_enfermedad/insertar/consulta.php" role="button">Cancelar</a>
                </div>
            </div>               
        </form>    
    </div>
</body>
</html>
