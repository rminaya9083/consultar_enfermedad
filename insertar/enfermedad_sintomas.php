<?php
include('../db.php');

// Inicializar las variables
$mensaje_error = "";
$mensaje_exitoso = "";

// Obtener datos de la tabla enfermedad
$sql_enfermedad = "SELECT id_enfermedad, enfermedad FROM enfermedad";
$result_enfermedad = $conn->query($sql_enfermedad);

// Obtener datos de la tabla sintoma
$sql_sintoma = "SELECT id_sintoma, sintoma FROM sintoma";
$result_sintoma = $conn->query($sql_sintoma);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener valores del formulario
    $id_enfermedad = $_POST["id_enfermedad"];
    $sintomas = $_POST["sintomas"];

    do {
        // Validar campos del formulario
        if (empty($id_enfermedad) || empty($sintomas)) {
            $mensaje_error = "Todos los campos son requeridos";
            break;
        }
    
        // Eliminar elementos vacíos del array de síntomas
        $sintomas = array_filter($sintomas);
    
        // Verificar si hay síntomas seleccionados
        if (empty($sintomas)) {
            $mensaje_error = "Debes seleccionar al menos un síntoma";
            break;
        }
    
        // Convertir array de síntomas a cadena
        $sintomas_texto = implode(',', $sintomas);
    
        // Llamar al procedimiento almacenado
        $sql = "CALL InsertarSintomas(?, ?)";
        $stmt = $conn->prepare($sql);
    
        if (!$stmt) {
            $mensaje_error = "Error de preparación de la consulta: " . $conn->error;
            break;
        }
    
        $stmt->bind_param("is", $id_enfermedad, $sintomas_texto);
        $result = $stmt->execute();
    
        if (!$result) {
            $mensaje_error = "Error al ejecutar la consulta: " . $stmt->error;
            break;
        }
    
        $mensaje_exitoso = "Síntomas agregados correctamente";

        header("location: /consultar_enfermedad/modelo/enfermedad_sintomas.php");
        exit;
    
    } while (false);
    
    
}

// Función para mostrar mensajes de alerta
function mostrarMensaje($mensaje, $tipo) {
    echo "
        <div class='alert alert-$tipo alert-dismissible fade show' role='alert'>
            <strong>$mensaje</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' arial-label='Close'></button>
        </div>
    ";
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
<?php include('../index.html');?>
    <div class="container my-5">
        <h2>Nueva Sintomatología</h2>

        <?php
        if (!empty($mensaje_error)) {
            mostrarMensaje($mensaje_error, 'warning');
        }

        if (!empty($mensaje_exitoso)) {
            mostrarMensaje($mensaje_exitoso, 'success');
        }
        ?>

        <form method="post" onsubmit="return validarFormulario()">
            <div class="row mb-3">
                <br><label class="col-sm-1 col-form-label"><h6>Enfermedad</h6></label>
                <div class="col-sm-6">
                    <!-- Lista desplegable para seleccionar enfermedad -->
                    <select class="form-select" name="id_enfermedad">
                        <option value='' selected>Seleccionar una opción</option>";
                        <?php
                        while ($row_enfermedad = $result_enfermedad->fetch_assoc()) {
                            echo "<option value='{$row_enfermedad['id_enfermedad']}'>{$row_enfermedad['enfermedad']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <?php
            // Crear 12 listas desplegables para seleccionar síntomas
            for ($i = 1; $i <= 10; $i++) {
                echo "
                <div class='row mb-3'>
                    <label class='col-sm-1 col-form-label'>Síntoma $i</label>
                    <div class='col-sm-4'>
                        <select class='form-select' name='sintomas[]'>
                            <option value='' selected>Seleccionar una opción</option>";

                // Dentro del bucle while para imprimir las opciones
                $result_sintoma->data_seek(0); // Restablecer el puntero del resultado
                while ($row_sintoma = $result_sintoma->fetch_assoc()) {
                    echo "<option value='{$row_sintoma['id_sintoma']}'>{$row_sintoma['sintoma']}</option>";
                }

                // Continuación del código HTML
                echo "
                        </select>
                    </div>
                </div>
                ";
            }
            ?>

            <div class="row mb-1">
                <div class="offset-sm-1 col-sm-2 d-grid">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                <div class="col-sm-2 d-grid">
                    <a class="btn btn-outline-danger" href="/consultar_enfermedad/modelo/enfermedad_sintomas.php" role="button">Cancelar</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Integrar Bootstrap JavaScript al final del cuerpo del documento -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
        function validarFormulario() {
            // Obtener todas las listas desplegables de síntomas
            var sintomasSelects = document.getElementsByName('sintomas[]');

            // Verificar si al menos una opción ha sido seleccionada
            var alMenosUnSintomaSeleccionado = Array.from(sintomasSelects).some(function (select) {
                return select.value !== '';
            });

            // Mostrar una alerta si ningún síntoma ha sido seleccionado
            if (!alMenosUnSintomaSeleccionado) {
                alert('Selecciona al menos un síntoma');
                return false; // Evitar que el formulario se envíe
            }

            // Si al menos un síntoma ha sido seleccionado, permitir el envío del formulario
            return true;
        }
    </script>
</body>

</html>
