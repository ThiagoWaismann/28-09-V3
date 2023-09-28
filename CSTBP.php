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

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        
        <!-- Spinner Start -->
        <!--div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div-->
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="inicial.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"></i>KANBAN IA08</h3><br>
                </a>

                
                <a href="CSTBL.php" class="navbar-brand mx-4 mb-3">
                    <h4 class="text-primary"></i> &#9500;HISTORICO</h4>
                </a>
                
                <a href="logout.php" class="navbar-brand mx-4 mb-3">
                    <h4 class="text-primary"></i>&#9500;LOGOUT</h4>
                </a>

                <div class="d-flex align-items-center ms-4 mb-4"></div>
                <div class="navbar-nav w-100">
                    
                    <!--div class="nav-item dropdown">
                        <a href="" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>OPÇÕES</a>
                        
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="logout.php" class="dropdown-item active">LOGOUT</a>
                            <a href="CSTBL.php" class="dropdown-item active">CONSULTAR HISTORICO</a>
                        </div>
                </div-->
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            
            <!-- Navbar Start -->
            
            <!-- Navbar End -->


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
                    <div class="row vh-400 bg-secondary rounded align-items-center justify-content-center mx-0">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="col-md-9 text-center">
                            <div class="container-fluid pt-6 px-2">
                                <?php
                                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                        $tabelaSelecionada = $_POST["tabela"];
                                        $filtro1 = $_POST["filtro1"];
                                        $filtro2 = $_POST["filtro2"];
                                    
                                        $conn = new SQLite3('IA08.db');
                                    
                                        $colunas = [];
                                        $resultColumns = $conn->query("PRAGMA table_info('$tabelaSelecionada')");
                                        while ($row = $resultColumns->fetchArray(SQLITE3_ASSOC)) {
                                            $colunas[] = $row['name'];
                                        }
                                    
                                        $query = "SELECT * FROM '$tabelaSelecionada' WHERE 1=1"; // Inicializa com "1=1" para simplificar a construção da consulta
                                    
                                        if (!empty($filtro1)) {
                                            $filtro1 = SQLite3::escapeString($filtro1);
                                            $query .= " AND (";
                                            $primeiro = true;
                                    
                                            foreach ($colunas as $coluna) {
                                                if (!$primeiro) {
                                                    $query .= " OR ";
                                                }
                                                $query .= "$coluna LIKE '%$filtro1%'";
                                                $primeiro = false;
                                            }
                                    
                                            $query .= ")";
                                        }
                                    
                                        if (!empty($filtro2)) {
                                            $filtro2 = SQLite3::escapeString($filtro2);
                                            $query .= " AND (";
                                            $primeiro = true;
                                    
                                            foreach ($colunas as $coluna) {
                                                if (!$primeiro) {
                                                    $query .= " OR ";
                                                }
                                                $query .= "$coluna LIKE '%$filtro2%'";
                                                $primeiro = false;
                                            }
                                    
                                            $query .= ")";
                                        }

                                        $result = $conn->query($query);

                                        if ($result) {
                                            echo "<h2><br>RESULTADOS DA BUSCA:</h2><br>";
                                            echo "<div class='table-responsive'>";
                                            echo "<table class='table table-bordered table-striped'>";
                                            echo "<thead>";

                                            echo "<tr>";
                                            foreach ($colunas as $coluna) {
                                                echo "<th>$coluna</th>";
                                            }
                                            echo "</tr>";

                                            echo "</thead>";
                                            echo "<tbody>";

                                            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                                                echo "<tr>";

                                                foreach ($row as $valor) {
                                                    echo "<td class='align-middle'>$valor</td>";
                                                }

                                                echo "</tr>";
                                            }

                                            echo "</tbody>";
                                            echo "</table>";
                                            echo "</div>";
                                        } else {
                                            echo "Erro ao executar consulta: " . $conn->lastErrorMsg();
                                        }

                                        $conn->close();
                                    } else {
                                        header("Location: index.php"); 
                                        exit;
                                    }
                                    ?>
                                </div>
                            </div>
                        <div class="d-flex align-items-center justify-content-between mb-3"> </div>
                            
                        </div>  
                    </div>
                </div> 
            </div>  
            <!-- Blank End -->
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

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>