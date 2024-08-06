<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action == 'add') {
        $nommedida = $_POST['nommedida'];
        $descripmedida = $_POST['descripmedida'];

        $sql = "INSERT INTO medidas (nommedida, descripmedida) VALUES (?, ?)";
        $params = array($nommedida, $descripmedida);
    } elseif ($action == 'update') {
        $idmedida = $_POST['idmedida'];
        $nommedida = $_POST['nommedida'];
        $descripmedida = $_POST['descripmedida'];

        $sql = "UPDATE medidas SET nommedida = ?, descripmedida = ? WHERE idmedida = ?";
        $params = array($nommedida, $descripmedida, $idmedida);
    } elseif ($action == 'delete') {
        $idmedida = $_POST['idmedida'];

        $sql = "DELETE FROM medidas WHERE idmedida = ?";
        $params = array($idmedida);
    }

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        http_response_code(500);
    } else {
        http_response_code(200);
    }

    sqlsrv_free_stmt($stmt);

} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT idmedida, nommedida, descripmedida FROM medidas";

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
