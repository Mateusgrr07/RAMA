<?php
session_start();
include 'db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Não logado']);
    exit();
}

$codigo = $_POST['codigo'];
$modelo = $_POST['modelo'];
$tipo = $_POST['tipo'];
$ano = $_POST['ano'];
$id_usuario = $_SESSION['id'];

if (empty($codigo) || empty($modelo)) {
    echo json_encode(['success' => false, 'error' => 'Preencha todos os campos']);
    exit();
}

$stmt = $conn->prepare("INSERT INTO maquinas (codigo, modelo, tipo, ano, id_usuario_cadastro) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssi", $codigo, $modelo, $tipo, $ano, $id_usuario);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'id' => $stmt->insert_id]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}
$conn->close();
?>