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
$senha_postada = $_POST['senha'];

// Usando Prepared Statements
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();

    // Verificar a senha
    if (password_verify($senha_postada, $usuario['senha'])) {
        // Senha correta, iniciar sessão
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['cargo'] = $usuario['cargo'];
        $_SESSION['setor'] = $usuario['setor'];

        // Redirecionamento baseado no cargo e setor
        if ($usuario['cargo'] == 'Gerente' && $usuario['setor'] == 'Maquinas') {
            header("Location: Gmaq.html");
        } elseif ($usuario['cargo'] == 'Gerente' && $usuario['setor'] == 'Caminhoes') {
            header("Location: Gcami.html");
        } elseif ($usuario['cargo'] == 'Funcionario' && $usuario['setor'] == 'Maquinas') {
            header("Location: Fmaq.html");
        } elseif ($usuario['cargo'] == 'Funcionario' && $usuario['setor'] == 'Caminhoes') {
            header("Location: Fcami.html");
        } else {
            // Caso padrão (ex: Gerente sem setor definido)
            header("Location: Gmaq.html"); // Ou uma página de "painel geral"
        }
        exit();
    } else {
        // Senha incorreta
        echo "Email ou senha inválidos.";
        // Você pode redirecionar de volta para o login com uma mensagem de erro
        // header("Location: Login.html?erro=1");
    }
} else {
    // Usuário não encontrado
    echo "Email ou senha inválidos.";
    // header("Location: Login.html?erro=1");
}

$stmt->close();
$conn->close();
?>