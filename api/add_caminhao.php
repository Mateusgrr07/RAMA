<?php
session_start();
include 'db.php'; 
header('Content-Type: application/json');

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Usuario nao autenticado']);
    exit();
}

$placa = $_POST['placa'];
$modelo = $_POST['modelo'];
$familia = $_POST['familia'];
$ano = $_POST['ano'];
$id_usuario = $_SESSION['id'];

// Validação simples
if (empty($placa) || empty($modelo)) {
    // Nota: removi o http_response_code 400 para facilitar o tratamento no frontend, 
    // mas se preferir pode manter. O importante é o JSON.
    echo json_encode(['success' => false, 'error' => 'Placa e Modelo sao obrigatorios']);
    exit();
}

// --- NOVA PARTE: VERIFICA SE A PLACA JÁ EXISTE ---
$checkStmt = $conn->prepare("SELECT id FROM caminhoes WHERE placa = ?");
$checkStmt->bind_param("s", $placa);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    // Retornamos o erro específico 'duplicate_code'
    echo json_encode([
        'success' => false, 
        'error' => 'duplicate_code', 
        'message' => 'Placa de caminhão já existe'
    ]);
    exit();
}
$checkStmt->close();
// --------------------------------------------------

$stmt = $conn->prepare("INSERT INTO caminhoes (placa, modelo, familia, ano, id_usuario_cadastro) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssi", $placa, $modelo, $familia, $ano, $id_usuario);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'id' => $stmt->insert_id]);
} else {
    // Se der erro de SQL
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>