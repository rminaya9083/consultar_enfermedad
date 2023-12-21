<?php
include('../db.php');

// Inicializar las variables
$id_ocurrencia = "";
$nivel = "";
$mayor_que = "";
$fecha_inicial = "";
$fecha_final = "";
$mensaje_error = "";
$mensaje_exitoso = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_ocurrencia = $_POST["id_ocurrencia"];
    $nivel = $_POST["nivel"];
    $mayor_que = $_POST["mayor_que"];
    $fecha_inicial = $_POST["fecha_inicial"];
    $fecha_final = $_POST["fecha_final"];

    do {
        if (empty($id_ocurrencia) || empty($nivel) || empty($fecha_inicial) || empty($fecha_final)) {
            $mensaje_error = "Todos los campos son requeridos";
            break;
        }

        // Validar si se ingresaron datos en el campo de mayor_que antes de guardar
        $mayor_que = !empty($mayor_que) ? $mayor_que : null;

        // Formatear las fechas antes de insertarlas en la base de datos
        $fecha_inicial = date("Y-m-d", strtotime($fecha_inicial));
        $fecha_final = date("Y-m-d", strtotime($fecha_final));

        $sql = "INSERT INTO categoria_ocurrencia (id_ocurrencia, nivel, mayor_que, fecha_inicial, fecha_final) VALUES ('$id_ocurrencia', '$nivel', '$mayor_que', '$fecha_inicial', '$fecha_final')";
        $result = $conn->query($sql);

        if (!$result) {
            $mensaje_error = "Query inválido: " . $conn->error;
            break;
        }

        // Limpiar las variables después de la inserción exitosa
        $id_ocurrencia = "";
        $nivel = "";
        $mayor_que = "";
        $fecha_inicial = "";
        $fecha_final = "";

        $mensaje_exitoso = "Categoría de ocurrencia agregada correctamente";

        header("location: /consultar_enfermedad/modelo/ocurrencia.php");
        exit;

    } while (false);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categoría de Ocurrencia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.rawgit.com/RobinHerbots/Inputmask/5.x/dist/jquery.inputmask.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
</head>

<body>
<?php include('../index.html');?>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>

    <script>
        // Inicializar el selector de fecha
        $(document).ready(function () {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        });
    </script>
    <div class="container my-5">
        <h2>Nueva Categoría de Ocurrencia</h2>

        <?php
        if (!empty($mensaje_error)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$mensaje_error</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>

        <form method="post">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">ID Ocurrencia</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="id_ocurrencia" value="<?php echo $id_ocurrencia; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Nivel</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="nivel" value="<?php echo $nivel; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Mayor que</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" name="mayor_que" value="<?php echo $mayor_que; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Fecha Inicial</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control datepicker" name="fecha_inicial" value="<?php echo $fecha_inicial; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Fecha Final</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control datepicker" name="fecha_final" value="<?php echo $fecha_final; ?>">
                </div>
            </div>

            <?php
            if (!empty($mensaje_exitoso)) {
                echo "
                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>$mensaje_exitoso</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
                ";
            }
            ?>

            <div class="row mb-1">
                <div class="offset-sm-2 col-sm-2 d-grid">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                <div class="col-sm-2 d-grid">
                    <a class="btn btn-outline-danger" href="/consultar_enfermedad/modelo/ocurrencia.php" role="button">Cancelar</a>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Inicializar el selector de fecha
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    </script>
</body>

</html>
