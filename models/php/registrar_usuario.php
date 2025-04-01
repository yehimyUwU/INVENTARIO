<?php
require_once '../../config/conexion.php';

$tipoDocumento = $_POST['tipoDocumento'] ?? null;
$documento = $_POST['documento'] ?? null;
$nombre = $_POST['nombre'] ?? null;
$apellido = $_POST['apellido'] ?? null;
$fechaNacimiento = $_POST['fechaNacimiento'] ?? null;
$genero = $_POST['genero'] ?? null;
$email = $_POST['email'] ?? null;
$password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;

if (!$tipoDocumento || !$documento || !$nombre || !$apellido || !$fechaNacimiento || !$genero || !$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
    exit;
}

try {
    $conn = Conexion::conectar();
    $sql = "INSERT INTO usuario (tipo_documento, documento, nombre, apellido, fecha_nacimiento, genero, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$tipoDocumento, $documento, $nombre, $apellido, $fechaNacimiento, $genero, $email, $password]);

    echo json_encode(['success' => true, 'message' => 'Usuario registrado con éxito']);
} catch (PDOException $e) {
    if ($e->getCode() === '23000') { // Código de error para duplicados
        echo json_encode(['success' => false, 'message' => 'El documento o correo ya está registrado']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar el usuario: ' . $e->getMessage()]);
    }
}
?>
