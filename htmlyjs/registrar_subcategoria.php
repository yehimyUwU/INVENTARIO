<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventarios";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Conexión fallida: ' . $conn->connect_error]));
}

$id_categoria = $_POST['categoriaGeneral'];
$nombreSubcategoria = $_POST['nombreSubcategoria'];
$descripcionSubcategoria = $_POST['descripcionSubcategoria'];

$sql = "INSERT INTO subcategoria (id_categoria, nombre, descripcion) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die(json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta: ' . $conn->error]));
}
$stmt->bind_param("iss", $id_categoria, $nombreSubcategoria, $descripcionSubcategoria);

$response = array();
if ($stmt->execute()) {
    $response['success'] = true;
    $response['id_subcategoria'] = $stmt->insert_id;
    $response['nombre'] = $nombreSubcategoria;
    $response['descripcion'] = $descripcionSubcategoria;
} else {
    $response['success'] = false;
    $response['message'] = 'Error al ejecutar la consulta: ' . $stmt->error;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
