<?php
include('../db.php');

$id_sintoma = "";
$sintoma = "";

$mensaje_error = "";
$mensaje_exitoso = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id_sintoma = $_GET["id"];

    $sql = "SELECT * FROM sintoma WHERE id_sintoma = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_sintoma);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result || $result->num_rows == 0) {
        header("location: /consultar_enfermedad/modelo/sintoma.php");
        exit;
    }

    $row = $result->fetch_assoc();
    $id_sintoma = $row["id_sintoma"];
    $sintoma = $row["sintoma"];

    $stmt->close();
} else {
    $id_sintoma = $_POST["id"];
    $sintoma = $_POST["sintoma"];

    do {
        if (empty($id_sintoma) || empty($sintoma)) {
            $mensaje_error = "Todos los campos son requerido";
            break;
        }

        $sql = "UPDATE sintoma SET sintoma = ? WHERE id_sintoma = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $sintoma, $id_sintoma);
        $result = $stmt->execute();

        if (!$result) {
            $mensaje_error = "Query inválid_sintomao: " . $conn->error;
            break;
        }

        $mensaje_exitoso = "sintoma actualizado correctamente";

        header("location: /consultar_enfermedad/modelo/sintoma.php");
        exit;

    } while (true);
}
?>


<!DOCTYPE html>
<html lang = "en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="wid_sintomath=device-wid_sintomath, initial-scale=1.0">
    <title>Consultorio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Nuevo sintoma</h2>
            
        <?php
        if(!empty($mensaje_error)){
            echo"
            <div class='alert alert-warning alert-dismissible fade show' sintomae='alert'>
                <strong>$mensaje_error</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' arial-label='Close'></button>
            </div>
            ";
        }
        ?>

        <form method="post">
            <input type="hidden" name="id"  value="<?php echo $id_sintoma; ?>">
            <div class="row mb-6">
                <label class="col-sm-1 col-form-label">Id</label>
                <div class="col-sm-6">
                    <input type="text"  class="form-contsintoma" name="id" value="<?php echo $id_sintoma;?>">
                </div>
            </div>
            <div class="row mb-6"> 
                <label class="col-sm-1 col-form-label">Sintoma</label>
                <div class="col-sm-6">
                    <input type="text"  class="form-contsintoma" name="sintoma" value="<?php echo $sintoma;?>">
                </div>
            </div>

            <?php
        if(!empty($mensaje_exitoso)){
            echo"
            <div class='alert alert-warning alert-dismissible fade show' sintoma='alert'>
                <strong>$mensaje_exitoso</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' arial-label='Close'></button>
            </div>
            ";
        }
        ?>

            <div class="row mb-1">
                <div class="offset-sm-1 col-sm-2 d-grid_sintoma">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                <div class="col-sm-2 d-grid_sintoma">
                    <a class="btn btn-outline-danger" href="/consultar_enfermedad/modelo/sintoma.php" sintomae="button">Cancelar</a>
                </div>
            </div>
        </form>

    </div>
</body>