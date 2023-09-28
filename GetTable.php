<?php
if (isset($_POST['ordem'])) {
    ob_start(); 
    $ordem = $_POST['ordem'];
    $dbIA08 = new SQLite3("IA08.db");

    $queryIA08 = "SELECT MATERIAL, QUANTIDADE, JJ, CONTENTOR, TIPO FROM DATAOP WHERE ORDEM = '$ordem'";
    $resultIA08 = $dbIA08->query($queryIA08);

    $htmlContent = '';

    if ($resultIA08) {
        while ($rowIA08 = $resultIA08->fetchArray(SQLITE3_ASSOC)) {
            $local = $rowIA08["LOCAL"];
            $quantidade = $rowIA08["QUANTIDADE"];
            $material = $rowIA08["MATERIAL"];
            $contentor = $rowIA08["CONTENTOR"];
            $jj = $rowIA08["JJ"];
            $tipo = $rowIA08["TIPO"];

            // Concatene o conteúdo HTML em vez de usar echo
            $htmlContent .= "<strong><br><h6>Tipo:</strong> $tipo<br></h6>";
            $htmlContent .= "<strong><h6>JUNJO:</strong> $jj<br></h6>";
            $htmlContent .= "<strong><h6>Contentor:</strong> $contentor<br></h6>";
        }
    } else {
        $htmlContent = "Nenhum resultado encontrado na tabela DATAOP.";
    }

    ob_end_clean();

 
}
?>
