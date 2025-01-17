<?php
require_once 'configdb.php';

$tabla = "employee";
// Consultar los datos de la tabla
$consulta = "SELECT * FROM $tabla";
$resultado = $conexion->query($consulta);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado_de_Datos</title>
    <link rel="stylesheet" href="csslista.css">
</head>
<body class="contenedor">
    <h1>Listado de Datos de la Tabla: <?php echo $tabla; ?></h1>

    <?php 
    // Verificar si hay resultados
    if ($resultado && $resultado->num_rows > 0) {
        echo '<table>';
        echo '<thead>';
        echo '<tr>';

        // Obtener nombres de las columnas y mostrarlas como encabezados
        $columnas = $resultado->fetch_fields();
        foreach ($columnas as $column) {
            echo '<th>' .$column->name. '</th>';
        }
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Iterar sobre los resultados y mostrarlos en filas
        while ($fila = $resultado->fetch_assoc()) {
            echo '<tr>';
            foreach ($fila as $celda) {
                echo '<td>' .$celda. '</td>';
            }
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No se encontraron registros en la tabla '.$tabla.'</p>';
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
    ?>
<br>


<br><a href="descargaPDF.php" class="boton">Ver en PDF</a>

  
</body>
</html>
