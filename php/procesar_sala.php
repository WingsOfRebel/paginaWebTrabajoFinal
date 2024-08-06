<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action == 'add') {
        $nomsalas = $_POST['nomsalas'];
        $fecha = $_POST['fecha'];
        $fecha_formateada = date("Y-m-d", strtotime($fecha));

        $sql = "INSERT INTO salas (nomsalas, fecha) VALUES (?, ?)";
        $params = array($nomsalas, $fecha_formateada);
    } elseif ($action == 'update') {
        $id = $_POST['id'];
        $nomsalas = $_POST['nomsalas'];
        $fecha = $_POST['fecha'];
        $fecha_formateada = date("Y-m-d", strtotime($fecha));

        $sql = "UPDATE salas SET nomsalas = ?, fecha = ? WHERE id = ?";
        $params = array($nomsalas, $fecha_formateada, $id);
    } elseif ($action == 'delete') {
        $id = $_POST['id'];

        $sql = "DELETE FROM salas WHERE id = ?";
        $params = array($id);
    }

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        http_response_code(500);
    } else {
        http_response_code(200);
    }

    sqlsrv_free_stmt($stmt);

} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT id, nomsalas, fecha FROM salas";

    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $results = array();
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $results[] = $row;
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);

    // Encode the data to JSON format
    header('Content-Type: application/json');
    echo json_encode($results);

} else {
    http_response_code(405);
    echo "Método de solicitud no permitido.";
}
?>
