<?php
session_start();
include 'db.php'; // Inclui a conexão

header('Content-Type: application/json');

// Verifica se o usuário (Funcionário) está logado
if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Usuario nao autenticado']);
    exit();
}

// Pega os dados do POST
// O 'name' do campo no seu HTML é 'placa'
$placa_caminhao = $_POST['placa']; 
$data_manutencao = $_POST['data'];
$observacoes = $_POST['observacoes'];
$id_usuario = $_SESSION['id']; // Pega o ID do usuário logado (o Funcionário)

// Validação simples
if (empty($placa_caminhao) || empty($data_manutencao)) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'error' => 'Placa do caminhao e Data sao obrigatorios']);
    exit();
}

$stmt = $conn->prepare("INSERT INTO relatorios_manutencao_cam (id_usuario, placa_caminhao, data_manutencao, observacoes) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $id_usuario, $placa_caminhao, $data_manutencao, $observacoes);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'id' => $stmt->insert_id]);
} else {
    http_response_code(500); // Erro de servidor
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>