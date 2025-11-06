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
// O campo 'nome' do formulário será ignorado, vamos usar o ID da sessão
$codigo_maquina = $_POST['codigo'];
$data_operacao = $_POST['data'];
$tempo_uso = $_POST['tempo'];
$observacoes = $_POST['observacoes'];
$id_usuario = $_SESSION['id']; // Pega o ID do usuário logado (o Funcionário)

// Validação simples
if (empty($codigo_maquina) || empty($data_operacao)) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'error' => 'Codigo da maquina e Data sao obrigatorios']);
    exit();
}

$stmt = $conn->prepare("INSERT INTO relatorios_operacionais_maq (id_usuario, codigo_maquina, data_operacao, tempo_uso, observacoes) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issss", $id_usuario, $codigo_maquina, $data_operacao, $tempo_uso, $observacoes);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'id' => $stmt->insert_id]);
} else {
    http_response_code(500); // Erro de servidor
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>