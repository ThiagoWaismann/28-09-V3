<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Consulta</title>
    <meta charset="utf-8">
    <title>VISÃO GERAL</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <!--link href="img/favicon.ico" rel="icon"-->

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

    
</head>
<body>
    <!-- Sidebar Start -->
    <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="inicial.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"></i>KANBAN IA08</h3><br>
                </a>

                
                <a href="CSTBL.php" class="navbar-brand mx-4 mb-3">
                    <h4 class="text-primary"></i> &#9500;HISTÓRICO</h4>
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
            <!-- Blank Start -->
            
            <div class="container-fluid pt-2 px-2">
                
                    <div class="d-flex align-items-center justify-content-center bg-secondary rounde dp-4 p-sm-5 my-4 mx-3">
                        <meta name="viewport"  content="width=device-width, initial-scale=0.9">
                        <img src="img/W2.png" alt="5">
                    </div>
                    <div class="row vh-200 bg-secondary rounded align-items-center justify-content-center mx-0">
                    
                    <div class="d-flex align-items-center justify-content-center">
                        <meta name="viewport"  content="width=device-width, initial-scale=1.0">
                        
                        
                    
                        <div class="col-md-7 text-center  ">
                            <div class="container-fluid pt-2 px-2">
                    
                                
                    <h2>RESULTADO DA CONSULTA</h2>
            
                                <?php
                                session_start();

                                if (!isset($_SESSION['usuario'])) {
                                    header("Location: login.php");
                                    exit;
                                }

                                if (isset($_SESSION['resultados_consulta'])) {
                                    $resultados = $_SESSION['resultados_consulta'];

                                    if (!empty($resultados)) {
                                        foreach ($resultados as $resultado) {
                                            echo '<hr style="border; border-top: 4px dashed #Ff0000; margin: 40px 0;">';
                                            
                                            echo '<br><br>';
                                            echo '<p><strong>MATERIAL:</strong> ' . $resultado['MATERIAL'] . '</p>';
                                            echo '<p><strong>TIPO:</strong> ' . $resultado['TIPO'] . '</p>';

                                            if (isset($resultado['TOTAL_QUANTIDADE'])) {
                                                echo '<p><strong>TOTAL QUANTIDADE:</strong> ' . $resultado['TOTAL_QUANTIDADE'] . '</p>';
                                            }

                                            if (isset($resultado['DEPOSITO'])) {
                                                echo '<p><strong>DEPOSITO:</strong> ' . $resultado['DEPOSITO'] . '</p>';
                                            }

                                            if (isset($resultado['LOCAL'])) {
                                                echo '<p><strong>LOCAL:</strong> ' . $resultado['LOCAL'] . '</p>';
                                            }

                                            echo '<br><br>';
                                        }
                                    } else {
                                        echo '<p>Nenhum resultado encontrado.</p>';
                                    }
                                } else {
                                    echo '<p>Nenhum resultado encontrado.</p>';
                                }
                                ?>
                        
                        <a href="consultarF.php" class="">
                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">FAZER UMA NOVA BUSCA</button>
                        </a>
                        <a href="inicial.php" class="">
                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">RETORNAR AO MENU INICIAL</button>
                        </a>
                        
                        <div class="col-md-5 text-center">
                        
                        
                        
                        </div>

                        

                </div>
            </div>
        </div>
            <!-- Blank End -->
            <!-- ... -->
        </div>
        <!-- Content End -->
        <!-- ... -->
    </div>

    <!--   JavaScript  -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!--  Javascript -->
    <script src="js/main.js"></script>

</body>
</html>
