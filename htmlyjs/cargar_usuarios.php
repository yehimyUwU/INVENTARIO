<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventarios";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT id_usuario, nombre, apellido, email FROM usuario";
$result = $conn->query($sql);

$usuarios = array();
while ($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($usuarios);
?>
