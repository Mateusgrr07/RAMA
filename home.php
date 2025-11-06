<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rama_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$nome = $_POST['nome'];
$email = $_POST['email'];
$cargo = $_POST['cargo'];
$setor = isset($_POST['setor']) ? $_POST['setor'] : "";
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

// Usando Prepared Statements para evitar SQL Injection
$stmt = $conn->prepare("INSERT INTO usuarios (nome, email, cargo, setor, senha) VALUES (?, ?, ?, ?, ?)");
// sss = string, string, string
$stmt->bind_param("sssss", $nome, $email, $cargo, $setor, $senha);

if ($stmt->execute()) {
    header("Location: Login.html"); // redireciona direto pro login
    exit();
} else {
    echo "Erro: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>