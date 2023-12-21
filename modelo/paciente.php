<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultorio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</head>

<body>
    <?php include('../index.html');?>
    <div class="container my-5">
        <h2>Lista de pacientes</h2>
        <a class="btn btn-success" href="/consultar_enfermedad/insertar/paciente.php" role="button">Nuevo paciente</a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Sexo</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include("../db.php");
                $sql = "SELECT * FROM paciente ORDER BY id_paciente ASC";
                $result = $conn->query($sql);

                if (!$result) {
                    die("Query inválido: " . $conn->error);
                }

                while ($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>$row[id_paciente]</td>
                        <td>$row[nombre]</td>
                        <td>$row[apellido]</td>
                        <td>$row[fecha_nacimiento]</td>
                        <td>$row[sexo]</td>
                        <td>$row[direccion]</td>
                        <td>$row[telefono]</td>
                        <td>$row[correo]</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='/consultar_enfermedad/editar/paciente.php?id=$row[id_paciente]'>Editar</a>
                            <a class='btn btn-danger btn-sm' href='/consultar_enfermedad/borrar/paciente.php?id=$row[id_paciente]'>Eliminar</a>
                        </td>                        
                    </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
