<?php
include 'conexion.php';

$tipo_documento = $_POST['tipo_documento'];
$documento = $_POST['documento'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$genero = $_POST['genero'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$rol = $_POST['rol'];

$sql = "INSERT INTO usuario (tipo_documento, documento, nombre, apellido, fecha_nacimiento, genero, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssss", $tipo_documento, $documento, $nombre, $apellido, $fecha_nacimiento, $genero, $email, $password);

try {
    if ($stmt->execute()) {
        $id_usuario = $stmt->insert_id;
        $sql_rol = "INSERT INTO usuario_rol (id_usuario, id_rol) VALUES (?, (SELECT id_rol FROM rol_usuario WHERE nombre = ?))";
        $stmt_rol = $conn->prepare($sql_rol);
        $stmt_rol->bind_param("is", $id_usuario, $rol);
        $stmt_rol->execute();
        echo json_encode(["status" => "success", "message" => "Registro exitoso"]);
    } else {
        throw new Exception($stmt->error);
    }
} catch (Exception $e) {
    if ($conn->errno === 1062) {
        echo json_encode(["status" => "error", "message" => "El documento o correo ya está registrado"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
    }
}

$stmt->close();
$conn->close();
?>
