<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ordem = $_POST["ordem"];
    $localS = $_POST["localS"];
    $localE = $_POST["localE"];
    $nomeUsuario = $_SESSION['usuario'];

    $dbPath = 'OP.db';
    $conn = new SQLite3($dbPath);

    if (!$conn) {
        die("Conexão falhou: " . $conn->lastErrorMsg());
    }

    $stmt = $conn->prepare("SELECT ORDEM, LINHA FROM $localS WHERE ORDEM = :ordem");
    $stmt->bindValue(':ordem', $ordem, SQLITE3_TEXT);
    $result = $stmt->execute();

    $row = $result->fetchArray(SQLITE3_ASSOC);

    if ($row) {
        $linha = $row['LINHA'];
        date_default_timezone_set('America/Sao_Paulo');
        $dataHora = date('d/m/Y - H:i:s');
        
        $stmt = $conn->prepare("INSERT INTO $localE (ORDEM, LINHA, NOME, DATA) VALUES (:ordem, :linha, :nomeUsuario, :dataHora)");
        $stmt->bindValue(':ordem', $ordem, SQLITE3_TEXT);
        $stmt->bindValue(':linha', $linha, SQLITE3_TEXT);
        $stmt->bindValue(':nomeUsuario', $nomeUsuario, SQLITE3_TEXT);
        $stmt->bindValue(':dataHora', $dataHora, SQLITE3_TEXT);

        if ($stmt->execute()) {
            $stmt = $conn->prepare("DELETE FROM $localS WHERE ORDEM = :ordem");
            $stmt->bindValue(':ordem', $ordem, SQLITE3_TEXT);

            if ($stmt->execute()) {
                header("Location: MTOPV.php");
                exit;
            } else {
                echo "Erro ao excluir a ordem da tabela de origem: " . $conn->lastErrorMsg();
            }
        } else {
            echo "Erro ao inserir a ordem, a linha, o nome de usuário e a data na tabela de destino: " . $conn->lastErrorMsg();
        }
    } else {
        echo "Ordem não encontrada na tabela de origem.";
    }

    $stmt->close();
    $conn->close();
}
?>
