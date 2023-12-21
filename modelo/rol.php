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
        <h2>Lista de Rol</h2>
        <a class="btn btn-primary" href="/consultar_enfermedad/insertar/rol.php" role="button">Nuevo Rol</a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>                
                    <th>Rol</th>
                    <th>Acción</th>               
                </tr>
            </thead>   
            <tbody>
                <?php
                include("../db.php");
                $sql = "SELECT * FROM rol";
                $result = $conn->query($sql);

                if(!$result){
                    die("Querry invalido: " . $$conn->error);
                }

                while($row = $result ->fetch_assoc()){
                    echo"
                    <tr>
                        <td>$row[id_rol]</td>
                        <td>$row[rol]</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='/consultar_enfermedad/editar/rol.php?id=$row[id_rol]'>Editar</a>
                            <a class='btn btn-danger btn-sm' href='/consultar_enfermedad/borrar/rol.php?id=$row[id_rol]'>Eliminar</a>
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