<?php
session_start();
include 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Usuario nao autenticado']);
    exit();
}

$result = $conn->query("]SELECT * FROM caminhoes ORDER BY id DESC");

$caminhoes = [];
while ($row = $result->fetch_assoc()) {
    $caminhoes[] = $row;
}

echo json_encode($caminhoes); // Envia a lista como JSON

$conn->close();
?>