<?php
session_start();

function redirecionarPara($pagina) {
    header("Location: $pagina");
    exit;
}

function inserirMaterialHistorico($db, $material, $tipo, $local, $quantidade, $nomeUsuario, $deposito) {
    date_default_timezone_set('America/Sao_Paulo');
    $data = date('d/m/Y - H:i:s');

    $operacao = "M-LOCAL";

    $queryInserirHistorico = "INSERT INTO HISTORICO (OPERACAO, MATERIAL, TIPO, DATA, QUANTIDADE, DEPOSITO, LOCAL, USUARIO) VALUES ('$operacao', '$material', '$tipo', '$data', '$quantidade', '$deposito', '$local', '$nomeUsuario')";
    
    $resultInserirHistorico = $db->exec($queryInserirHistorico);

    if ($resultInserirHistorico === false) {
        echo "Erro ao inserir material no histórico: " . $db->lastErrorMsg();
    }
}

function transferirMateriais() {
    $materialStrg = isset($_POST['material']) ? $_POST['material'] : '';
    $localOrigem = isset($_POST['localS']) ? $_POST['localS'] : '';
    $localDestino = isset($_POST['localE']) ? $_POST['localE'] : '';
    $quantidade = isset($_POST['quantidade']) ? $_POST['quantidade'] : '';
    $deposito = isset($_POST['deposito']) ? $_POST['deposito'] : 'IA08';
    $nomeUsuario = $_SESSION['usuario'];

    date_default_timezone_set('America/Sao_Paulo');
    $data = date('d/m/Y - H:i:s');

    $centro = "M-LOCAL";

    if ($_SESSION['nivel'] < 4) {
        redirecionarPara("403.php");
    }

    $material = substr($materialStrg, strpos($materialStrg, '240') + 3, 8);
    $db = new SQLite3('IA08.db');

    $queryExistencia = "SELECT QUANTIDADE, TIPO FROM DATA1 WHERE MATERIAL = '$material' AND LOCAL = '$localOrigem'";
    $resultExistencia = $db->querySingle($queryExistencia, true);

    if ($resultExistencia === false) {
        echo "Material não encontrado no local de origem.";
        $db->close();
        return;
    }

    $quantidadeOrigem = $resultExistencia['QUANTIDADE'];
    $tipo = $resultExistencia['TIPO'];

    if ($quantidade > $quantidadeOrigem) {
        echo "Quantidade insuficiente para transferência.";
        $db->close();
        return;
    }

    $novaQuantidadeOrigem = $quantidadeOrigem - $quantidade;

    $sqlAtualizarQuantidadeOrigem = "UPDATE DATA1 SET QUANTIDADE = $novaQuantidadeOrigem WHERE MATERIAL = '$material' AND LOCAL = '$localOrigem'";
    $resultAtualizarQuantidadeOrigem = $db->exec($sqlAtualizarQuantidadeOrigem);

    if ($resultAtualizarQuantidadeOrigem === false) {
        echo "Erro ao atualizar a quantidade no local de origem: " . $db->lastErrorMsg();
        $db->close();
        return;
    }

    $queryExistenciaDestino = "SELECT QUANTIDADE, TIPO FROM DATA1 WHERE MATERIAL = '$material' AND LOCAL = '$localDestino'";
    $resultExistenciaDestino = $db->querySingle($queryExistenciaDestino, true);

    switch ($resultExistenciaDestino) {
        case false:

            $sqlNovaEntradaDestino = "INSERT INTO DATA1 (MATERIAL, TIPO, LOCAL, QUANTIDADE, DEPOSITO) VALUES ('$material', '$tipo', '$localDestino', '$quantidade', '$deposito')";
            $resultNovaEntradaDestino = $db->exec($sqlNovaEntradaDestino);

            if ($resultNovaEntradaDestino === false) {
                echo "Erro ao criar nova entrada no local de destino: " . $db->lastErrorMsg();
                $db->close();
                return;
            }

            break;

        default:
            $novaQuantidadeDestino = $resultExistenciaDestino['QUANTIDADE'] + $quantidade;

            $sqlAtualizarQuantidadeDestino = "UPDATE DATA1 SET QUANTIDADE = $novaQuantidadeDestino WHERE MATERIAL = '$material' AND LOCAL = '$localDestino'";
            $resultAtualizarQuantidadeDestino = $db->exec($sqlAtualizarQuantidadeDestino);

            if ($resultAtualizarQuantidadeDestino === false) {
                echo "Erro ao atualizar a quantidade no local de destino: " . $db->lastErrorMsg();
                $db->close();
                return;
            }

            break;
    }

    if ($novaQuantidadeOrigem <= 0) {

        $sqlRemoverOrigem = "DELETE FROM DATA1 WHERE MATERIAL = '$material' AND LOCAL = '$localOrigem'";
        $resultRemoverOrigem = $db->exec($sqlRemoverOrigem);

        if ($resultRemoverOrigem === false) {
            echo "Erro ao remover a linha do local de origem: " . $db->lastErrorMsg();
            $db->close();
            return;
        }
    }

    echo "Transferência realizada com sucesso!";
    inserirMaterialHistorico($db, $material, $tipo, $localOrigem, -$quantidade, $nomeUsuario, $deposito);
    inserirMaterialHistorico($db, $material, $tipo, $localDestino, $quantidade, $nomeUsuario, $deposito);
    header("Location: TMSOVLD.php");
    $db->close();
}

function main() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        transferirMateriais();
    } else {
        echo "Este script deve ser acessado via método POST.";
    }
}

main();
?>
