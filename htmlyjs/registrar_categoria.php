<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventarios";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Conexión fallida: ' . $conn->connect_error]));
}

$nombreCategoria = $_POST['nombreCategoria'];
$descripcionCategoria = $_POST['descripcionCategoria'];

$sql = "INSERT INTO categoria (nombre, descripcion) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die(json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta: ' . $conn->error]));
}
$stmt->bind_param("ss", $nombreCategoria, $descripcionCategoria);

$response = array();
if ($stmt->execute()) {
    $response['success'] = true;
    $response['message'] = 'Categoría registrada exitosamente';
    $response['nombreCategoria'] = $nombreCategoria;
    $response['descripcionCategoria'] = $descripcionCategoria;
} else {
    $response['success'] = false;
    $response['message'] = 'Error al ejecutar la consulta: ' . $stmt->error;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
