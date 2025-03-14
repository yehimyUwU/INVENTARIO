<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo_documento = $_POST['tipo_documento'];
    $documento = $_POST['documento'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $genero = $_POST['genero'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $conexion = Conexion::conectar();

    // Verificar si el documento ya existe
    $stmt = $conexion->prepare("SELECT * FROM usuario WHERE documento = :documento");
    $stmt->bindParam(':documento', $documento);
    $stmt->execute();
    $usuarioExistente = $stmt->fetch();

    if ($usuarioExistente) {
        $error = "El documento ya está registrado.";
    } else {
        $stmt = $conexion->prepare("INSERT INTO usuario (tipo_documento, documento, nombre, apellido, fecha_nacimiento, genero, email, password) VALUES (:tipo_documento, :documento, :nombre, :apellido, :fecha_nacimiento, :genero, :email, :password)");
        $stmt->bindParam(':tipo_documento', $tipo_documento);
        $stmt->bindParam(':documento', $documento);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':genero', $genero);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            header('Location: ../htmlyjs/login.html');
        } else {
            $error = "Error al registrar el usuario";
        }
    }
}
?>
