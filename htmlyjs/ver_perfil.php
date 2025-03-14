<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventarios";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id_usuario = $_SESSION['id_usuario'];
$sql = "SELECT tipo_documento, documento, nombre, apellido, fecha_nacimiento, genero, email FROM usuario WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

$perfil = $result->fetch_assoc();

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($perfil);
?>
