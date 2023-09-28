<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>VISAO GERAL</title>
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
                            <br><h3>PREENCHA OS CAMPOS PARA INICIAR</h3><br>

                            
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <label for="data"><h4>INSIRA UMA DATA:</h4></label>
                                <input type="text" id="data" name="data" class="form-control" placeholder="INSIRA A DATA NO SEGUINTE FORMATO: DD/MM/AAAA" required><br>
                                
                                <label for="linha"><h4>LINHA:</h4></label>
                                <select name="linha[]" class="form-select" id="linha"  required>
                                            <option value=""></option>
                                            <option value="Todas">TODAS</option> 
                                            <option value="K7_512">K7_512</option>
                                            <option value="K7_507">K7_507</option>
                                           
                                    </select><br>

                                <input type="submit" value="Gerar Gráficos" class="btn btn-primary py-3 w-100 mb-4"><br><br><br><br><br><br><br>
                            </form>

                            <?php
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                $data = $_POST["data"];
                                $linhas = $_POST["linha"];

                                $db = new SQLite3('IA08.db');

                                echo "<h4>Gráfico para a opção selecionada do dia $data:</h4>";

                                $query = "SELECT DATE(DATA) AS DIA, LINHA, SUM(QUANTIDADE) AS TOTAL_QUANTIDADE
                                        FROM BAIXA_K7
                                        WHERE DATA LIKE :data";
                                
                                if (!in_array("Todas", $linhas)) {
                                    $query .= " AND LINHA IN ('" . implode("','", $linhas) . "')";
                                }
                                
                                $query .= " GROUP BY DIA, LINHA";
                                
                                $stmt = $db->prepare($query);
                                $stmt->bindValue(':data', '%' . $data . '%', SQLITE3_TEXT); 
                                $result = $stmt->execute();

                                $dadosFiltrados = [];

                                while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                                    $dadosFiltrados[] = $row;
                                }

                                $dias = array_unique(array_column($dadosFiltrados, 'DIA'));

                                foreach ($dias as $dia) {
                                    $dadosPorDia = array_filter($dadosFiltrados, function($item) use ($dia) {
                                        return $item['DIA'] === $dia;
                                    });

                                    criarGraficoBarras($dia, $dadosPorDia);
                                }
                                
                                $db->close();
                            }

                            function criarGraficoBarras($dia, $dadosPorDia) {
                                $labels = array_column($dadosPorDia, 'LINHA');
                                $quantidades = array_column($dadosPorDia, 'TOTAL_QUANTIDADE');
                                
                                $data = [
                                    'labels' => $labels,
                                    'datasets' => [
                                        [
                                            'label' => $dia,
                                            'data' => $quantidades,
                                            'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                                            'borderColor' => 'rgba(75, 192, 192, 1)',
                                            'borderWidth' => 1
                                        ]
                                    ]
                                ];

                                $options = [
                                    'scales' => [
                                        'y' => [
                                            'beginAtZero' => true
                                        ]
                                    ]
                                ];

                                echo '<canvas id="barChart-' . $dia . '" width="400" height="200"></canvas>';
                                echo '<script>
                                        var ctx = document.getElementById("barChart-' . $dia . '").getContext("2d");
                                        var myBarChart = new Chart(ctx, {
                                            type: "bar",
                                            data: ' . json_encode($data) . ',
                                            options: ' . json_encode($options) . '
                                        });
                                    </script>';
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