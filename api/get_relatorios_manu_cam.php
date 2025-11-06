<?php
session_start();
include 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Usuario nao autenticado']);
    exit();
}

// SQL que busca os relatórios e "junta" com a tabela usuarios para pegar o nome
$sql = "SELECT r.*, u.nome AS nome_usuario 
        FROM relatorios_manutencao_cam r 
        JOIN usuarios u ON r.id_usuario = u.id 
        ORDER BY r.id DESC";

$result = $conn->query($sql);

$relatorios = [];
while ($row = $result->fetch_assoc()) {
    $relatorios[] = $row;
}

echo json_encode($relatorios); // Envia a lista como JSON

$conn->close();
?>