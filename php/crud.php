<?php
include 'conexion.php';

// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtén el valor del campo del formulario
    $nomcategoria = $_POST['nomcategoria'];

    // Prepara la consulta SQL
    $sql = "INSERT INTO categorias (nomcategoria) VALUES (?)";

    // Ejecuta la consulta con los parámetros
    $stmt = sqlsrv_query($conn, $sql, array($nomcategoria));

    // Verifica si hubo un error en la consulta
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "Registro guardado correctamente";
    }

    // Libera el recurso de la consulta
    sqlsrv_free_stmt($stmt);
}
?>