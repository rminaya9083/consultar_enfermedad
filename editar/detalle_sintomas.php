<?php
include('../db.php');

$id_detalle_sintoma = "";
$sintoma = "";
$enfermedad = "";
$valor_minimo = "";
$valor_maximo = "";
$tiempo_minimo = "";
$tiempo_maximo = "";

$mensaje_error = "";
$mensaje_exitoso = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id_detalle_sintoma = $_GET["id"];

    $sql = "SELECT ds.id_detalle_sintoma, s.sintoma, e.enfermedad, ds.valor_min, ds.valor_max, ds.tiempo_min, ds.tiempo_max
    FROM detalle_sintomas ds
    INNER JOIN sintoma s ON ds.id_sintoma = s.id_sintoma
    INNER JOIN enfermedad e ON ds.id_enfermedad = e.id_enfermedad
    where id_detalle_sintoma = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_detalle_sintoma);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result || $result->num_rows == 0) {
        header("location: /consultar_enfermedad/modelo/detalle_sintomas.php");
        exit;
    }

    $row = $result->fetch_assoc();
    $id_detalle_sintoma = $row["id_detalle_sintoma"];
    $sintoma = $row["sintoma"];
    $enfermedad = $row["enfermedad"];
    $valor_minimo = $row["valor_min"];
    $valor_maximo = $row["valor_max"];
    $tiempo_minimo = $row["tiempo_min"];
    $tiempo_maximo = $row["tiempo_max"];
    $nivel = $row["nivel_alerta"];

    $stmt->close();
} else {
    $id_detalle_sintoma = $_POST["id"];
    $sintoma = $_POST["sintoma"];
    $enfermedad = $_POST["enfermedad"];
    $valor_minimo = $_POST["valor_min"];
    $valor_maximo = $_POST["valor_max"];    
    $tiempo_minimo = $_POST["tiempo_min"];
    $tiempo_maximo = $_POST["tiempo_max"];
    $nivel = $_POST["nivel_alerta"];

    do {
        if (empty($id_detalle_sintoma) || empty($sintoma) || empty($enfermedad) || empty($valor_minimo) || empty($tiempo_minimo)) {
            $mensaje_error = "Todos los campos son requeridos";
            break;
        }

        $sql = "UPDATE detalle_sintomas SET sintoma = ?, enfermedad = ?, valor_min = ?, valor_max = ?, tiempo_min = ?, tiempo_max = ?WHERE id_detalle_sintoma = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $sintoma, $enfermedad, $valor_minimo, $valor_maximo, $tiempo_minimo, $tiempo_maximo, $id_detalle_sintoma);
        $result = $stmt->execute();

        if (!$result) {
            $mensaje_error = "Query inválido: " . $conn->error;
            break;
        }

        $mensaje_exitoso = "detalle_sintomas actualizado correctamente";

        header("location: /consultar_enfermedad/modelo/detalle_sintomas.php");
        exit;

    } while (true);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="wid_enfermedadth=device-wid_enfermedadth, initial-scale=1.0">
    <title>Consultorio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
</head>

<body>
    <div class="container my-5">
        <h2>Editar detalle_sintomas</h2>

        <?php
        if (!empty($mensaje_error)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$mensaje_error</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' arial-label='Close'></button>
            </div>
            ";
        }
        ?>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id_detalle_sintoma; ?>">
            <div class="row mb-3">
                <label class="col-sm-1 col-form-label">ID</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="id" value="<?php echo $id_detalle_sintoma; ?>" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-1 col-form-label">sintoma</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="sintoma" value="<?php echo $sintoma; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-1 col-form-label">enfermedad</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="enfermedad" value="<?php echo $enfermedad; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-1 col-form-label">Valor Minimo</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="valor_min" value="<?php echo $valor_minimo; ?>">
                </div>
            </div>          
            <div class="row mb-3">
                <label class="col-sm-1 col-form-label">valor Maximo</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="tiempo_min" value="<?php echo $valor_maximo; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-1 col-form-label">Tiempo Minimo</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="tiempo_max" value="<?php echo $tiempo_minimo; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-1 col-form-label">Tiempo Maximo</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="tiempo_max" value="<?php echo $tiempo_maximo; ?>">
                </div>
            </div>

            <?php
            if (!empty($mensaje_exitoso)) {
                echo "
                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>$mensaje_exitoso</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' arial-label='Close'></button>
                </div>
                ";
            }
            ?>

            <div class="row mb-1">
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
