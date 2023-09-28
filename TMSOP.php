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
            $material = substr($materialStrg, 0, 8);
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
        $motivo = $_POST['motivo'];
        $deposito = "IA08";
        
        $sqlInserirDestino = "INSERT INTO \"$tabelaDestino\" (MATERIAL, TIPO, QUANTIDADE, DATA, MOTIVO, USUARIO, DEPOSITO) VALUES ('$material', '$tipo', '$quantidade', '$data', '$motivo', '$nomeUsuario', '$deposito')";
        $resultInserirDestino = $db->exec($sqlInserirDestino);

        if ($resultInserirDestino !== false) {
            $centro = "SAÍDA";
            $centro1 = $_POST['tabela_destino' ];
            $deposito = "IA08";
            $local = $_POST['local'];
            $sqlInserirHistorico = "INSERT INTO HISTORICO (OPERACAO, DEPOSITO, MATERIAL, TIPO, QUANTIDADE, DATA, LOCAL, USUARIO, MOTIVO) VALUES ('$centro $centro1', '$deposito', '$material', '$tipo', '$quantidade', '$data', '$local', '$nomeUsuario', '$motivo')";
            $resultInserirHistorico = $db->exec($sqlInserirHistorico);

            if ($resultInserirHistorico !== false) {
                echo "Transferência realizada com sucesso!";
                header("Location: OpValidadaSO.php");
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
                "DATA",
                "DATA1",
                "NAO_ENCONTRADO",
                "DIAGRAMA",
                "E1(04010390)",
                "E10(04010399)",
                "E2(04010253)",
                "E3((04010391)",
                "E4(04010394)",
                "E5(04010392)",
                "E6(04010393)",
                "E7(04010395)",
                "E8(04010396)",
                "E9(04010397)",
                "EMPRESTIMO",
                "ES(04011080)",
                "G1(04010251)",
                "G3(04010252)",
                "G4(04010375)",
                "HISTORICO",
                "JUNJO",
                "K1(04010380)",
                "K11(04010514)",
                "K2(04010383)",
                "K3(04010385)",
                "K5(04010370)",
                "K7 511(04010511)",
                "K7_512(04010512)",
                "K9(04010510)",
                "KS(04011000)",
                "L1(04011005)",
                "L2(04011010)",
                "L3(04011015)",
                "L4(04011020)",
                "L5(04011025)",
                "L7(04011030)",
                "LIM(04010330)",
                "LIM1(04010255)",
                "LIM2(04010236)",
                "LIM3(04010237)",
                "M1(04010376)",
                "M13(04010100)",
                "M13(04010106)",
                "M13(04011101)",
                "M2(04010379)",
                "M3(04010377)",
                "M4(04010378)",
                "M54(04010230)",
                "M59 CHINA(04010273)",
                "M59 EMB KITS(04010275)",
                "M59 KIT(04010274)",
                "MAQ(04010268)",
                "MS1(04010429)",
                "P1(04010421)",
                "P2(04010426)",
                "P3(04010422)",
                "P5(04010423)",
                "P7(04010424)",
                "PONTES(04010473)",
                "PRENSA(04011231)",
                "PS6(04010470)",
                "PS7(04010471)",
                "QC",
                "R1(04010746)",
                "R2(04010748)",
                "REPROCESSO",
                "RESERVA",
                "RS12(04010001)",
                "SG(04010850)",
                "SU(04010870)",
                "V1(04010262)"
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
