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
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Sidebar Start -->
        <div class="sidebar pe-5 pb-4">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="inicial.php" class="navbar-brand mx-2 mb-3">
                    <h3 class="text-primary"></i>KANBAN IA08</h3><br>
                </a>
                <a href="CSTBL.php" class="navbar-brand mx-2 mb-3">
                    <h5 class="text-primary"></i> &#9500;HISTÓRICO</h5>
                </a>
                <a href="logout.php" class="navbar-brand mx-2 mb-3">
                    <h5 class="text-primary"></i>&#9500;LOGOUT</h5>
                </a>
                <a href="MCSL.php" class="navbar-brand mx-2 mb-3">
                    <h5 class="text-primary"></i>&#9500;CORREÇÃO</h5>
                </a>
                <a href="BOSAPL.php" class="navbar-brand mx-2 mb-3">
                    <h5 class="text-primary"></i>&#9500;BAIXA SAP</h5>
                </a>
                <a href="QNL.php" class="navbar-brand mx-2 mb-3">
                    <h5 class="text-primary"></i>&#9500;NIVELAMENTO</h5>
                </a>
                <a href="GG.php" class="navbar-brand mx-2 mb-3">
                    <h5 class="text-primary"></i>&#9500;GRÁFICOS</h5>
                </a>
                <a href="RIG.php" class="navbar-brand mx-2 mb-3">
                    <h5 class="text-primary"></i>&#9500;GRÁFICO INCIDENTES</h5>
                </a>
                <a href="RIL.php" class="navbar-brand mx-2 mb-3">
                    <h5 class="text-primary"></i>&#9500;REPORTE INCIDENTES</h5>
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
                            <br><h3>SELECIONE UMA OPÇÃO PARA INICIAR</h3><br>
                            
                            <a href="BuscarOP.php" class="">
                                <button type="submit" class="btn btn-primary py-3 w-100 mb-4">SEPARAR MATERIAIS</button>
                            </a>
                            <a href="MATERIALL.php" class="">
                                <button type="submit" class="btn btn-primary py-3 w-100 mb-4">GUARDAR MATERIAIS</button>
                            </a>
                            <a href="consultarF.php" class="">
                                <button type="submit" class="btn btn-primary py-3 w-100 mb-4">LOCALIZAR MATERIAL</button>
                            </a>
                            <a>
                            <a href="TMSOL.php" class="">
                                <button type="submit" class="btn btn-primary py-3 w-100 mb-4">TRANSFERIR MATERIAL SEM ORDEM</button>
                            </a>
                            <hr style="border: 6px solid white;">
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