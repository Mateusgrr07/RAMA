<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rama_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM usuarios WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();

    if (password_verify($senha, $usuario['senha'])) {
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['cargo'] = $usuario['cargo'];
        $_SESSION['setor'] = $usuario['setor'];

        if ($usuario['cargo'] == 'Gerente' && $usuario['setor'] == 'Maquinas') {
            header("Location: Gmaq.html");
        } elseif ($usuario['cargo'] == 'Gerente' && $usuario['setor'] == 'Caminhoes') {
            header("Location: Gcami.html");
        } elseif ($usuario['cargo'] == 'Funcionario' && $usuario['setor'] == 'Maquinas') {
            header("Location: Fmaq.html");
        } elseif ($usuario['cargo'] == 'Funcionario' && $usuario['setor'] == 'Caminhoes') {
            header("Location: Fcami.html");
        }

        exit();
    } else {
        echo "Senha incorreta!";
    }
} else {
    echo "Usuário não encontrado!";
}

$conn->close();
