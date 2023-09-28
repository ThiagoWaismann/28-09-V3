<?php
session_start();

function escreverLog($mensagem) {
    $arquivoLog = 'log.txt';
    date_default_timezone_set('America/Sao_Paulo');
    $data = date('d/m/Y - H:i:s');
    // Abra o arquivo de log e escreva a mensagem, data e hora
    file_put_contents($arquivoLog, "$data: $mensagem\n", FILE_APPEND);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $senha = $_POST["senha"];
    $nomeUsuario = $_SESSION['usuario'];
    $dbPath = 'usuarios.db';
    $conn = new SQLite3($dbPath);

    if (!$conn) {
        die("Conexão falhou: " . $conn->lastErrorMsg());
    }

    $stmt = $conn->prepare("SELECT ID, NOME, SENHA, MATRICULA, NIVEL FROM CADASTROS WHERE SENHA = :senha");
    $stmt->bindValue(':senha', $senha, SQLITE3_TEXT);
    $result = $stmt->execute();
    escreverLog("Usuário $nomeUsuario fez login com sucesso.");

    $userRow = $result->fetchArray(SQLITE3_ASSOC);

    if ($userRow) {
        $_SESSION['usuario'] = $userRow['NOME'];
        $_SESSION['nivel'] = $userRow['NIVEL']; 

        switch ($_SESSION['nivel']) {
            case -10:
                header("Location: CIIL.php");
                break;
            case -1:
                header("Location: IML.php");
                ;
                break;
            default:
                header("Location: inicial.php");
                break;
        }

        exit;
    } else {
        header("Location: 401.php");
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>
