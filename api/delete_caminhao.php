<?php
session_start();
include 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Usuario nao autenticado']);
    exit();
}

// Pega o ID para deletar.
// Usamos file_get_contents para ler o JSON enviado pelo 'fetch' no modo DELETE
$data = json_decode(file_get_contents("php://input"), true);
$id_para_deletar = $data['id'];

if (empty($id_para_deletar)) {
     http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'ID nao fornecido']);
    exit();
}

$stmt = $conn->prepare("DELETE FROM caminhoes WHERE id = ?");
$stmt->bind_param("i", $id_para_deletar);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>