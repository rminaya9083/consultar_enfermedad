<?php
include('../db.php');

// Inicializar las variables
$id = "";
$nombre = "";
$apellido = "";
$fecha_nacimiento = "";
$sexo = "";
$direccion = "";
$telefono = "";
$correo = "";
$mensaje_error = "";
$mensaje_exitoso = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $sexo = isset($_POST["sexo"]) ? $_POST["sexo"] : "";
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];

    do {
        if (empty($id) || empty($nombre) || empty($apellido) || empty($fecha_nacimiento) || empty($direccion)) {
            $mensaje_error = "Todos los campos son requeridos";
            break;
        }

        // Validar si se ingresaron datos en los campos de Teléfono y Correo antes de guardar
        $telefono = !empty($telefono) ? $telefono : null;
        $correo = !empty($correo) ? $correo : null;

        $sql = "INSERT INTO paciente (id_paciente, nombre, apellido, fecha_nacimiento, sexo, direccion, telefono, correo) VALUES ('$id', '$nombre', '$apellido', '$fecha_nacimiento', '$sexo', '$direccion', '$telefono', '$correo')";
        $result = $conn->query($sql);

        if (!$result) {
            $mensaje_error = "Query inválido: " . $conn->error;
            break;
        }

        // Limpiar las variables después de la inserción exitosa
        $id = "";
        $nombre = "";
        $apellido = "";
        $fecha_nacimiento = "";
        $sexo = "";
        $telefono = "";
        $correo = "";

        $mensaje_exitoso = "Paciente agregado correctamente";

        header("location: /consultar_enfermedad/modelo/paciente.php");
        exit;

    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultorio</title>    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> <!-- Agregado el tema de jQuery UI CSS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha384-o+RD/x3pLXR7tnqI8ZgTNEC/Juql8KO9QGhjFO6/QqFmUc9G5U6CtTDZSAyGgAMk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
    <script src="https://cdn.rawgit.com/RobinHerbots/Inputmask/5.x/dist/jquery.inputmask.js"></script>    
</head>

<body>

<body>
<?php include('../index.html');?>
    <div class="container my-5">
        <h2>Nuevo paciente</h2>

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

        <form method="post" class="form-paciente">
            <div class="row mb-3">
                <label class="col-sm-1 col-form-label">ID</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="id" value="<?php echo $id; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-1 col-form-label">Nombre</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="nombre" value="<?php echo $nombre; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-1 col-form-label">Apellido</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="apellido" value="<?php echo $apellido; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-1 col-form-label">Fecha de Nacimiento</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control datepicker" name="fecha_nacimiento" value="<?php echo $fecha_nacimiento; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-1 col-form-label">Sexo</label>
                <div class="col-sm-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sexo" value="Masculino" <?php echo ($sexo == 'Masculino') ? 'checked' : ''; ?>>
                        <label class="form-check-label">Masculino</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sexo" value="Femenino" <?php echo ($sexo == 'Femenino') ? 'checked' : ''; ?>>
                        <label class="form-check-label">Femenino</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-1 col-form-label">Dirección</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="direccion" value="<?php echo $direccion; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-1 col-form-label">Teléfono</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="telefono" id="telefono" value="<?php echo $telefono; ?>" data-inputmask="'mask': '999-999-9999'">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-1 col-form-label">Correo</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="correo" id="correo" value="<?php echo $correo; ?>" data-inputmask="'mask': 'email'">
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
                    <a class="btn btn-outline-danger" href="/consultar_enfermedad/modelo/paciente.php" role="button">Cancelar</a>
                </div>
            </div>
        </form>
    </div>

    <script>
    $(document).ready(function () {
        $('.datepicker').datepicker();
    });
</script>
</body>

</html>
