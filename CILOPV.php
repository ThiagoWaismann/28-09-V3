<!DOCTYPE html>
<html lang="en">

<head>
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
    <meta charset="utf-8">
    <title>IA08</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

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

    <style>
    .bg-custom {
        background-color: #191970; 
    }
</style>
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
         <div class="sidebar bg-custom pe-5 pb-3">
            <nav class="navbar bg-custom navbar-dark">
                <a href="CIIL.php" class="navbar-brand mx-3 mb-2">
                    <h3 class="text-primary"></i>CENTRAL DE</h3>
                    
                    <h3 class="text-primary"></i>IMPRESSÕES</h3><br>
                </a>
                
                <a href="LOGOUTCI.php" class="navbar-brand mx-2 mb-3">
                    <h4 class="text-primary"></i>&#9500;LOGOUT</h4>
                </a>
                
                <div class="d-flex align-items-center ms-2 mb-5"></div>
                <div class="navbar-nav w-100">
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            
            <!-- Navbar End -->


            <!-- 404 Start -->
            <div class="container-fluid pt-2 px-2">
                <div class="row vh-100 bg-custom rounded align-items-center justify-content-center mx-0">
                    <div class="col-md-6 text-center p-4">
                        <i class="bi bi-V-triangle display-1 text-primary"></i>
                        <!--h1 class="display-1 fw-bold">403</h1-->
                        <h1 class="mb-4">LIBERAÇÃO DE ORDEM CONCLUIDA</h1>
                        <!--p class="mb-4">Selecione uma das opções abaixo para prossguir:</p-->
                        <a class="btn btn-primary rounded-pill py-3 px-5" href="CILOL.php">OK</a>
                        <!--a class="btn btn-primary rounded-pill py-3 px-5" href="BOSAPL.php">BAIXAR MAIS ORDENS</a-->
                        <h1 class=""></h1>
                    </div>
                </div>
            </div>
            <!-- 404 End -->


            
        </div>
        <!-- Content End -->


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