<?php
session_start();
require_once '../../config/conexion.php'; // Ajustar la ruta

$id_usuario = $_SESSION['id_usuario'];

try {
    $conn = Conexion::conectar();
    $sql = "SELECT tipo_documento, documento, nombre, apellido, fecha_nacimiento, genero, email FROM usuario WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_usuario]);
    $perfil = $stmt->fetch();
    
    header('Content-Type: application/json');
    echo json_encode($perfil);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al obtener el perfil: ' . $e->getMessage()]);
}
?>
