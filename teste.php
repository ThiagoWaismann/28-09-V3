<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>VISÃO GERAL</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

   

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!--  Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

     <style>
        /* Estilos CSS para as abas */
        .tab {
            display: none;
        }
        .tab.active {
            display: block;
        }
        .tab-button {
            cursor: pointer;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
        }
        .tab-button.active {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container-fluid pt-2 px-2">
        <div class="d-flex align-items-center justify-content-center bg-secondary rounded p-sm-5 my-4 mx-0">
            <img src="img/W2.png" alt="5">
        </div>
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
        <div class="row vh-400 bg-secondary rounded align-items-center justify-content-center mx-0">
            <div class="d-flex align-items-center justify-content-center">
                <div class="col-md-9 text-center">
                    <div class="container-fluid pt-2 px-2">
                        <div class="d-flex align-items-center justify-content-center bg-secondary rounde dp-4 p-sm-2 my-4 mx-0">
                            <meta name="viewport"  content="width=device-width, initial-scale=0.8">
                            <br><div class="d-flex align-items-center justify-content-between mb-3"> </div>
                <div class="row vh-400 bg-secondary rounded align-items-center justify-content-center mx-0">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="col-md-9 text-center">
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $tabelaSelecionada = $_POST["tabela"];
                            $filtro = $_POST["filtro"];

                            $conn = new SQLite3('IA08.db');

                            $colunas = [];
                            $resultColumns = $conn->query("PRAGMA table_info('$tabelaSelecionada')");
                            while ($row = $resultColumns->fetchArray(SQLITE3_ASSOC)) {
                                $colunas[] = $row['name'];
                            }

                            $query = "SELECT * FROM '$tabelaSelecionada'";

                            if (!empty($filtro)) {
                                $filtro = SQLite3::escapeString($filtro);
                                $query .= " WHERE ";
                                $primeiro = true;

                                foreach ($colunas as $coluna) {
                                    if (!$primeiro) {
                                        $query .= " OR ";
                                    }
                                    $query .= "$coluna LIKE '%$filtro%'";
                                    $primeiro = false;
                                }
                            }

                            $result = $conn->query($query);

                            if ($result) {
                                echo "<br><h2>Relação de Materiais da Ordem</h2><br>";
                                echo "<div class='tabs'>";

                                $tabIndex = 0;

                                while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                                    $tabId = "tab-" . $tabIndex;
                                    echo "<button class='tab-button' onclick='openTab(event, \"$tabId\")'>Material $tabIndex</button>";
                                    echo "<div id='$tabId' class='tab'>";
                                    echo "<br><strong><h4>DETALHES PARA A SEPARAÇÃO:</h4></strong><br>";
                                    foreach ($row as $coluna => $valor) {
                                        echo "<h4><strong>$coluna:</strong> $valor</h4>";
                                        if ($coluna == "CONTENTOR") {
                                            $materialDataOP = $row["MATERIAL"];
                                            echo "<hr><hr><hr><p><strong>&darr; -- QUANTIDADE EM ESTOQUE IA08 -- &darr;</strong></p>";
                                            $queryData1 = "SELECT LOCAL, QUANTIDADE FROM DATA1 WHERE MATERIAL = '$materialDataOP'";
                                            $resultData1 = $conn->query($queryData1);
                                            if ($resultData1) {
                                                while ($rowData1 = $resultData1->fetchArray(SQLITE3_ASSOC)) {
                                                    $local = $rowData1["LOCAL"];
                                                    $quantidade = $rowData1["QUANTIDADE"];
                                                    echo "<p><strong>LOCAL:</strong> $local <strong> QUANTIDADE:</strong> $quantidade </p>";
                                                }
                                            }
                                        }
                                    }
                                    echo "</div>";
                                    $tabIndex++;
                                }

                                echo "</div>";
                            } else {
                                echo "Erro ao executar consulta: " . $conn->lastErrorMsg();
                            }

                        } else {
                            //header("Location: GetData.php"); 
                            exit;
                        }

                        $conn->close();
                        ?>
                    </div>
                </div>                        
                <br>
                <div class="row vh-200 bg-secondary rounded align-items-center justify-content-center mx-0">
                    <div class="col-md-7 text-center">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="container-fluid pt-2 px-2">

                <form action="TMCOP.php" id="consultaForm" method="post" onsubmit="return validateForm();">
                    ORDEM:<br> <input type="text" class="form-control" name="ordem" id="ordem" placeholder="INSIRA A ORDEM" required>

                    MATERIAL:<br> <input type="text" class="form-control" name="material" id="floatingInput" placeholder="INSIRA O MATERIAL" required>

                    LOCAL:<br> <input type="text" class="form-control" name="local" id="floatingInput" placeholder="INSIRA A LOCALIZAÇÃO" required>

                    LINHA: <br> <input type="text" class="form-control" name="tabela_destino" id="floatingInput" placeholder="INSIRA A LINHA" required oninput="validarEntrada(this)">

                    QUANTIDADE: <br> <input type="number" class="form-control" name="quantidade" id="floatingInput" placeholder="INSIRA A QUANTIDADE" required>

                    <label for="floatingInput"></label>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">TRANSFERIR</button><br>
                    </div>
                </form>

                <a href="inicial.php" class="">
                    <button type="submit" class="btn btn-primary py-3 w-100 mb-4">MENU INICIAL</button>
                </a>
            </div>
        </div>
    </div>
    <script>
        function openTab(evt, tabId) {
            var i, tabContent, tabButtons;
            tabContent = document.getElementsByClassName("tab");
            for (i = 0; i < tabContent.length; i++) {
                tabContent[i].style.display = "none";
            }
            tabButtons = document.getElementsByClassName("tab-button");
            for (i = 0; i < tabButtons.length; i++) {
                tabButtons[i].className = tabButtons[i].className.replace(" active", "");
            }
            document.getElementById(tabId).style.display = "block";
            evt.currentTarget.className += " active";
        }
        document.getElementsByClassName("tab-button")[0].click();
    </script>
</body>
</html>
