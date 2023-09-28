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

    <!--Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Sidebar Start -->
        <div class="sidebar pe-5 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="inicial.php" class="navbar-brand mx-2 mb-3">
                    <h3 class="text-primary"></i>KANBAN IA08</h3><br>
                </a>
                <a href="CSTBL.php" class="navbar-brand mx-2 mb-3">
                    <h4 class="text-primary"></i> &#9500;HISTÓRICO</h4>
                </a>
                <a href="logout.php" class="navbar-brand mx-2 mb-3">
                    <h4 class="text-primary"></i>&#9500;LOGOUT</h4>
                </a>
                <a href="MCSL.php" class="navbar-brand mx-2 mb-3">
                    <h4 class="text-primary"></i>&#9500;CORREÇÃO</h4>
                </a>
                <a href="BOSAPL.php" class="navbar-brand mx-2 mb-3">
                    <h4 class="text-primary"></i>&#9500;BAIXA SAP</h4>
                </a>
                <a href="QNL.php" class="navbar-brand mx-2 mb-3">
                    <h4 class="text-primary"></i>&#9500;NIVELAMENTO</h4>
                </a>
                <div class="d-flex align-items-center ms-2 mb-5"></div>
                <div class="navbar-nav w-100">
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Blank Start -->
            <div class="container-fluid pt-2 px-2">
                    <div class="d-flex align-items-center justify-content-center bg-secondary rounde dp-4 p-sm-5 my-4 mx-3">
                        <meta name="viewport"  content="width=device-width, initial-scale=0.9">
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
                <div class="row vh-200 bg-secondary rounded align-items-center justify-content-center mx-0">
                    <div class="d-flex align-items-center justify-content-center">
                        <meta name="viewport"  content="width=device-width, initial-scale=1.0">
                        <div class="col-md-7 text-center  ">
                            <div class="container-fluid pt-2 px-2">
                            <br><h3>GERADOR DE INDICADORES DE ATRASO DE ORDENS DE PRODUÇÃO</h3><br><hr>

                            
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <br><label for="data"><h4>INSIRA UMA DATA DE INÍCIO:</h4></label>
                                <input type="text" id="data_inicio" name="data_inicio" class="form-control" placeholder="INSIRA A DATA NO SEGUINTE FORMATO: DD/MM/AAAA" required><br>

                                <label for="data_fim"><h4>DATA DE TÉRMINO:</h4></label>
                                <input type="text" id="data_fim" name="data_fim" class="form-control" placeholder="INSIRA A DATA DE TÉRMINO NO FORMATO: DD/MM/AAAA" required><br>
                                
                                <label for="linha"><h4>LINHA:</h4></label>
                                <select name="linha[]" class="form-select" id="linha"  required>
                                            <option value=""></option>
                                            <option value="GERAL">GERAL</option>
                                            <option value="PREPARACAO">PREPARAÇÃO</option>
                                            <option value="L1">L1</option>
                                            <option value="L2">L2</option>
                                            <option value="L3">L3</option>
                                            <option value="L4">L4</option>
                                            <option value="L5">L5</option>
                                            <option value="L7">L7</option>
                                            <option value="GRAV.RELE">GRAV.RELE</option>
                                            <option value="TESTE.SENSORES">TESTE.SENSORES</option>
                                            <option value="RESINA">RESINA</option>
                                            <option value="EMBALAGEM">EMBALAGEM</option>
                                            <option value="LIMPEZA.RESINA">LIMPEZA.RESINA</option>
                                            <option value="GRAVACAO">GRAVAÇÃO</option>
                                            <option value="ULTRASSOM">ULTRASSOM</option>
                                           
                                    </select><br>

                                <input type="submit" value="Gerar Gráficos" class="btn btn-primary py-3 w-100 mb-4"><br><br><br><br><br><br><br>
                            </form>

                            <?php
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    if (isset($_POST["data_inicio"], $_POST["data_fim"], $_POST["linha"])) {
                                        $data_inicio = $_POST["data_inicio"];
                                        $data_fim = $_POST["data_fim"];
                                        $linhas = $_POST["linha"];

                                        $db = new SQLite3('OP.db');

                                        echo "<h4>Gráfico para a opção selecionada do período de $data_inicio a $data_fim:</h4>";

                                        $query = "SELECT LINHA, 
                                                        SUM(CASE WHEN TIPO = 'ATRASO.LOGISTICO' THEN 1 ELSE 0 END) AS ATRASO_LOGISTICO,
                                                        SUM(CASE WHEN TIPO = 'MATERIAL.FALTANTE.INTERNO' THEN 1 ELSE 0 END) AS MATERIAL_FALTANTE_INTERNO,
                                                        SUM(CASE WHEN TIPO = 'MATERIAL.FALTANTE.EXTERNO' THEN 1 ELSE 0 END) AS MATERIAL_FALTANTE_EXTERNO,
                                                        SUM(CASE WHEN TIPO = 'ATRASO.IA08' THEN 1 ELSE 0 END) AS ATRASO_IA08,
                                                        SUM(CASE WHEN TIPO = 'ATRASO.RS01' THEN 1 ELSE 0 END) AS ATRASO_RS01,
                                                        SUM(CASE WHEN TIPO = 'NAO.ENCONTRADO.IA08' THEN 1 ELSE 0 END) AS NAO_ENCONTRADO_IA08,
                                                        SUM(CASE WHEN TIPO = 'NAO.ENCONTRADO.RS01' THEN 1 ELSE 0 END) AS NAO_ENCONTRADO_RS01
                                                FROM INCIDENTES
                                                WHERE DATA BETWEEN :data_inicio AND :data_fim
                                                GROUP BY LINHA";

                                        if (!in_array("Todas", $linhas)) {
                                            $query .= " HAVING LINHA IN ('" . implode("','", $linhas) . "')";
                                        }

                                        $stmt = $db->prepare($query);
                                        $stmt->bindValue(':data_inicio', $data_inicio, SQLITE3_TEXT);
                                        $stmt->bindValue(':data_fim', $data_fim, SQLITE3_TEXT);
                                        $result = $stmt->execute();

                                        $dadosFiltrados = [];

                                        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                                            $dadosFiltrados[] = $row;
                                        }

                                        criarGraficoBarras($dadosFiltrados);

                                        $db->close();
                                    } else {
                                        echo "Campos do formulário não foram enviados corretamente.";
                                    }
                                } else {
                                    echo "PREENCHA TODOS OS CAMPOS PARA GERAR O GRÁFICO.";
                                }

                                function criarGraficoBarras($dados) {
                                    $labels = array_column($dados, 'LINHA');
                                    $atrasoLogistico = array_column($dados, 'ATRASO_LOGISTICO');
                                    $materialFaltanteInterno = array_column($dados, 'MATERIAL_FALTANTE_INTERNO');
                                    $materialFaltanteExterno = array_column($dados, 'MATERIAL_FALTANTE_EXTERNO');
                                    $atrasoIa08 = array_column($dados, 'ATRASO_IA08');
                                    $atrasoRs01 = array_column($dados, 'ATRASO_RS01');
                                    $NaoEncontradoIA08 = array_column($dados, 'NAO_ENCONTRADO_IA08');
                                    $NaoEncontradoRS01 = array_column($dados, 'NAO_ENCONTRADO_RS01');

                                    $data = [
                                        'labels' => $labels,
                                        'datasets' => [
                                            [
                                                'label' => 'ATRASO.LOGISTICO',
                                                'data' => $atrasoLogistico,
                                                'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                                                'borderColor' => 'rgba(75, 192, 192, 1)',
                                                'borderWidth' => 1
                                            ],
                                            [
                                                'label' => 'MATERIAL.FALTANTE.INTERNO',
                                                'data' => $materialFaltanteInterno,
                                                'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                                                'borderColor' => 'rgba(255, 99, 132, 1)',
                                                'borderWidth' => 1
                                            ],
                                            [
                                                'label' => 'MATERIAL.FALTANTE.EXTERNO',
                                                'data' => $materialFaltanteExterno,
                                                'backgroundColor' => 'rgba(250, 250, 132, 0.2)',
                                                'borderColor' => 'rgba(250, 250, 66, 1)',
                                                'borderWidth' => 1
                                            ],
                                            [
                                                'label' => 'ATRASO.IA08',
                                                'data' => $atrasoIa08,
                                                'backgroundColor' => 'rgba(255, 23, 3, 0.2)',
                                                'borderColor' => 'rgba(255, 2, 66, 1)',
                                                'borderWidth' => 1
                                            ],
                                            [
                                                'label' => 'ATRASO.RS01',
                                                'data' => $atrasoRs01,
                                                'backgroundColor' => 'rgba(32, 244, 60, 0.2)',
                                                'borderColor' => 'rgba(32, 244, 66, 1)',
                                                'borderWidth' => 1
                                            ],
                                            [
                                                'label' => 'NAO.ENCONTRADO.IA08',
                                                'data' => $NaoEncontradoIA08,
                                                'backgroundColor' => 'rgba(255, 0, 271, 0.2)',
                                                'borderColor' => 'rgba(255, 2, 66, 1)',
                                                'borderWidth' => 1
                                            ],
                                            [
                                                'label' => 'NAO.ENCONTRADO.RS01',
                                                'data' => $NaoEncontradoRS01,
                                                'backgroundColor' => 'rgba(0, 125, 0, 0.2)',
                                                'borderColor' => 'rgba(255, 2, 66, 1)',
                                                'borderWidth' => 1
                                            ]
                                        ]
                                    ];

                                    $options = [
                                        'scales' => [
                                            'y' => [
                                                'beginAtZero' => true,
                                                
                                            ]
                                        ]
                                    ];

                                    echo '<canvas id="barChart" width="600" height="400"></canvas>';
                                    echo '<script>
                                            var ctx = document.getElementById("barChart").getContext("2d");
                                            var myBarChart = new Chart(ctx, {
                                                type: "bar",
                                                data: ' . json_encode($data) . ',
                                                options: ' . json_encode($options) . '
                                            });
                                        </script>';

                                    foreach ($dados as $row) {
                                        echo '<p>Linha: ' . $row['LINHA'] . '</p>';
                                        
                                        $atrasoLogistico = intval($row['ATRASO_LOGISTICO']);
                                        
                                        $materialFaltanteInterno = intval($row['MATERIAL_FALTANTE_INTERNO']);
                                        $materialFaltanteExterno = intval($row['MATERIAL_FALTANTE_EXTERNO']);
                                        
                                        $atrasoIa08 = intval($row['ATRASO_IA08']);
                                        $atrasoRs01 = intval($row['ATRASO_RS01']);

                                        $NaoEncontradoIA08 = intval($row['NAO_ENCONTRADO_IA08']);
                                        $NaoEncontradoRS01 = intval($row['NAO_ENCONTRADO_RS01']);


                                        $total = $atrasoLogistico + $materialFaltanteInterno + $materialFaltanteExterno + $atrasoIa08 + $atrasoRs01 + $NaoEncontradoIA08 + $NaoEncontradoRS01;
                                        
                                        echo '<p>Percentual ATRASO.LOGISTICO: ' . ($atrasoLogistico / $total) * 100 . '%</p>';
                                        
                                        echo '<p>Percentual MATERIAL.FALTANTE.INTERNO: ' . ($materialFaltanteInterno / $total) * 100 . '%</p>';
                                        echo '<p>Percentual MATERIAL.FALTANTE.EXTERNO: ' . ($materialFaltanteExterno / $total) * 100 . '%</p>';
                                        
                                        echo '<p>Percentual ATRASO.IA08: ' . ($atrasoIa08 / $total) * 100 . '%</p>';
                                        echo '<p>Percentual ATRASO.RS01: ' . ($atrasoRs01 / $total) * 100 . '%</p>';

                                        echo '<p>Percentual NAO.ENCONTRADO.IA08: ' . ($NaoEncontradoIA08 / $total) * 100 . '%</p>';
                                        echo '<p>Percentual NAO.ENCONTRADO.RS01: ' . ($NaoEncontradoRS01 / $total) * 100 . '%</p>';
                                        echo '<hr>';
                                    }
                                }
                                ?>
                            
                            
                            <br><br><br><br><br><br><br><hr style="border: 6px solid white;">
                            <a href="logout.php" class="">
                                <button type="submit" class="btn btn-primary py-3 w-100 mb-4">DESCONECTAR</button>
                            </a>
                            <div class="d-flex align-items-center justify-content-between mb-3"> </div>
                                       
                        </div>
                    </div>  
                </div>
            </div> 
        </div>  
     </div>
</div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!--Javascript -->
    <script src="js/main.js"></script>
</body>

</html>