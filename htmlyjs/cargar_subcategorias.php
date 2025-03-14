<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventarios";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id_categoria = $_GET['id_categoria'];
$sql = "SELECT id_subcategoria, nombre FROM subcategoria WHERE id_categoria = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_categoria);
$stmt->execute();
$result = $stmt->get_result();

$subcategorias = array();
while ($row = $result->fetch_assoc()) {
    $subcategorias[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($subcategorias);
?>
