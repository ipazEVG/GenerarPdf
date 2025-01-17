<?php
// Incluir la libbrería FPDF
require_once 'fpdf186\fpdf.php';
require_once 'configdb.php';

// Configutación de conexión
$tabla = "employee";


// Consultar los datos de la tabla
$consulta = "SELECT * FROM $tabla";
$resultado = $conexion->query($consulta);

// Verificacíon de consulta
If ($resultado -> num_rows > 0){

   // Crear objeto PDF
   $ObjPdf = new FPDF('L', 'mm', 'A4'); // Formato horizontal para más espacio
   $ObjPdf->SetMargins(5, 5); 
   $ObjPdf->AddPage();
   $ObjPdf->SetFont('Arial', 'B', 8);

     // Obtener nombres de las columnas
     $columnas = array_keys($resultado->fetch_assoc());
     $resultado->data_seek(0); // hace que aparezca la primera celda
     // Ajustar ancho de las celdas dependiendo de la cantidad de columnas
    $anchoCelda = (297 - 10) / count($columnas); // Ancho total de página menos márgenes

    // Agregar encabezados
    foreach ($columnas as $columna) {
        $ObjPdf->Cell($anchoCelda, 8, mb_convert_encoding(ucfirst($columna), 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
    }
    $ObjPdf->Ln(); // Nueva línea

    $ObjPdf->SetFont('Times', '', 9);

    // Agregar filas de datos
    while ($fila = $resultado->fetch_assoc()) {
        foreach ($fila as $valor) {
            $ObjPdf->Cell($anchoCelda, 8, mb_convert_encoding($valor, 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        }
        $ObjPdf->Ln(); // Nueva línea
    }

    // Guardar el PDF en un archivo temporal
    $ruta_pdf = 'listado_tabla.pdf';
    $ObjPdf->Output('F', $ruta_pdf);

    // Mostrar el PDF en el navegador
    echo '<iframe src="' . $ruta_pdf . '" width="100%" height="100%" style="border:none;"></iframe>'; // Incrusta el PDF en un iframe, sin bordes y ajustado al 100% del tamaño de la pantalla.


} else {
    echo "No se encontraron registros en la base de datos.";
}

// Cerrar la conexión de la base de datos
$conexion->close();
?>