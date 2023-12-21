<?php
include('../db.php');

$enfermedades_concatenadas = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los síntomas seleccionados en el formulario
    $sintomas = isset($_POST['sintomas']) ? $_POST['sintomas'] : null;
    $valor = isset($_POST['valor']) ? $_POST['valor'] : null;
    $tiempo = isset($_POST['tiempo']) ? $_POST['tiempo'] : null;

    if ($sintomas !== null && $valor !== null && $tiempo !== null) {
        // Convertir los síntomas a una cadena segura para la consulta SQL
        $sintomas_busqueda = implode(',', array_map('intval', $sintomas));

        // Consulta 1
        $sql_set = "SET @sintoma = ?; SET @valor = ?; SET @tiempo = ?;";
        $sql_main = "
            SELECT 
                GROUP_CONCAT(enfermedad ORDER BY custom_order DESC, enfermedad SEPARATOR ',  ') AS enfermedades_concatenadas
            FROM (
                -- Consulta 2
                SELECT 
                    e.enfermedad,
                    0 AS custom_order,
                    GROUP_CONCAT(es.id_sintoma ORDER BY FIND_IN_SET(es.id_sintoma, @sintoma)) AS sintomas_ordenados,
                    '' AS enfermedad_resultante
                FROM enfermedad_sintoma es
                JOIN enfermedad e ON es.id_enfermedad = e.id_enfermedad
                WHERE FIND_IN_SET(es.id_sintoma, @sintoma) > 0
                GROUP BY e.enfermedad

                UNION ALL

                -- Consulta 1
                SELECT 
                    e.enfermedad,
                    CASE WHEN e.enfermedad COLLATE utf8mb4_unicode_ci = @sintoma THEN 0 ELSE 1 END AS custom_order,
                    '' AS sintomas_ordenados,
                    e.enfermedad AS enfermedad_resultante
                FROM detalle_sintomas ds
                JOIN enfermedad e ON ds.id_enfermedad = e.id_enfermedad
                WHERE
                    FIND_IN_SET(id_sintoma, @sintoma) > 0
                    AND ds.valor_min <= CAST(SUBSTRING_INDEX(@valor, ',', FIND_IN_SET(id_sintoma, @sintoma)) AS UNSIGNED)
                    AND ds.valor_max >= CAST(SUBSTRING_INDEX(@valor, ',', FIND_IN_SET(id_sintoma, @sintoma)) AS UNSIGNED)
                    AND ds.tiempo_min <= CAST(SUBSTRING_INDEX(@tiempo, ',', FIND_IN_SET(id_sintoma, @sintoma)) AS UNSIGNED)
                    AND ds.tiempo_max >= CAST(SUBSTRING_INDEX(@tiempo, ',', FIND_IN_SET(id_sintoma, @sintoma)) AS UNSIGNED)
            ) AS resultado;
        ";

        // Preparar y ejecutar las consultas
        if (mysqli_multi_query($conn, $sql_set . $sql_main)) {
            // Obtener el resultado de la consulta principal
            mysqli_next_result($conn); // Saltar la primera consulta SET
            $resultado = mysqli_store_result($conn);
            $fila = mysqli_fetch_assoc($resultado);
            $enfermedades_concatenadas = $fila['enfermedades_concatenadas'];

            // Almacena el resultado en una sesión
            session_start();
            $_SESSION['enfermedades_concatenadas'] = $enfermedades_concatenadas;

            // Redirige a consulta.php
            header("Location: consulta.php");
            exit();
        } else {
            echo "Error en la consulta: " . mysqli_error($conn);
        }
    } 
}
?>
