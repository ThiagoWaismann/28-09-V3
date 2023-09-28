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

    <!--Stylesheet -->
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
                    <div class="d-flex align-items-center justify-content-center bg-secondary rounded dp-4 p-sm-5 my-4 mx-0">
                        <meta name="viewport"  content="width=device-width, initial-scale=0.9">
                        <img src="img/W2.png" alt="5">
                    </div>
            
            
                <div class="row vh-200 bg-secondary rounded align-items-center justify-content-center mx-0">
                    
                    
                    <div class="col-md-7 text-center">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="container-fluid pt-2 px-2">
                            
                                <h3>REGISTRO DE INCIDENTES LOGÍSTICOS</h3></a>
                                    <form action="RIP.php" method="post" onsubmit="return validateForm();"></a>
                                                    ORDEM: <input type="text" class="form-control" name="ordem" id="materialInput" placeholder="INSIRA A ORDEM" required><br>
                                                    <span id="materialError" style="color: red;"></span><br>
                                                    LINHA:  <select type="text" class="form-select" name="linha" id="linhaInput" placeholder="INSIRA A LINHA" required><br>
                                                    <option value=""></option>
                                                    <option value="PREPARACAO">PREPARAÇÃO</option>
                                                    <option value="R1">R1</option>
                                                    <option value="R1">R1</option>
                                                    <option value="L1">L1</option>
                                                    <option value="L2">L2</option>
                                                    <option value="L3">L3</option>
                                                    <option value="L4">L4</option>
                                                    <option value="L5">L5</option>
                                                    <option value="L7">L7</option>
                                                    <option value="TESTE.SENSORES">TESTE.SENSORES</option>
                                                    <option value="RESINA">RESINA</option>
                                                    <option value="EMBALAGEM">EMBALAGEM</option>
                                                    <option value="LIMPEZA.RESINA">LIMPEZA.RESINA</option>
                                                    <option value="GRAVACAO">GRAVAÇÃO</option>
                                                    <option value="ULTRASSOM">ULTRASSOM</option>
                                                    </select>

                                                    <br><br>TIPO DE INCIDENTE: <select type="text" class="form-select" name="tipo" id="tipoInput" placeholder="INSIRA O TIPO" required ><br>
                                                    <option value=""></option>
                                                    <option value="ATRASO.LOGISTICO">ATRASO.LOGÍSTICO</option>
                                                    <option value="MATERIAL.FALTANTE.INTERNO">MATERIAL.FALTANTE.INTERNO</option>
                                                    <option value="MATERIAL.FALTANTE.EXTERNO">MATERIAL.FALTANTE.EXTERNO</option>
                                                    <option value="ATRASO.IA08">ATRASO.IA08</option>
                                                    <option value="ATRASO.RS01">ATRASO.RS01</option>
                                                    <option value="NAO.ENCONTRADO.IA08">MATERIAL.NÃO.ENCONTRADO.IA08</option>
                                                    <option value="NAO.ENCONTRADO.RS01">MATERIAL.NÃO.ENCONTRADO.RS01</option>
                                                    </select>

                                                    <br><br>MOTIVO DO INCIDENTE: <select type="text" class="form-select" name="motivo" id="tipoInput" placeholder="INSIRA O MOTIVO" required ><br>
                                                    <option value=""></option>
                                                    <option value="ATRASO.SEPARACAO">ATRASO DE SEPARAÇÃO</option>
                                                    <option value="OUTRO.DEPOSITO">MATERIAL EM OUTRO DEPÓSITO</option>
                                                    <option value="NAO.ENCONTRADO">MATERIAL NÃO ENCONTRADO</option>
                                                    <option value="SEM.ESTOQUE">SEM MATERIAL EM ESTOQUE</option>
                                                    <option value="PROMESSA">ORDEM EM PROMESSA</option>
                                                    </select>

                                                    <br>INFORMAÇÃO DO MATERIAL FALTANTE: <input type="text" class="form-control" name="material" id="motivoInput" placeholder="INSIRA O MATERIAL"  ><br>
                                                    <label for="floatingInput"></label>


                                            <div class="d-flex align-items-center justify-content-between mb-3"><br>
                                                <button type="submit" class="btn btn-primary py-3 w-100 mb-8">EXECUTAR</button><br>
                                            </div><br>
                                    </form>
                                </div>
                            </div>
                    </div>
              </div>
            </div>
                            
        </div>
    </div>
            <!-- Blank End -->


        </div>
        <!-- Content End -->


        <!-- Back to Top -->
      
    </div>

    <!-- JavaScript Libraries -->
    

    <script>
    function validarEntrada(input) {
        var valor = input.value;

        if (/^[a-zA-Z]/.test(valor)) {
            input.setCustomValidity('');
        } else {
            input.setCustomValidity('A linha deve começar com uma letra.');
        }
    }
    </script>

    <script>
    function validateForm() {
        var materialInput = document.getElementById("materialInput").value;
        var materialError = document.getElementById("materialError");
        
        if (materialInput.length !== 10) {
            materialError.textContent = "O valor da ordem deve ter exatamente 10 caracteres.";
            return false; 
        } else {
            materialError.textContent = ""; 
        }
        
        
        return true;
    }
    </script>

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