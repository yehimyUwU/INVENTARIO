<?php
require_once '../../config/conexion.php';

try {
    $conn = Conexion::conectar();
    $sql = "SELECT id_usuario, nombre, apellido, email FROM usuario";
    $stmt = $conn->query($sql);
    $usuarios = $stmt->fetchAll();

    header('Content-Type: application/json');
    echo json_encode($usuarios);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al cargar usuarios: ' . $e->getMessage()]);
}
?>
