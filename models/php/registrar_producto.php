<?php
require_once '../../config/conexion.php'; // Ajustar la ruta

$nombreProducto = $_POST['nombreProducto'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$id_categoria = $_POST['categoriaGeneral'];
$id_subcategoria = $_POST['subcategoria'];
$imagenProducto = addslashes(file_get_contents($_FILES['imagenProducto']['tmp_name']));

try {
    $conn = Conexion::conectar();
    $sql = "INSERT INTO producto (nombre, descripcion, precio, stock, id_categoria, imagen) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nombreProducto, $descripcion, $precio, $stock, $id_categoria, $imagenProducto]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
