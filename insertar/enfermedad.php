<?php
include('../db.php');

// Inicializar las variables
$id = "";
$enfermedad = "";
$mensaje_error = "";
$mensaje_exitoso = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST["id"];
    $enfermedad = $_POST["enfermedad"];

    do {
        if (empty($id) || empty($enfermedad)) {
            $mensaje_error = "Todos los campos son requeridos";
            break;
        }

        $sql = "INSERT INTO enfermedad (id_enfermedad, enfermedad) VALUES ('$id', '$enfermedad')";
        $result = $conn->query($sql);

        if (!$result) {
            $mensaje_error = "Query inválido: " . $conn->error;
            break;
        }

        // Limpiar las variables después de la inserción exitosa
        $id = "";
        $sintoma = "";

        $mensaje_exitoso = "Rol agregado correctamente";

        header("location: /consultar_enfermedad/modelo/enfermedad.php");
        exit;

    } while (false);
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
<?php include('../index.html');?>
    <div class="container my-5">
        <h2>Nueva enfermedad</h2>
            
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
            <div class="row mb-3">
                <label class="col-sm-1 col-form-label">Id</label>
                <div class="col-sm-4">
                    <input type="text"  class="form-control" name="id" value="<?php echo $id;?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <label class="col-sm-1 col-form-label">Enfermedad</label>
                <div class="col-sm-4">
                    <input type="text"  class="form-control" name="enfermedad" value="<?php echo $enfermedad;?>">
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
                    <a class="btn btn-outline-danger" href="/consultar_enfermedad/modelo/enfermedad.php" role="button">Cancelar</a>
                </div>
            </div>
        </form>

    </div>
</body>