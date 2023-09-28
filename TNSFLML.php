<!DOCTYPE html>
<html lang="en">

<head>

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
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="inicial.php" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                
            </nav>
            <!-- Navbar End -->


            <!-- Blank Start -->
            <div class="container-fluid pt-2 px-2">
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
                    
                    
                <div class="col-md-10 text-center">
                <div class="container-fluid pt-2 px-2">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="container-fluid pt-2 px-2">
                                <h3>GUARDAR MATERIAIS</h3>
                                <form action="TNSFLMP.php" method="post" onsubmit="return validateForm();">
                                    MATERIAL: <input type="text" class="form-control" name="material" id="materialInput" placeholder="INSIRA O MATERIAL" required><br>

                                    LOCAL SAÍDA: <input type="text" class="form-control" name="localS" id="localSInput" placeholder="INSIRA A LOCALIZAÇÃO" required>
                                    <span id="localSError" style="color: red;"></span><br>
                                    LOCAL ENTRADA: <input type="text" class="form-control" name="localE" id="localEInput" placeholder="INSIRA A LOCALIZAÇÃO" required>
                                    <span id="localEError" style="color: red;"></span><br>
                                    
                                    QUANTIDADE: <input type="number" class="form-control" name="quantidade" id="quantidadeInput" placeholder="INSIRA A QUANTIDADE" required><br>
                                    <label for="floatingInput"></label>
                                    <div class="d-flex align-items-center justify-content-between mb-3"><br>
                                        <button type="submit" class="btn btn-primary py-3 w-100 mb-8">GUARDAR</button><br>
                                    </div><br>
                                </form>
                                <a href="inicial.php" class="">
                                    <button type="submit" class="btn btn-primary py-3 w-100 mb-4">RETORNAR AO MENU INICIAL</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            function validateForm() {
                var localSInput = document.getElementById("localSInput").value;
                var localEInput = document.getElementById("localEInput").value;
                
                var localSPattern = /^\d{2}\.\d{2}\.\d{2}$/;
                var localEPattern = /^\d{2}\.\d{2}\.\d{2}$/;
                
                var localSError = document.getElementById("localSError");
                var localEError = document.getElementById("localEError");
                
                if (!localSPattern.test(localSInput)) {
                    localSError.textContent = "Formato inválido para o LOCAL SAÍDA, insira no seguinte formato (00.00.00)";
                    return false; 
                } else {
                    localSError.textContent = ""; 
                }
                
                if (!localEPattern.test(localEInput)) {
                    localEError.textContent = "Formato inválido para o LOCAL ENTRADA, insira no seguinte formato (00.00.00)";
                    return false; 
                } else {
                    localEError.textContent = ""; 
                }
                
                return true;
            }
            </script>
  



                                
               
            <!-- Blank End -->


            <!-- Footer Start -->
           
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
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

    <!--  Javascript -->
    <script src="js/main.js"></script>
</body>

</html>