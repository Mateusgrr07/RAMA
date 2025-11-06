<?php
session_start();

// Define o cabeçalho como JSON
header('Content-Type: application/json');

if (isset($_SESSION['id'])) {
    // Usuário está logado, envia os dados
    echo json_encode([
        'success' => true,
        'id' => $_SESSION['id'],
        'nome' => $_SESSION['nome'],
        'cargo' => $_SESSION['cargo'],
        'setor' => $_SESSION['setor']
    ]);
} else {
    // Usuário não está logado
    http_response_code(401); // Código "Unauthorized"
    echo json_encode([
        'success' => false,
        'error' => 'Usuario nao autenticado'
    ]);
}
?>