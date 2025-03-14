<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventarios";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT id_categoria, nombre FROM categoria";
$result = $conn->query($sql);

$categorias = array();
while ($row = $result->fetch_assoc()) {
    $categorias[] = $row;
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($categorias);
?>
