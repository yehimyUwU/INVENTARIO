<?php
require_once '../../config/conexion.php'; // Ajustar la ruta

$id_categoria = $_POST['categoriaGeneral'];
$nombreSubcategoria = $_POST['nombreSubcategoria'];
$descripcionSubcategoria = $_POST['descripcionSubcategoria'];

try {
    $conn = Conexion::conectar();
    $sql = "INSERT INTO subcategoria (id_categoria, nombre, descripcion) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_categoria, $nombreSubcategoria, $descripcionSubcategoria]);

    echo json_encode([
        'success' => true,
        'id_subcategoria' => $conn->lastInsertId(),
        'nombre' => $nombreSubcategoria,
        'descripcion' => $descripcionSubcategoria
    ]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
