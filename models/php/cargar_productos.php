<?php
require_once '../../config/conexion.php';

try {
    $conn = Conexion::conectar();
    $sql = "SELECT id_producto, nombre, descripcion, precio, stock FROM producto";
    $stmt = $conn->query($sql);
    $productos = $stmt->fetchAll();

    header('Content-Type: application/json');
    echo json_encode($productos);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al cargar productos: ' . $e->getMessage()]);
}
?>
