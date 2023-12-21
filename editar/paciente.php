<?php
include('../db.php');

$id_paciente = "";
$nombre = "";
$apellido = "";
$fecha_nacimiento = "";
$sexo = "";
$direccion = "";
$telefono = "";
$correo = "";

$mensaje_error = "";
$mensaje_exitoso = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id_paciente = $_GET["id"];

    $sql = "SELECT * FROM paciente WHERE id_paciente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_paciente);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result || $result->num_rows == 0) {
        header("location: /consultar_enfermedad/modelo/paciente.php");
        exit;
    }

    $row = $result->fetch_assoc();
    $id_paciente = $row["id_paciente"];
    $nombre = $row["nombre"];
    $apellido = $row["apellido"];
    $fecha_nacimiento = $row["fecha_nacimiento"];
    $sexo = $row["sexo"];
    $direccion = $row["direccion"];
    $telefono = $row["telefono"];
    $correo = $row["correo"];

    $stmt->close();
} else {
    $id_paciente = $_POST["id"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $sexo = isset($_POST["sexo"]) ? $_POST["sexo"] : "";
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];

    do {
        if (empty($id_paciente) || empty($nombre) || empty($apellido) || empty($fecha_nacimiento) || empty($direccion)) {
            $mensaje_error = "Todos los campos son requeridos";
            break;
        }

        $sql = "UPDATE paciente SET nombre = ?, apellido = ?, fecha_nacimiento = ?, sexo = ?, direccion = ?, telefono = ?, correo = ? WHERE id_paciente = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $nombre, $apellido, $fecha_nacimiento, $sexo, $direccion, $telefono, $correo, $id_paciente);
        $result = $stmt->execute();

        if (!$result) {
            $mensaje_error = "Query inválido: " . $conn->error;
            break;
        }

        $mensaje_exitoso = "Paciente actualizado correctamente";

        header("location: /consultar_enfermedad/modelo/paciente.php");
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
        <h2>Editar Paciente</h2>

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
            <input type="hidden" name="id" value="<?php echo $id_paciente; ?>">
            <div class="row mb-3">
                <label class="col-sm-1 col-form-label">ID</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="id" value="<?php echo $id_paciente; ?>" readonly>
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
                <label class="col-sm-1 col-form-label">Fecha Nacimiento</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" name="fecha_nacimiento" value="<?php echo $fecha_nacimiento; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-1 col-form-label">Sexo</label>
                <div class="col-sm-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sexo" value="Masculino" <?php echo ($sexo == "Masculino") ? "checked" : ""; ?>>
                        <label class="form-check-label">Masculino</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sexo" value="Femenino" <?php echo ($sexo == "Femenino") ? "checked" : ""; ?>>
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
                    <input type="text" class="form-control" name="telefono" value="<?php echo $telefono; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-1 col-form-label">Correo</label>
                <div class="col-sm-4">
                    <input type="email" class="form-control" name="correo" value="<?php echo $correo; ?>">
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
</body>
</html>
