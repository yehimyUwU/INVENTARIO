<?php
session_start();
require 'conexion.php';

$documento = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

if (!$documento || !$password) {
    echo json_encode(["success" => false, "message" => "Por favor, completa todos los campos."]);
    exit;
}

$conexion = Conexion::conectar();
$sql = "SELECT id_usuario, password FROM usuario WHERE documento = ?";
$stmt = $conexion->prepare($sql);
$stmt->execute([$documento]);
$user = $stmt->fetch();

if ($user) {
    if (password_verify($password, $user['password'])) {
        $_SESSION['id_usuario'] = $user['id_usuario'];
        echo json_encode(["success" => true, "message" => "Inicio de sesión exitoso"]);
    } else {
        echo json_encode(["success" => false, "message" => "Contraseña incorrecta"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Usuario no encontrado"]);
}
?>