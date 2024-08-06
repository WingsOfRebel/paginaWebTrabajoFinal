<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action == 'add') {
        $departamento = $_POST['departamento'];
        $id_provincia = $_POST['id_provincia'];

        $sql = "INSERT INTO departamentos (departamento, id_provincia) VALUES (?, ?)";
        $params = array($departamento, $id_provincia);

        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            http_response_code(500);
        } else {
            http_response_code(200);
        }
        sqlsrv_free_stmt($stmt);
    } elseif ($action == 'update') {
        $iddepartamento = $_POST['iddepartamento'];
        $departamento = $_POST['departamento'];
        $id_provincia = $_POST['id_provincia'];

        $sql = "UPDATE departamentos SET departamento = ?, id_provincia = ? WHERE iddepartamento = ?";
        $params = array($departamento, $id_provincia, $iddepartamento);

        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            http_response_code(500);
        } else {
            http_response_code(200);
        }
        sqlsrv_free_stmt($stmt);
    } elseif ($action == 'delete') {
        $iddepartamento = $_POST['iddepartamento'];

        $sql = "DELETE FROM departamentos WHERE iddepartamento = ?";
        $params = array($iddepartamento);

        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            http_response_code(500);
        } else {
            http_response_code(200);
        }
        sqlsrv_free_stmt($stmt);
    } else {
        http_response_code(400); // Acción no válida
    }

    sqlsrv_close($conn);
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT iddepartamento, departamento, id_provincia FROM departamentos";
    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $departamentos = array();
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $departamentos[] = $row;
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);

    // Encode the data to JSON format
    header('Content-Type: application/json');
    echo json_encode($departamentos);
} else {
    http_response_code(405); // Método no permitido
}
?>
