<?php

$host = "rds-selecu.cdwgxarbeipl.us-east-1.rds.amazonaws.com";
$port = 3306;
$password = "UuVHfFf28nSuH2Vu";
$user = "admin";
$database = "prod-selecu";

$conexion = new mysqli($host, $user, $password, $database, $port);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$id = $_GET['id_grupo'];
$id = $conexion->real_escape_string($id);

$query = "SELECT u.identification AS Documento, u.fullName AS Nombre, cd.data AS Checkpoint FROM checkpoint_datum cd 
INNER JOIN `user` u ON u.id = cd.userId 
INNER JOIN institution i ON i.id = u.institutionId 
INNER JOIN group_students gs ON gs.userId = u.id 
INNER JOIN user_products_product upp ON upp.userId = u.id 
WHERE gs.groupId = '$id' AND upp.productId = 10";

$resultado = $conexion->query($query);

if ($resultado->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Nombre</th><th>Checkpoint</th></tr>";
    while ($fila = $resultado->fetch_assoc()) {
        $nombre = $fila['Nombre'];
        $check = $fila['Checkpoint'];

        // Realizar el reemplazo en la cadena
        $check = str_replace('{"currentChapter": ', 'Capítulo ', $check);
        $check = str_replace(', "currentCheckpoint": ', ' - Checkpoint ', $check);
        $check = str_replace('}', '', $check);

        echo "<tr><td>$nombre</td><td>$check</td></tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron resultados para el ID de grupo proporcionado.<br>";
}

$conexion->close();
?>
