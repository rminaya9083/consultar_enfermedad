<?php
// Inicia la sesión para poder acceder a la variable
session_start();

// Recupera la variable desde la sesión
$enfermedades_concatenadas = isset($_SESSION['enfermedades_concatenadas']) ? $_SESSION['enfermedades_concatenadas'] : '';

// Elimina la variable de la sesión para evitar que persista
unset($_SESSION['enfermedades_concatenadas']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Síntomas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="../style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
        <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
        <script src="https://kit.fontawesome.com/a076d5399.js"></script>-->
</head>
<body>
<?php include('../index.html');?>
<!--En este cuerpo del archivo vamos a crear varios formulario para poder ejecutar la parte de los sintomas y buscar información del paciente-->
    <div class="container mt-5">
        <h2>Registrar consulta</h2>
        <!--Formulario para obtener nombre del cliente atravez de su codigo-->
        <form method="post" action="">
            
        <?php include('../proceso/paciente.php');?>        

            <div class="row mb-3">
                    <label class="col-sm-1 col-form-label">Id: </label>
                    <div class="col-sm-4">
                        <input type="text"  class="form-control" name="id" value="">                    
                    </div>                    
                <div class="col-md-6">
                    <button type="submit" class="btn btn-success">Detectar</button>
                </div>
            </div>

            <div class="col-md-5">
                <label class="col-sm-1 col-form-label">Nombre_del_paciente_aqui!</label>
            </div>

        </form>

        <!-- Formulario para ejecutar la consulta de sintomas para obtener la enfermedad...-->
        <form method="post" action="../insertar/identificar_enfermedad.php">

            <?php include('../proceso/enfermedad_sintoma.php');?>

            <div class="row mb-3">
        <label for="enfermedad" class="col-sm-1 col-form-label">Enfermedad:</label>
        <div class="col-md-5">
            <input type="text" id="enfermedad" name="enfermedad" class="form-control text-center" value="<?= isset($enfermedades_concatenadas) ? htmlspecialchars($enfermedades_concatenadas) : '' ?>" readonly>
        </div>
        <div class="col-md-6">
            <button type="submit" class="btn btn-success">Detectar</button>
        </div>
    </div>

        </form>     
        
        <form method="post" action="">

            <div class="row mb-3">
                    <label class="col-sm-1 col-form-label">Peso(lb): </label>
                    <div class="col-sm-1">
                        <input type="number" step="0.1"  class="form-control" name="peso" value="">                    
                    </div>         
                    <label class="col-sm-1 col-form-label">Temperatura(C):  </label>
                    <div class="col-sm-1">
                        <input type="number" step="0.1"  class="form-control" name="temperatura" value="">                    
                    </div>  
            </div>   
            <div class="row mb-">
                        <div class="offset-sm-2 col-sm-2 d-grid">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                        <div class="col-sm-2 d-grid">
                            <a class="btn btn-outline-danger" href="/consultar_enfermedad/modelo/consulta.php" role="button">Cancelar</a>
                        </div>
            </div>   
            
        </form>
        
        
    </div>
</body>
</html>
