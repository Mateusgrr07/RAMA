<?php
session_start();
include 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Usuario nao autenticado']);
    exit();
}

$result = $conn->query("SELECT * FROM maquinas ORDER BY id DESC");

$maquinas = [];
while ($row = $result->fetch_assoc()) {
    $maquinas[] = $row;
}

echo json_encode($maquinas);

$conn->close();
?>