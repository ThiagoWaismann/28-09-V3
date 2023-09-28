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
        $pos240 = strpos($materialStrg, '240');
        if ($pos240 !== false) {
            $material = substr($materialStrg, $pos240 + 3, 8);
        } else {
            echo "ERRO PROCESSAMENTO TMCOP.php";
        }

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
            echo "$material";
            return;
        }

        $novaQuantidade = $totalMaterialNoLocal - $quantidade;
        $sqlAtualizarQuantidade = "UPDATE DATA1 SET QUANTIDADE = $novaQuantidade WHERE MATERIAL = '$material' AND LOCAL = '$local'";
        $resultAtualizarQuantidade = $db->exec($sqlAtualizarQuantidade);

        $queryTotalDataOP = "SELECT QUANTIDADE AS TOTAL FROM DATAOP WHERE MATERIAL = '$material'";
        $resultTotalDataOP = $db->querySingle($queryTotalDataOP);

        if ($resultTotalDataOP !== false) {
            $totalMaterialNoLocalDataOP = $resultTotalDataOP;
        } else {
            echo "Erro ao calcular valor total do MATERIAL na tabela DATAOP: " . $db->lastErrorMsg();
            return;
        }

        $novaQuantidadeDataOP = $totalMaterialNoLocalDataOP - $quantidade;
        $sqlAtualizarQuantidadeDataOP = "UPDATE DATAOP SET QUANTIDADE = $novaQuantidadeDataOP WHERE MATERIAL = '$material'";
        $resultAtualizarQuantidadeDataOP = $db->exec($sqlAtualizarQuantidadeDataOP);

        if ($resultAtualizarQuantidadeDataOP === false) {
            echo "Erro ao atualizar quantidades na tabela DATAOP: " . $db->lastErrorMsg();
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
        $motivo = $_POST['ordem'];
        $motivo1 = "ORDEM";
        $deposito = "IA08";
        
        $sqlInserirDestino = "INSERT INTO \"$tabelaDestino\" (MATERIAL, TIPO, QUANTIDADE, DATA, MOTIVO, USUARIO, DEPOSITO) VALUES ('$material', '$tipo', '$quantidade', '$data', '$motivo', '$nomeUsuario', '$deposito')";
        $resultInserirDestino = $db->exec($sqlInserirDestino);

        if ($resultInserirDestino !== false) {
            $centro = $_POST['tabela_destino'];
            $centro1 = "SAÍDA";
            $deposito = "IA08";
            $local = $_POST['local'];
            $sqlInserirHistorico = "INSERT INTO HISTORICO (OPERACAO, DEPOSITO, MATERIAL, TIPO, QUANTIDADE, DATA, LOCAL, USUARIO, MOTIVO) VALUES ('$centro1 $centro', '$deposito', '$material', '$tipo', '$quantidade', '$data', '$local', '$nomeUsuario', '$motivo1 $motivo')";
            $resultInserirHistorico = $db->exec($sqlInserirHistorico);

            if ($resultInserirHistorico !== false) {
                echo "Transferência realizada com sucesso!";
                header("Location: GetData.php");
                exit;
            } else {
                echo "Erro ao transferir para a tabela HISTORICO: " . $db->lastErrorMsg();
            }
        } else {
            echo "Erro ao transferir para a tabela de destino: " . $db->lastErrorMsg();
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
            $tabelasPermitidas = array(
                "AGRUP(04010282)",
                "ALMOX MEC(04010002)",
                "ASTEC",
                "4010258",
                "4011030",
                "L7",
                "4010428",
                "DATA",
                "DATA1",
                "DIAGRAMA",
                "E1",
                "E10",
                "E2",
                "E3",
                "E4",
                "E5",
                "E6",
                "E7",
                "E8",
                "E9",
                "EMPRESTIMO",
                "ES",
                "G1",
                "G3",
                "G4",
                "HISTORICO",
                "JUNJO",
                "K1",
                "K11",
                "K2",
                "K3",
                "K5",
                "KS",
                "L1",
                "L2",
                "L3",
                "L4",
                "L5",
                "L7",
                "LIM",
                "LIM1",
                "LIM2",
                "LIM3",
                "M1",
                "M13",
                "M13(04010106)",
                "M13(04011101)",
                "M2",
                "M3",
                "M4",
                "M54",
                "M59",
                "MAQ",
                "MS1",
                "P1",
                "P2",
                "P3",
                "P5",
                "P7",
                "PONTES(04010473)",
                "PRENSA(04011231)",
                "PS6(04010470)",
                "PS7(04010471)",
                "QC",
                "R1",
                "R2",
                "REPROCESSO",
                "RESERVA",
                "RS12",
                "SG",
                "SU",
                "V1"
            );

            if (in_array($tabelaDestino, $tabelasPermitidas)) {
                transferirMateriais($tabelaDestino);
            } else {
                echo "Tabela de destino não é válida.";
            }
        } else {
            echo "Especifique a tabela de destino.";
        }
    } else {
        echo "Este script deve ser acessado via método POST.";
    }
}

main();
?>
