<?php
include('../db.php');

$id_enfermedad = "";
$enfermedad = "";

$mensaje_error = "";
$mensaje_exitoso = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id_enfermedad = $_GET["id"];

    $sql = "SELECT * FROM enfermedad WHERE id_enfermedad = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_enfermedad);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result || $result->num_rows == 0) {
        header("location: /consultar_enfermedad/modelo/enfermedad.php");
        exit;
    }

    $row = $result->fetch_assoc();
    $id_enfermedad = $row["id_enfermedad"];
    $enfermedad = $row["enfermedad"];

    $stmt->close();
} else {
    $id_enfermedad = $_POST["id"];
    $enfermedad = $_POST["enfermedad"];

    do {
        if (empty($id_enfermedad) || empty($enfermedad)) {
            $mensaje_error = "Todos los campos son requerido";
            break;
        }

        $sql = "UPDATE enfermedad SET enfermedad = ? WHERE id_enfermedad = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $enfermedad, $id_enfermedad);
        $result = $stmt->execute();

        if (!$result) {
            $mensaje_error = "Query inválid_enfermedado: " . $conn->error;
            break;
        }

        $mensaje_exitoso = "enfermedad actualizado correctamente";

        header("location: /consultar_enfermedad/modelo/enfermedad.php");
        exit;

    } while (true);
}
?>


<!DOCTYPE html>
<html lang = "en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="wid_enfermedadth=device-wid_enfermedadth, initial-scale=1.0">
    <title>Consultorio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Nuevo enfermedad</h2>
            
        <?php
        if(!empty($mensaje_error)){
            echo"
            <div class='alert alert-warning alert-dismissible fade show' enfermedade='alert'>
                <strong>$mensaje_error</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' arial-label='Close'></button>
            </div>
            ";
        }
        ?>

        <form method="post">
            <input type="hidden" name="id"  value="<?php echo $id_enfermedad; ?>">
            <div class="row mb-6">
                <label class="col-sm-1 col-form-label">Id</label>
                <div class="col-sm-6">
                    <input type="text"  class="form-contenfermedad" name="id" value="<?php echo $id_enfermedad;?>">
                </div>
            </div>
            <div class="row mb-6"> 
                <label class="col-sm-1 col-form-label">enfermedad</label>
                <div class="col-sm-6">
                    <input type="text"  class="form-contenfermedad" name="enfermedad" value="<?php echo $enfermedad;?>">
                </div>
            </div>

            <?php
        if(!empty($mensaje_exitoso)){
            echo"
            <div class='alert alert-warning alert-dismissible fade show' enfermedad='alert'>
                <strong>$mensaje_exitoso</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' arial-label='Close'></button>
            </div>
            ";
        }
        ?>

            <div class="row mb-1">
                <div class="offset-sm-1 col-sm-2 d-grid_enfermedad">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                <div class="col-sm-2 d-grid_enfermedad">
                    <a class="btn btn-outline-danger" href="/consultar_enfermedad/modelo/enfermedad.php" enfermedade="button">Cancelar</a>
                </div>
            </div>
        </form>

    </div>
</body>