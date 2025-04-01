<?php
require_once '../../config/conexion.php';

try {
    $conn = Conexion::conectar();
    $sql = "SELECT id_categoria, nombre FROM categoria";
    $stmt = $conn->query($sql);
    $categorias = $stmt->fetchAll();

    header('Content-Type: application/json');
    echo json_encode($categorias);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al cargar categorías: ' . $e->getMessage()]);
}
?>
