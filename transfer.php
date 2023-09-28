<?php
session_start();

function redirecionarPara($pagina) {
    header("Location: $pagina");
    exit;
}

function transferirMateriais($tabelaDestino) {
    $materialStrg = isset($_POST['material']) ? $_POST['material'] : '';
    $local = isset($_POST['local']) ? $_POST['local'] : '';
    $quantidade = isset($_POST['quantidade']) ? $_POST['quantidade'] : '';

    if ($_SESSION['nivel'] >= 4) {
        $material = substr($materialStrg, 2, 8);

        date_default_timezone_set('America/Sao_Paulo');
        $data = date('d/m/Y - H:i:s');

        $db = new SQLite3('IA08.db');

        $queryTotal = "SELECT SUM(QUANTIDADE) AS TOTAL FROM DATA1 WHERE MATERIAL = '$material' AND LOCAL = '$local'";
        $resultTotal = $db->querySingle($queryTotal);

        if ($resultTotal !== false) {
            $totalMaterialNoLocal = $resultTotal;
        } else {
            echo "Erro ao calcular valor total do MATERIAL no LOCAL: " . $db->lastErrorMsg();
            return;
        }

        if ($totalMaterialNoLocal < $quantidade) {
            echo "Quantidade insuficiente para transferência.";
            return;
        }

        $novaQuantidade = $totalMaterialNoLocal - $quantidade;
        $sqlAtualizarQuantidade = "UPDATE DATA1 SET QUANTIDADE = $novaQuantidade WHERE MATERIAL = '$material' AND LOCAL = '$local'";
        $resultAtualizarQuantidade = $db->exec($sqlAtualizarQuantidade);

        if ($resultAtualizarQuantidade === false) {
            echo "Erro ao atualizar quantidades na tabela de origem: " . $db->lastErrorMsg();
            return;
        }

        $queryTipo = "SELECT TIPO FROM DATA1 WHERE MATERIAL = '$material' AND LOCAL = '$local'";
        $resultTipo = $db->querySingle($queryTipo);

        if ($resultTipo !== false) {
            $tipo = $resultTipo;
        } else {
            echo "Erro ao obter valor da coluna TIPO: " . $db->lastErrorMsg();
            return;
        }

        $nomeUsuario = $_SESSION['usuario'];
        $sqlInserirDestino = "INSERT INTO \"$tabelaDestino\" (MATERIAL, TIPO, QUANTIDADE, DATA, NOME) VALUES ('$material', '$tipo', '$quantidade', '$data', '$nomeUsuario')";
        $resultInserirDestino = $db->exec($sqlInserirDestino);

        if ($resultInserirDestino !== false) {
            echo "Transferência realizada com sucesso!";
            header("Location: OpValidadaSO.php");
            exit;
        } else {
            echo "Erro ao transferir: " . $db->lastErrorMsg();
        }

        $db->close();
    } else {
        redirecionarPara("403.php");
    }
}

function verificarAcesso() {
    if (!isset($_SESSION['usuario']) || !isset($_SESSION['nivel']) || $_SESSION['nivel'] < 4) {
        redirecionarPara("403.php");
    }
}

function main() {
    verificarAcesso();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $tabelaDestino = isset($_POST['tabela_destino']) ? $_POST['tabela_destino'] : '';
        if (!empty($tabelaDestino)) {
            transferirMateriais($tabelaDestino);
        } else {
            echo "Especifique a tabela de destino.";
        }
    } else {
        echo "Este script deve ser acessado via método POST.";
    }
}

main();
?>
