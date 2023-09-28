<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Consulta</title>
    <meta charset="utf-8">
    <title>VISAO GERAL</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
                        <?php
                        
                        session_start();
                        if (isset($_SESSION['usuario'])) {
                            $nomeUsuario = $_SESSION['usuario'];
                        } else {
                            
                            header("Location: index.php");
                            exit;
                        } 
                        $nomeUsuario = $_SESSION['usuario'];
                        
                        echo $nomeUsuario;
                        ?>

    <!-- Favicon -->
    <!--link href="img/favicon.ico" rel="icon"-->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">

</head>
<body>
<div class="container-fluid pt-2 px-2">
             <div class="d-flex align-items-center justify-content-center bg-secondary rounde dp-4 p-sm-5 my-4 mx-3">
                <meta name="viewport"  content="width=device-width, initial-scale=0.9">
                <img src="img/W2.png" alt="5">
             </div>
                <div class="row vh-200 bg-secondary rounded align-items-center justify-content-center mx-0">
                        <div class="d-flex align-items-center justify-content-center">
                            <meta name="viewport"  content="width=device-width, initial-scale=1.0">
                                <div class="col-md-7 text-center  ">
                                     <!--form method='POST' class='transfer-form'>
                                            MATERIAL:<br> <input type='text' name='material' placeholder='INSIRA O MATERIAL' required><br>

                                            LOCAL:<br> <input type='text' name='LocalSaida' placeholder='INSIRA LOCAL DE SAIDA' required><br>

                                            CENTRO:<br> <input type='text' name='TabelaDestino' placeholder='INSIRA O CENTRO' required><br>
                                            
                                            QUANTIDADE:<br> <input type='number' name='quantidade' placeholder='INSIRA A QUANTIDADE' required><br>
                                            <button type='submit' name='transfer'>Transferir</button>

                                            <label for="floatingInput"></label>
                                            <div class="d-flex align-items-center justify-content-between mb-4">
                                            
                                        </form--> 
                                    <div class="container-fluid pt-2 px-2">

                                           
                                    <?php
                                                $dbIA08 = new SQLite3("IA08.db");

                                                function realizarTransferencia($dbIA08, $material, $localSaida, $transferQuantity, $tabelaDestino) {
                                                    if (!empty($localSaida) && $transferQuantity > 0) {
                                                        $updateQuery = "UPDATE DATA1 SET QUANTIDADE = QUANTIDADE - $transferQuantity WHERE MATERIAL = '$material' AND LOCAL = '$localSaida'";
                                                        $dbIA08->exec($updateQuery);

                                                        $insertQuery = "INSERT INTO $tabelaDestino (MATERIAL, TIPO, QUANTIDADE) VALUES ('$material', '$tipo', '$transferQuantity')";
                                                        $dbIA08->exec($insertQuery);

                                                        $mensagem = "Transferência realizada com sucesso: Material $material, Local $localSaida, Quantidade $transferQuantity";
                                                        return json_encode(['success' => true, 'message' => $mensagem]);
                                                    } else {
                                                        $mensagem = "Não foi possível realizar a transferência. Certifique-se de inserir um Local válido e uma Quantidade maior que 0.";
                                                        return json_encode(['success' => false, 'message' => $mensagem]);
                                                    }
                                                }

                                                if (isset($_POST['ordem'])) {
                                                    $ordem = $_POST['ordem'];
                                                    echo "<input type='hidden' name='ordem' value='$ordem'>";
                                                    $centro = $_POST['centro'];
                                                    $maxAttempts = 30;

                                                    $dbIA08 = new SQLite3("IA08.db");

                                                    for ($attempt = 0; $attempt <= $maxAttempts; $attempt++) {
                                                        $url = "http://10.1.75.70:81/wdc-mes/sap-getordercomponents?ordemproducao=" . $ordem;
                                                        $ch = curl_init($url);
                                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                        $response = curl_exec($ch);
                                                        curl_close($ch);

                                                        if ($response !== false) {
                                                            $data = json_decode($response, true);

                                                            if (!empty($data)) {
                                                                echo "<h3>---Materiais da Ordem---</h3>";

                                                                foreach ($data as $component) {
                                                                    if (isset($component["StorageLocation"]) && $component["StorageLocation"] === "IA08") {
                                                                        $material = isset($component["Material"]) ? substr($component["Material"], -8) : "Material não disponível";
                                                                        $quantityUnitOfEntry = isset($component["QuantityUnitOfEntry"]) ? $component["QuantityUnitOfEntry"] : "Quantidade não disponível";
                                                                        $order = isset($component["Order"]) ? substr($component["Order"], -10) : "Ordem não disponível";
                                                                        $checkQuery = "SELECT MATERIAL FROM DATAOP WHERE MATERIAL = '$material' AND ORDEM = '$order'";
                                                                        $resultCheck = $dbIA08->querySingle($checkQuery);

                                                                        if (!$resultCheck) {
                                                                            $queryIA08 = "SELECT TIPO, JJ, CONTENTOR FROM JUNJO WHERE CENTRO = '$centro' AND MATERIAL = '$material'";
                                                                            $resultIA08 = $dbIA08->query($queryIA08);

                                                                            if ($resultIA08) {
                                                                                while ($rowIA08 = $resultIA08->fetchArray(SQLITE3_ASSOC)) {
                                                                                    $tipo = $rowIA08["TIPO"];
                                                                                    $jj = $rowIA08["JJ"];
                                                                                    $contentor = $rowIA08["CONTENTOR"];

                                                                                    $insertQuery = "INSERT INTO DATAOP (ORDEM, MATERIAL, QUANTIDADE, CENTRO, TIPO, JJ, CONTENTOR) VALUES ('$order', '$material', '$quantityUnitOfEntry', '$centro', '$tipo', '$jj', '$contentor')";
                                                                                    $dbIA08->exec($insertQuery);
                                                                                }
                                                                            }
                                                                        if ($resultIA08) {
                                                                            while ($rowIA08 = $resultIA08->fetchArray(SQLITE3_ASSOC)) {
                                                                                $tipo = $rowIA08["TIPO"];
                                                                                $jj = $rowIA08["JJ"];
                                                                                $contentor = $rowIA08["CONTENTOR"];

                                                                                $updateQuery = "UPDATE DATAOP SET TIPO = '$tipo', JJ = '$jj', CONTENTOR = '$contentor' WHERE MATERIAL = '$material'";
                                                                                $dbIA08->exec($updateQuery);
                                                                            }
                                                                        }
                                                                        //$queryconsultaDataop = "SELECT FROM DATAOP ORDEM, MATERIAL, QUANTIDADE, CENTRO, JJ , CONTENTOR, TIPO WHERE ORDEM = '$order' AND MATERIAL = '$material'";
                                                                        //$resultConsultaDataop = $dbIA08->exec($queryconsultaDataop);
                                                                        $queryIA08QM = "SELECT LOCAL, QUANTIDADE FROM DATA1 WHERE MATERIAL = '$material'";
                                                                        $resultIA08QM = $dbIA08->query($queryIA08QM);
                                                                        echo "<hr><hr><hr><h3><strong>Material:</strong> $material<br></h3>";
                                                                        echo "<strong><h6>Ordem:</strong> $order<br></h6>";
                                                                        echo "<br><strong><h6>Quantidade da Ordem:</strong> $quantityUnitOfEntry<br></h6><br>";

                                                                        if ($resultIA08QM) {
                                                                            $rowIA08QM = $resultIA08QM->fetchArray(SQLITE3_ASSOC);
                                                                            if ($rowIA08QM) {
                                                                                $local = $rowIA08QM["LOCAL"];
                                                                                $valore = $rowIA08QM["QUANTIDADE"];

                                                                                echo "<br><h3>-Locais de Armazenamento-</h3>";

                                                                                while ($rowIA08QM = $resultIA08QM->fetchArray(SQLITE3_ASSOC)) {
                                                                                    echo "<strong><br><h6>--Local: </strong> {$rowIA08QM['LOCAL']} - Quantidade: {$rowIA08QM['QUANTIDADE']}<br></h6>";
                                                                                }
                                                                            } else {
                                                                                echo "<Sem Resposta>";
                                                                            }
                                                                        }

                                                                        if ($resultIA08) {
                                                                            while ($rowIA08 = $resultIA08->fetchArray(SQLITE3_ASSOC)) {
                                                                                $tipo = $rowIA08["TIPO"];
                                                                                $jj = $rowIA08["JJ"];
                                                                                $contentor = $rowIA08["CONTENTOR"];

                                                                                echo "<strong><br><h6>Tipo:</strong> $tipo<br></h6>";
                                                                                echo "<strong><h6>JUNJO:</strong> $jj<br></h6>";
                                                                                echo "<strong><h6>Contentor:</strong> $contentor<br></h6>";

                                                                                if (!empty($_POST['transfer'])) {
                                                                                    $localSaida = $_POST['LocalSaida'];
                                                                                    $transferQuantity = $_POST['transferQuantity-LocalSaida'];
                                                                                    $tabelaDestino = $_POST['TabelaDestino']; 

                                                                                    $mensagem = realizarTransferencia($dbIA08, $material, $localSaida, $transferQuantity, $tabelaDestino);

                                                                                    echo "<span>$mensagem</span><br>";
                                                                                }
                                                                            }
                                                                        } else {
                                                                            echo "Nenhum resultado encontrado na tabela JUNJO.";
                                                                        }
                                                                    }}
                                                                }
                                                                break;
                                                            }
                                                        }

                                                        if ($attempt < $maxAttempts) {
                                                            sleep(0); 
                                                        }
                                                    }

                                                    if ($attempt > $maxAttempts) {
                                                        echo "<p>Erro ao fazer a consulta à API após $maxAttempts tentativas.</p>";
                                                    }

                                                    $dbIA08->close();
                                                }
                                                ?>


                                            
                                           

                                            <br><h1>INICIAR SEPARAÇÃO</h1>
                                                
                                                    <form action="teste.php" method="post">
                                                        <label style="display: none;" for="tabela"><h3>TABELA</h3></label><br>
                                                        <input style="display: none;" name="tabela" class="form-select" id="tabela" value="DATAOP"  >
                                                        
                                                        
                                                        <hr style="border: 3px solid white;">
                                                        <label  for="filtro"><h3> &darr; INSIRA A ORDEM AQUI &darr; </h3></label><br>
                                                        <input type="text" name="filtro" class="form-control" id="filtro" required><br>
                                                        <hr style="border: 3px solid white;">
                                                        <br><button type="submit" class="btn btn-primary py-3 w-100 mb-4">INICIAR</button>
                                                    </form>


                                           
                                           
                                        <div class="container-fluid pt-4 px-5">
                                            <div class="row justify-content-center">
                                                <div class="col-md-8">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                        </div>
                    
                </div>



    <!--JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script>
            $(document).ready(function () {
                $("form.transfer-form").submit(function (event) {
                    event.preventDefault(); 

                    var form = $(this);
                    var url = form.attr("action");

                    $.ajax({
                        type: "POST",
                        url: url,
                        data: form.serialize(), 
                        success: function (response) {
                            var responseData = JSON.parse(response);
                            var mensagemDiv = $("#mensagemTransferencia");

                            if (responseData.success) {
                                mensagemDiv.removeClass("alert alert-danger").addClass("alert alert-success").text(responseData.message).show();
                            } else {
                                mensagemDiv.removeClass("alert alert-success").addClass("alert alert-danger").text(responseData.message).show();
                            }
                        }
                    });
                });
            });
        </script>
    </div>

    <!--Javascript -->
    <script src="js/main.js"></script>


</body>
</html>
