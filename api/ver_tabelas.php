<?php
include 'db.php';

$sql = "SHOW TABLES";
$result = $conn->query($sql);

echo "<h2>Tabelas encontradas no banco 'rama_db':</h2>";

if ($result->num_rows > 0) {
    echo "<ul>";
    while($row = $result->fetch_array()) {
        // O nome exato da tabela está aqui
        echo "<li><strong>" . $row[0] . "</strong></li>";
    }
    echo "</ul>";
} else {
    echo "Nenhuma tabela encontrada!";
}
?>