<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ordem = $_POST["ordem"];
    $linha = $_POST["linha"];
    $nomeUsuario = $_SESSION['usuario'];
    
    date_default_timezone_set('America/Sao_Paulo');
    $dataHora = date('d/m/Y - H:i:s');
    $dbPath = 'OP.db';
    $conn = new SQLite3($dbPath);
    
    if (!$conn) {
        die("Conexão falhou: " . $conn->lastErrorMsg());
    }
    
    $stmt = $conn->prepare("INSERT INTO LIBERACAO (ORDEM, LINHA, DATA, NOME) VALUES (:ordem, :linha, :dataHora, :nomeUsuario)");
    $stmt->bindValue(':ordem', $ordem, SQLITE3_TEXT);
    $stmt->bindValue(':linha', $linha, SQLITE3_TEXT);
    $stmt->bindValue(':dataHora', $dataHora, SQLITE3_TEXT);
    $stmt->bindValue(':nomeUsuario', $nomeUsuario, SQLITE3_TEXT);
    
    if ($stmt->execute()) {
        header("Location: CILOPV.php");
        exit;
    } else {
        echo "Erro ao inserir os dados: " . $conn->lastErrorMsg();
    }
    
    $stmt->close();
    $conn->close();
}
?>