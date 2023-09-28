<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    $_SESSION['nivel'] = $nivelUsuario;
    exit;
}

if ($_SESSION['nivel'] != -2) {
    header("Location: 403.php");
    exit;
}

$nomeUsuario = $_SESSION['usuario'];
echo $nomeUsuario;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["ordem"], $_POST["linha"], $_POST["tipo"], $_POST["motivo"], $_POST["material"])) {
        $linhas = $_POST["linha"];
        
        if (!is_array($linhas)) {
            $linhas = [$linhas];
        }

        $material = $_POST["material"];
        $ordem = $_POST["ordem"];
        $tipo = $_POST["tipo"];
        $motivo = $_POST["motivo"];
        $usuario = $_SESSION["usuario"];
        date_default_timezone_set('America/Sao_Paulo');
        $data = date('d/m/Y');

        $db = new SQLite3("OP.db");
        $query = "INSERT INTO `INCIDENTES` (LINHA, ORDEM, TIPO, MOTIVO, MATERIAL, USUARIO, DATA) VALUES (:linha, :ordem, :tipo, :motivo, :material, :usuario, :data)";
        $stmt = $db->prepare($query);
        $stmt->bindValue(":linha", implode(', ', $linhas), SQLITE3_TEXT); 
        $stmt->bindValue(":ordem", $ordem, SQLITE3_TEXT);
        $stmt->bindValue(":tipo", $tipo, SQLITE3_TEXT);
        $stmt->bindValue(":motivo", $motivo, SQLITE3_TEXT);
        $stmt->bindValue(":material", $material, SQLITE3_TEXT);
        $stmt->bindValue(":usuario", $usuario, SQLITE3_TEXT);
        $stmt->bindValue(":data", $data, SQLITE3_TEXT);
        $result = $stmt->execute();

        header("Location: inicial.php");

        $db->close();
    } else {
        echo "Campos do formulário não foram enviados corretamente.";
    }
} else {
    echo "Acesso inválido.";
}
?>
