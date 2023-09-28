<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    $_SESSION['nivel'] = $nivelUsuario;
    exit;
}

if ($_SESSION['nivel'] != 0) {
    header("Location: 403.php");
    exit;
}

$nomeUsuario = $_SESSION['usuario'];
echo $nomeUsuario;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["material"], $_POST["quantidade"])) {
        $material = $_POST["material"];
        $quantidade = $_POST["quantidade"];
        $operation = "0030";
        $usuario = $_SESSION["usuario"];
        $linha = $_POST["linha"];

        date_default_timezone_set('America/Sao_Paulo');
        $data = date('d/m/Y - H:i:s');

        $db = new SQLite3("IA08.db");
        $query = "INSERT INTO `BAIXA_K7` (ORDEM, QUANTIDADE, OPERACAO, DATA, USUARIO, LINHA) VALUES (:ordem, :quantidade, :operacao, :data, :usuario, :linha)";
        $stmt = $db->prepare($query);
        $stmt->bindValue(":ordem", $material, SQLITE3_TEXT);
        $stmt->bindValue(":quantidade", $quantidade, SQLITE3_INTEGER);
        $stmt->bindValue(":operacao", $operation, SQLITE3_TEXT);
        $stmt->bindValue(":data", $data, SQLITE3_TEXT);
        $stmt->bindValue(":usuario", $usuario, SQLITE3_TEXT);
        $stmt->bindValue(":linha", $linha, SQLITE3_TEXT);
        $result = $stmt->execute();

        if ($result) {
            $fullApiUrl = "http://10.1.75.70:81/wdc-mes/sap-productionconfirmation?productionconfirmation="
                . urlencode('{"productionorder":"' . $material . '","operation":"' . $operation . '","quantity":' . $quantidade . ',"scrapqty":0}');

            $ch = curl_init($fullApiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $apiResponse = curl_exec($ch);

            if ($apiResponse === false) {
                echo "Erro ao fazer a chamada à API.";
            } else {
                echo "Dados inseridos no banco de dados e resposta da API: " . $apiResponse;
            }

            curl_close($ch);

            header("Location: BOSAPV.php");
            exit;
        } else {
            echo "Erro ao inserir dados no banco de dados.";
        }

        $db->close();
    } else {
        echo "Campos do formulário não foram enviados corretamente.";
    }
} else {
    echo "Acesso inválido.";
}
?>
