<?php
session_start();
include 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Usuario nao autenticado']);
    exit();
}

$codigo = $_POST['codigo'];
$modelo = $_POST['modelo'];
$tipo = $_POST['tipo'];
$ano = $_POST['ano'];
$id_usuario = $_SESSION['id'];

if (empty($codigo) || empty($modelo)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Codigo e Modelo sao obrigatorios']);
    exit();
}

$stmt = $conn->prepare("INSERT INTO maquinas (codigo, modelo, tipo, ano, id_usuario_cadastro) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssi", $codigo, $modelo, $tipo, $ano, $id_usuario);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'id' => $stmt->insert_id]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>