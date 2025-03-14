<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventarios";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$nombreProducto = $_POST['nombreProducto'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$id_categoria = $_POST['categoriaGeneral'];
$id_subcategoria = $_POST['subcategoria'];
$imagenProducto = addslashes(file_get_contents($_FILES['imagenProducto']['tmp_name']));

$sql = "INSERT INTO producto (nombre, descripcion, precio, stock, id_categoria, imagen) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdiis", $nombreProducto, $descripcion, $precio, $stock, $id_categoria, $imagenProducto);

$response = array();
if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
