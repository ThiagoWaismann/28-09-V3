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

function inserirMaterialHistorico($db, $material, $tipo, $local, $quantidade, $nomeUsuario, $deposito) {
    date_default_timezone_set('America/Sao_Paulo');
    $data = date('d/m/Y - H:i:s');
    $centro = "ENTRADA";

    $queryInserirHistorico = "INSERT INTO HISTORICO (OPERACAO, MATERIAL, TIPO, LOCAL, QUANTIDADE, DATA, USUARIO, DEPOSITO) VALUES ('$centro', '$material', '$tipo', '$local', '$quantidade', '$data', '$nomeUsuario', '$deposito')";
    
    $resultInserirHistorico = $db->exec($queryInserirHistorico);

    if ($resultInserirHistorico === false) {
        echo "Erro ao inserir material no histórico: " . $db->lastErrorMsg();
    }
}

function cadastrarMateriais() {
    $materialStrg = isset($_POST['material']) ? $_POST['material'] : '';
    $local = isset($_POST['local']) ? $_POST['local'] : '';
    $quantidade = isset($_POST['quantidade']) ? $_POST['quantidade'] : '';
    $deposito = isset($_POST['deposito']) ? $_POST['deposito'] : 'IA08';
    $nomeUsuario = $_SESSION['usuario'];

    if ($_SESSION['nivel'] >= 4) {
        $material = extractMaterial($materialStrg);

        $db = new SQLite3('IA08.db');

        $queryExistencia = "SELECT COUNT(*) AS EXISTE, QUANTIDADE FROM DATA1 WHERE MATERIAL = '$material' AND LOCAL = '$local'";
        $resultExistencia = $db->querySingle($queryExistencia, true);

        if ($resultExistencia !== false && $resultExistencia['EXISTE'] > 0) {
            $novaQuantidade = $resultExistencia['QUANTIDADE'] + $quantidade;
            
            $sqlAtualizarQuantidade = "UPDATE DATA1 SET QUANTIDADE = $novaQuantidade WHERE MATERIAL = '$material' AND LOCAL = '$local'";
            $resultAtualizarQuantidade = $db->exec($sqlAtualizarQuantidade);

            if ($resultAtualizarQuantidade !== false) {
                echo "Quantidade atualizada com sucesso!";
                inserirMaterialHistorico($db, $material, '', $local, $quantidade, $nomeUsuario, $deposito);
                header("Location: OpValidada.php");
                exit;
            } else {
                echo "Erro ao atualizar a quantidade: " . $db->lastErrorMsg();
            }
        } else {
            $queryTipo = "SELECT TIPO FROM DATA1 WHERE MATERIAL = '$material'";
            $resultTipo = $db->querySingle($queryTipo);

            if ($resultTipo !== false) {
                $tipo = $resultTipo;
            } else {
                $tipo = '';
            }

            $sql = "INSERT INTO DATA1 (MATERIAL, TIPO, LOCAL, QUANTIDADE, DEPOSITO) VALUES ('$material', '$tipo', '$local', '$quantidade', '$deposito')";
            
            $result = $db->exec($sql);
            
            if ($result !== false) {
                echo "Cadastro realizado com sucesso!";
                inserirMaterialHistorico($db, $material, $tipo, $local, $quantidade, $nomeUsuario, $deposito);
                header("Location: OpValidada.php");
                exit;
            } else {
                echo "Erro ao cadastrar: " . $db->lastErrorMsg();
            }
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
        cadastrarMateriais();
    } else {
        echo "Este script deve ser acessado via método POST.";
    }
}

main();
?>
