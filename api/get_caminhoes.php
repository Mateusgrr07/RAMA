<?php
session_start();
include 'db.php';

header('Content-Type: application/json');

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Usuario nao autenticado']);
    exit();
}

// CORRIGIDO: Removemos o ']' que estava antes do SELECT
$sql = "SELECT * FROM caminhoes ORDER BY id DESC";
$result = $conn->query($sql);

$caminhoes = [];

// Verificamos se $result é válido antes de tentar ler
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $caminhoes[] = $row;
    }
}

echo json_encode($caminhoes); 
$conn->close();
?>