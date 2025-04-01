<?php
require_once '../../config/conexion.php'; // Ajustar la ruta

$nombreCategoria = $_POST['nombreCategoria'];
$descripcionCategoria = $_POST['descripcionCategoria'];

try {
    $conn = Conexion::conectar();
    $sql = "INSERT INTO categoria (nombre, descripcion) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nombreCategoria, $descripcionCategoria]);

    echo json_encode([
        'success' => true,
        'message' => 'Categoría registrada exitosamente',
        'nombreCategoria' => $nombreCategoria,
        'descripcionCategoria' => $descripcionCategoria
    ]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
