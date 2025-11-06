<?php
session_start();
include 'db.php'; // Inclui a conexão

header('Content-Type: application/json');

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Usuario nao autenticado']);
    exit();
}

// Pega os dados do POST
$placa = $_POST['placa'];
$modelo = $_POST['modelo'];
$familia = $_POST['familia'];
$ano = $_POST['ano'];
$id_usuario = $_SESSION['id']; // Pega o ID do usuário logado (o Gerente)

// Validação simples
if (empty($placa) || empty($modelo)) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'error' => 'Placa e Modelo sao obrigatorios']);
    exit();
}

$stmt = $conn->prepare("INSERT INTO caminhoes (placa, modelo, familia, ano, id_usuario_cadastro) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssi", $placa, $modelo, $familia, $ano, $id_usuario);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'id' => $stmt->insert_id]);
} else {
    http_response_code(500); // Erro de servidor
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>