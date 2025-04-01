<?php
require_once '../../config/conexion.php'; // Ajustar la ruta

$id_categoria = $_GET['id_categoria'] ?? null;

if (!$id_categoria) {
    echo json_encode(['error' => 'ID de categoría no proporcionado']);
    exit;
}

try {
    $conn = Conexion::conectar();
    $sql = "SELECT id_subcategoria, nombre FROM subcategoria WHERE id_categoria = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_categoria]);
    $subcategorias = $stmt->fetchAll();

    header('Content-Type: application/json');
    echo json_encode($subcategorias);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al cargar subcategorías: ' . $e->getMessage()]);
}
?>
