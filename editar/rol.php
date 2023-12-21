<?php
include('../db.php');

$id = "";
$rol = "";

$mensaje_error = "";
$mensaje_exitoso = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET["id"];

    $sql = "SELECT * FROM rol WHERE id_rol = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result || $result->num_rows == 0) {
        header("location: /consultar_enfermedad/index.php");
        exit;
    }

    $row = $result->fetch_assoc();
    $id = $row["id_rol"];
    $rol = $row["rol"];

    $stmt->close();
} else {
    $id = $_POST["id"];
    $rol = $_POST["rol"];

    do {
        if (empty($id) || empty($rol)) {
            $mensaje_error = "Todos los campos son requeridos";
            break;
        }

        $sql = "UPDATE rol SET rol = ? WHERE id_rol = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $rol, $id);
        $result = $stmt->execute();

        if (!$result) {
            $mensaje_error = "Query inválido: " . $conn->error;
            break;
        }

        $mensaje_exitoso = "Rol actualizado correctamente";

        header("location: /consultar_enfermedad/modelo/rol.php");
        exit;

    } while (true);
}
?>


<!DOCTYPE html>
<html lang = "en">

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
        <h2>Nuevo rol</h2>
            
        <?php
        if(!empty($mensaje_error)){
            echo"
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$mensaje_error</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' arial-label='Close'></button>
            </div>
            ";
        }
        ?>

        <form method="post">
            <input type="hidden" name="id"  value="<?php echo $id; ?>">
            <div class="row mb-3">
                <label class="col-sm-1 col-form-label">Id</label>
                <div class="col-sm-4">
                    <input type="text"  class="form-control" name="id" value="<?php echo $id;?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <label class="col-sm-1 col-form-label">rol</label>
                <div class="col-sm-4">
                    <input type="text"  class="form-control" name="rol" value="<?php echo $rol;?>">
                </div>
            </div>

            <?php
        if(!empty($mensaje_exitoso)){
            echo"
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
                    <a class="btn btn-outline-danger" href="/consultar_enfermedad/modelo/rol.php" role="button">Cancelar</a>
                </div>
            </div>
        </form>

    </div>
</body>