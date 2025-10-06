<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rama";

// Criar conexão 
$conn = new mysqli($servername, $username, $password, $dbname);

// Checar conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Pegar dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$cargo = $_POST['cargo'];
$senha = $_POST['senha'];

// Criptografar senha 
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

// Inserir no banco 
$sql = "INSERT INTO usuarios (nome, email, cargo, senha) 
        VALUES ('$nome', '$email', '$cargo', '$senhaHash')";

if ($conn->query($sql) === TRUE) {
    echo "Usuário cadastrado com sucesso!";
} else {
    echo "Erro: " . $conn->error;
}

$conn->close();
?>