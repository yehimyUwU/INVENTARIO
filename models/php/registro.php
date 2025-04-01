<?php
require_once '../../config/conexion.php'; // Ruta ajustada

$tipo_documento = $_POST['tipo_documento'];
$documento = $_POST['documento'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$genero = $_POST['genero'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$rol = $_POST['rol'];

$conn = Conexion::conectar(); // Asegurarse de inicializar la conexión

$sql = "INSERT INTO usuario (tipo_documento, documento, nombre, apellido, fecha_nacimiento, genero, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

try {
    $stmt->execute([$tipo_documento, $documento, $nombre, $apellido, $fecha_nacimiento, $genero, $email, $password]);
    $id_usuario = $conn->lastInsertId();

    $sql_rol = "INSERT INTO usuario_rol (id_usuario, id_rol) VALUES (?, (SELECT id_rol FROM rol_usuario WHERE nombre = ?))";
    $stmt_rol = $conn->prepare($sql_rol);
    $stmt_rol->execute([$id_usuario, $rol]);

    echo json_encode(["status" => "success", "message" => "Registro exitoso"]);
} catch (PDOException $e) {
    if ($e->getCode() === '23000') { // Código de error para duplicados
        echo json_encode(["status" => "error", "message" => "El documento o correo ya está registrado"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
    }
}
?>
