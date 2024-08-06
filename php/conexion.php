<?php

// Permitir el acceso desde cualquier origen (esto no es recomendado para producción)
header("Access-Control-Allow-Origin: *");

// Permitir los métodos HTTP que deseas permitir
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

// Permitir los encabezados que deseas permitir
header("Access-Control-Allow-Headers: Content-Type");

$serverName = "DESKTOP-VRAH6U6\MSSQLSERVERREPLI"; // e.g., "localhost" or "127.0.0.1"
$connectionOptions = array(
    "Database" => "restaurant",
    "Uid" => "",
    "PWD" => ""
);

// Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));

        echo "Conexión fallida";
}


?>