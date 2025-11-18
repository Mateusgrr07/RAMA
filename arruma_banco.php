<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rama_db";

// Conexão
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("❌ Conexão falhou: " . $conn->connect_error); }

echo "<h2>🔧 Iniciando Protocolo de Força Bruta...</h2>";

// 1. DESLIGA A SEGURANÇA (O Pulo do Gato)
$conn->query("SET FOREIGN_KEY_CHECKS = 0");
echo "🔓 Travas de segurança (Foreign Keys) DESLIGADAS.<br>";

// 2. Tenta apagar a tabela 'maquinas' na força
$sql_drop = "DROP TABLE IF EXISTS maquinas";
if ($conn->query($sql_drop) === TRUE) {
    echo "🗑️ Tabela 'maquinas' apagada (agora é pra valer).<br>";
} else {
    echo "⚠️ Erro ao apagar: " . $conn->error . "<br>";
}

// 3. Cria a tabela DO ZERO
$sql_create = "CREATE TABLE maquinas (
  id int(11) NOT NULL AUTO_INCREMENT,
  codigo varchar(50) NOT NULL,
  modelo varchar(100) NOT NULL,
  tipo varchar(100) DEFAULT NULL,
  ano varchar(4) DEFAULT NULL,
  id_usuario_cadastro int(11) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY codigo (codigo),
  KEY id_usuario_cadastro (id_usuario_cadastro)
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

if ($conn->query($sql_create) === TRUE) {
    echo "✅ Tabela 'maquinas' RECRIADA com sucesso!<br>";
} else {
    // Se der erro aqui de novo, é problema de arquivo no Windows (XAMPP)
    die("❌ O banco ainda acha que a tabela existe. Erro: " . $conn->error);
}

// 4. Reconecta a chave estrangeira
$sql_alter = "ALTER TABLE maquinas
  ADD CONSTRAINT fk_maquina_usuario FOREIGN KEY (id_usuario_cadastro) REFERENCES usuarios (id)";

if ($conn->query($sql_alter) === TRUE) {
    echo "✅ Ligação com usuários refeita!<br>";
} else {
    echo "⚠️ Erro na chave estrangeira: " . $conn->error . "<br>";
}

// 5. LIGA A SEGURANÇA DE VOLTA
$conn->query("SET FOREIGN_KEY_CHECKS = 1");
echo "🔒 Travas de segurança RELIGADAS.<br>";

echo "<h3>🎉 Agora vai! Volte no painel e tente cadastrar.</h3>";

$conn->close();
?>