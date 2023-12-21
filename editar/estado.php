<?php
include('../db.php');

$id = "";
$estado = "";

$mensaje_error = "";
$mensaje_exitoso = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET["id"];

    $sql = "SELECT * FROM estado WHERE id_estado = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result || $result->num_rows == 0) {
        header("location: /consultar_enfermedad/index.php");
        exit;
    }

    $row = $result->fetch_assoc();
    $id = $row["id_estado"];
    $estado = $row["estado"];

    $stmt->close();
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST["id"];
    $estado = $_POST["estado"];

    do {
        if (empty($estado)) {
            $mensaje_error = "El campo de estado es requerido";
            break;
        }

        $sql = "UPDATE estado SET estado = ? WHERE id_estado = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $estado, $id);
        $result = $stmt->execute();

        if (!$result) {
            $mensaje_error = "Query inválido: " . $conn->error;
            break;
        }

        $mensaje_exitoso = "Estado actualizado correctamente";

        header("location: ../../consultar_enfermedad/modelo/estado.php");
        exit;

    } while (true);
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container my-5">
        <h2>Editar Estado</h2>

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
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="row mb-3">
                <label class="col-sm-1 col-form-label">ID</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="id" value="<?php echo $id; ?>" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-1 col-form-label">Estado</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="estado" value="<?php echo $estado; ?>">
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
                    <a class="btn btn-outline-danger" href="../../consultar_enfermedad/modelo/estado.php" role="button">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
