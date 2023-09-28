






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>VISAO GERAL</title>
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

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

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



</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <div class="content">
            <!-- Blank Start -->
            <div class="container-fluid pt-2 px-2">
                <div class="row vh-100 bg-secondary rounded align-items-center justify-content-center mx-0">
                
                    <div class="col-md-5 text-center">
                    
                        <h3>TRANSFERIR MATERIAL COM ORDEM</h3>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                           
                            <div class="container-fluid pt-6 px-6">
                            
                                    <div>
                                    <?php
                                    $htmlContent = '';

if (isset($_POST['ordem'])) {
    ob_start();
    $ordem = $_GET['ordem'];
    $dbIA08 = new SQLite3("IA08.db");

    $queryIA08 = "SELECT MATERIAL, QUANTIDADE, JJ, CONTENTOR, TIPO FROM DATAOP WHERE ORDEM = '$ordem'";
    $resultIA08 = $dbIA08->query($queryIA08);

    if ($resultIA08) {
        while ($rowIA08 = $resultIA08->fetchArray(SQLITE3_ASSOC)) {
            $local = $rowIA08["LOCAL"];
            $quantidade = $rowIA08["QUANTIDADE"];
            $material = $rowIA08["MATERIAL"];
            $contentor = $rowIA08["CONTENTOR"];
            $jj = $rowIA08["JJ"];
            $tipo = $rowIA08["TIPO"];
            
            $htmlContent .= "<strong><br><h6>Tipo:</strong> $tipo<br></h6>";
            $htmlContent .= "<strong><h6>JUNJO:</strong> $jj<br></h6>";
            $htmlContent .= "<strong><h6>Contentor:</strong> $contentor<br></h6>";
        }
    } else {
        $htmlContent = "Nenhum resultado encontrado na tabela DATAOP.";
    }

    ob_end_clean();
}
                                         echo $htmlContent; 
                                        ?>
                                    </div>
                                    <form action="TMCOP.php" id="consultaForm" method="post">
                                        ORDEM: <input type="text" class="form-control" name="ordem" id="ordem" placeholder="INSIRA A ORDEM" required>    

                                        MATERIAL: <input type="text" class="form-control" name="material" id="floatingInput" placeholder="INSIRA O MATERIAL" required>

                                        LOCAL: <input type="text" class="form-control" name="local" id="floatingInput" placeholder="INSIRA A LOCALIZAÇÃO" required>

                                        CENTRO: <input type="text" class="form-control" name="tabela_destino" id="floatingInput" placeholder="DESTINO" required>
                                        
                                        QUANTIDADE: <input type="number" class="form-control" name="quantidade" id="floatingInput" placeholder="INSIRA A QUANTIDADE" required>

                                        <label for="floatingInput"></label>
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">TRANSFERIR</button><br>
                                </form>   
                                </div>
                            </div>
                            
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

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>