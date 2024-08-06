<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta SQL para verificar las credenciales del usuario
    $sql = "SELECT * FROM usuarios WHERE nomusuario = ? AND claveusuario = ?";
    $params = array($username, $password);

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_fetch($stmt)) {
        // Si las credenciales son correctas, se inicia la sesión
        $_SESSION['username'] = $username;
        header("Location: welcome.php");
    } else {
        echo "Nombre de usuario o contraseña incorrectos";
    }

    sqlsrv_free_stmt($stmt);
}
?>

