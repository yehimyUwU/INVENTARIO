<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventarios";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT id_producto, nombre, descripcion, precio, stock FROM producto";
$result = $conn->query($sql);

$productos = array();
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($productos);
?>
