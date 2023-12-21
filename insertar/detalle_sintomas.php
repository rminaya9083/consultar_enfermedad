<?php include('../db.php'); ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultorio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <?php include('../index.html'); ?>

    <div class="container mt-5">
        <h2>Síntomas por categoría</h2>
        <form method="post" action="../proceso/detalle_sintomas.php">
            <!-- Campos del formulario -->

            <div class="col-sm-4">
                <label for="sintomas" class="form-label">Síntoma:</label>
                <select class="form-select" id="sintomas" name="sintomas">
                    <option value="" disabled selected>Seleccione un síntoma</option>
                    <?php
                    // Consulta para obtener los nombres de los síntomas
                    $query = "SELECT id_sintoma, sintoma FROM sintoma";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id_sintoma'] . "'>" . $row['sintoma'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay síntomas disponibles</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="col-sm-4">
                <label for="enfermedad" class="form-label">Enfermedad:</label>
                <select class="form-select" id="enfermedad" name="enfermedad">
                    <option value="" disabled selected>Seleccione una enfermedad</option>
                    <?php
                    // Consulta para obtener los nombres de los síntomas
                    $query = "SELECT id_enfermedad, enfermedad FROM enfermedad";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id_enfermedad'] . "'>" . $row['enfermedad'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay enfermedad disponible</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="col-sm-2">
                <label for="valor_min" class="form-label">Valor Mínimo:</label>
                <input type="text" class="form-control" id="valor_min" name="valor_min">
            </div>

            <div class="col-sm-2">
                <label for="valor_max" class="form-label">Valor Máximo:</label>
                <input type="text" class="form-control" id="valor_max" name="valor_max">
            </div>

            <div class="col-sm-2">
                <label for="tiempo_min" class="form-label">Tiempo Mínimo:</label>
                <input type="text" class="form-control" id="tiempo_min" name="tiempo_min">
            </div>

            <div class="col-sm-2">
                <label for="tiempo_max" class="form-label">Tiempo Máximo:</label>
                <input type="text" class="form-control" id="tiempo_max" name="tiempo_max">
            </div>
            <br>
            <div class="row mb-2">
                <div class="offset-sm-1 col-sm-2 d-grid">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                <div class="col-sm-2 d-grid">
                    <a class="btn btn-outline-danger" href="/consultar_enfermedad/modelo/detalle_sintomas.php" role="button">Cancelar</a>
                </div>
            </div>
        </form>
    </div>

</body>

</html>
