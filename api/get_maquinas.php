<?php
// 1. Desativa mensagens de erro feias (HTML) que quebram o sistema
error_reporting(0);

session_start();
header('Content-Type: application/json');

// 2. Verifica Login
if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'error' => 'Usuario nao autenticado']);
    exit();
}

// 3. Conexão Manual e Segura (Evita problemas com o arquivo db.php)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rama_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Erro de Conexão com o Banco: ' . $conn->connect_error]);
    exit();
}

// 4. Faz a busca com verificação de erro
$sql = "SELECT * FROM maquinas ORDER BY id DESC";
$result = $conn->query($sql);

// Se a busca der errado (ex: nome da tabela errado), avisa o motivo
if (!$result) {
    echo json_encode(['success' => false, 'error' => 'Erro no SQL: ' . $conn->error]);
    exit();
}

$maquinas = [];
while ($row = $result->fetch_assoc()) {
    $maquinas[] = $row;
}

// 5. Envia os dados
echo json_encode($maquinas);
$conn->close();
?>