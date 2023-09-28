<?php
session_start();

function redirecionarPara($pagina) {
    header("Location: $pagina");
    exit;
}

function extractMaterial($input) {
    $pos240 = strpos($input, '240');

    if ($pos240 !== false && strlen($input) >= $pos240 + 11) {
        return substr($input, $pos240 + 3, 8);
    } else {
        return substr($input, 0, 8);
    }
}

function inserirMaterialHistorico($db, $material, $tipo, $deposito, $local, $quantidade, $nomeUsuario) {
    date_default_timezone_set('America/Sao_Paulo');
    $data = date('d/m/Y - H:i:s');
    $centro = "CONSULTA"; 

    $queryInserirHistorico = $db->prepare("INSERT INTO HISTORICO (OPERACAO, MATERIAL, TIPO, DEPOSITO, LOCAL, DATA, QUANTIDADE, USUARIO) VALUES (:centro, :material, :tipo, :deposito, :local, :data, :quantidade, :nomeUsuario)");
    
    $queryInserirHistorico->bindValue(':centro', $centro, SQLITE3_TEXT);
    $queryInserirHistorico->bindValue(':material', $material, SQLITE3_TEXT);
    $queryInserirHistorico->bindValue(':tipo', $tipo, SQLITE3_TEXT);
    $queryInserirHistorico->bindValue(':deposito', $deposito, SQLITE3_TEXT);
    $queryInserirHistorico->bindValue(':local', $local, SQLITE3_TEXT);
    $queryInserirHistorico->bindValue(':data', $data, SQLITE3_TEXT);
    $queryInserirHistorico->bindValue(':quantidade', $quantidade, SQLITE3_TEXT);
    $queryInserirHistorico->bindValue(':nomeUsuario', $nomeUsuario, SQLITE3_TEXT);

    $resultInserirHistorico = $queryInserirHistorico->execute();

    if ($resultInserirHistorico === false) {
        echo "Erro ao inserir material na tabela HISTORICO: " . $db->lastErrorMsg();
    }
}

if (isset($_SESSION['usuario'])) {
    $nomeUsuario = $_SESSION['usuario'];
} else {
    redirecionarPara("index.php");
}

$nomeUsuario = $_SESSION['usuario'];
$input = $_POST['material'];
$material = extractMaterial($input);

$conn = new SQLite3('IA08.db');

if (preg_match('/^\d{2}\.\d{2}\.\d{2}$/', $input)) {
    $local = $input;

    $query = "SELECT MATERIAL, TIPO, DEPOSITO, LOCAL, SUM(QUANTIDADE) AS TOTAL_QUANTIDADE FROM DATA1 WHERE LOCAL = :local GROUP BY MATERIAL, TIPO, DEPOSITO, LOCAL";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':local', $local, SQLITE3_TEXT);
    $result = $stmt->execute();

    $resultados = array();

    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $resultados[] = $row;
    }

    $_SESSION['resultados_consulta'] = $resultados;

    foreach ($resultados as $resultado) {
        inserirMaterialHistorico($conn, $resultado['MATERIAL'], $resultado['TIPO'], $resultado['DEPOSITO'], $resultado['LOCAL'], $resultado['TOTAL_QUANTIDADE'], $nomeUsuario);
    }

    $conn->close();

    redirecionarPara("resultado.php");
} else {
    $deleteQuery = "DELETE FROM DATA1 WHERE QUANTIDADE = 0";
    $conn->exec($deleteQuery);

    $query = "SELECT MATERIAL, TIPO, DEPOSITO, LOCAL, SUM(QUANTIDADE) AS TOTAL_QUANTIDADE FROM DATA1 WHERE MATERIAL = :material GROUP BY MATERIAL, TIPO, DEPOSITO, LOCAL";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':material', $material, SQLITE3_TEXT);
    $result = $stmt->execute();

    $resultados = array();

    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $resultados[] = $row;
    }

    $_SESSION['resultados_consulta'] = $resultados;

    foreach ($resultados as $resultado) {
        inserirMaterialHistorico($conn, $resultado['MATERIAL'], $resultado['TIPO'], $resultado['DEPOSITO'], $resultado['LOCAL'], $resultado['TOTAL_QUANTIDADE'], $nomeUsuario);
    }

    $conn->close();

    redirecionarPara("resultado.php");
}
?>
