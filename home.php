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

$sql = "INSERT INTO usuarios (nome, email, cargo, setor, senha)
        VALUES ('$nome', '$email', '$cargo', '$setor', '$senha')";

if ($conn->query($sql) === TRUE) {
    header("Location: Login.html"); // redireciona direto pro login
    exit();
} else {
    echo "Erro: " . $conn->error;
}

$conn->close();
