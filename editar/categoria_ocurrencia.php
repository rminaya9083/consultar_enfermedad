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

// Verificar si se proporciona un ID para la edición
if (isset($_GET['id'])) {
    $id_ocurrencia_edit = $_GET['id'];
    
    // Obtener los datos existentes de la base de datos
    $sql_edit = "SELECT * FROM categoria_ocurrencia WHERE id_ocurrencia = '$id_ocurrencia_edit'";
    $result_edit = $conn->query($sql_edit);

    if ($result_edit->num_rows > 0) {
        $row_edit = $result_edit->fetch_assoc();

        // Llenar las variables con los datos existentes
        $id_ocurrencia = $row_edit['id_ocurrencia'];
        $nivel = $row_edit['nivel'];
        $mayor_que = $row_edit['mayor_que'];
        $fecha_inicial = $row_edit['fecha_inicial'];
        $fecha_final = $row_edit['fecha_final'];
    } else {
        // Mostrar un mensaje de error si el ID no corresponde a ningún registro
        $mensaje_error = "No se encontró la categoría de ocurrencia con ID: $id_ocurrencia_edit";
    }
}

// Procesamiento del formulario (ya sea para inserción o actualización)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $id_ocurrencia = $_POST["id_ocurrencia"];
    $nivel = $_POST["nivel"];
    $mayor_que = $_POST["mayor_que"];
    $fecha_inicial = $_POST["fecha_inicial"];
    $fecha_final = $_POST["fecha_final"];

    // Validar si se ingresaron datos en el campo de mayor_que antes de guardar
    $mayor_que = !empty($mayor_que) ? $mayor_que : null;

    // Formatear las fechas antes de insertarlas en la base de datos
    $fecha_inicial = date("Y-m-d", strtotime($fecha_inicial));
    $fecha_final = date("Y-m-d", strtotime($fecha_final));

    // Si hay un ID proporcionado, realizar una actualización en lugar de una inserción
    if (!empty($id_ocurrencia)) {
        $sql_update = "UPDATE categoria_ocurrencia SET nivel = '$nivel', mayor_que = '$mayor_que', fecha_inicial = '$fecha_inicial', fecha_final = '$fecha_final' WHERE id_ocurrencia = '$id_ocurrencia'";
        
        $result_update = $conn->query($sql_update);

        if (!$result_update) {
            $mensaje_error = "Error al actualizar la categoría de ocurrencia: " . $conn->error;
            echo $mensaje_error; // Imprimir el mensaje de error para depuración
        } else {
            $mensaje_exitoso = "Categoría de ocurrencia actualizada correctamente";
            header("location: /consultar_enfermedad/modelo/ocurrencia.php");
            exit;
        }
    } else {
        // ... (resto del código para la inserción)
    }
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
